<?php

namespace Tests\Feature;

use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileUploadDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_soft_delete_file_upload(): void
    {
        // Create an admin user and a therapist
        $admin = User::factory()->create(['admin' => true]);
        $therapist = User::factory()->create(['admin' => false]);

        // Create a file upload for the therapist
        $fileUpload = FileUpload::factory()->create([
            'user_id' => $therapist->id,
            'file_name' => 'test-document.pdf',
            'file_path' => 'uploads/forms/therapist/'.$therapist->id.'/',
            'document_type' => 'clinical_license',
        ]);

        // Ensure the file exists before deletion
        $this->assertDatabaseHas('file_uploads', [
            'id' => $fileUpload->id,
            'deleted_at' => null,
        ]);

        // Admin attempts to delete the file
        $response = $this->actingAs($admin)
            ->withoutMiddleware()
            ->delete(route('fileDelete', $fileUpload->id));

        // Check that the response redirects back to forms page
        $response->assertRedirect(route('therapist.forms', $therapist->id));
        $response->assertSessionHas('success', 'Document deleted successfully.');

        // Verify the file is soft deleted (deleted_at is not null)
        $this->assertSoftDeleted('file_uploads', [
            'id' => $fileUpload->id,
        ]);

        // Verify that the file doesn't appear in normal queries
        $this->assertCount(0, FileUpload::where('user_id', $therapist->id)->get());
    }

    public function test_non_admin_cannot_delete_file_upload(): void
    {
        // Create two regular users (therapists)
        $therapist1 = User::factory()->create(['admin' => false]);
        $therapist2 = User::factory()->create(['admin' => false]);

        // Create a file upload for therapist1
        $fileUpload = FileUpload::factory()->create([
            'user_id' => $therapist1->id,
            'file_name' => 'test-document.pdf',
            'file_path' => 'uploads/forms/therapist/'.$therapist1->id.'/',
            'document_type' => 'clinical_license',
        ]);

        // Therapist2 (non-admin) attempts to delete therapist1's file
        $response = $this->actingAs($therapist2)
            ->withoutMiddleware()
            ->delete(route('fileDelete', $fileUpload->id));

        // Check that the user is redirected back with an error
        $response->assertRedirect();
        $response->assertSessionHas('error', 'You are not authorized to delete documents.');

        // Verify the file is NOT deleted
        $this->assertDatabaseHas('file_uploads', [
            'id' => $fileUpload->id,
            'deleted_at' => null,
        ]);
    }

    public function test_deleted_files_do_not_appear_in_forms_view(): void
    {
        // Create an admin user and a therapist
        $admin = User::factory()->create(['admin' => true]);
        $therapist = User::factory()->create(['admin' => false]);

        // Create a file upload for the therapist
        $fileUpload = FileUpload::factory()->create([
            'user_id' => $therapist->id,
            'file_name' => 'test-document.pdf',
            'file_path' => 'uploads/forms/therapist/'.$therapist->id.'/',
            'document_type' => 'clinical_license',
        ]);

        // First, verify the file appears in the forms view
        $response = $this->actingAs($admin)
            ->get(route('therapist.forms', $therapist->id));
        $response->assertSee('test-document.pdf');

        // Delete the file
        $fileUpload->delete();

        // Verify the file no longer appears in the forms view
        $response = $this->actingAs($admin)
            ->get(route('therapist.forms', $therapist->id));
        $response->assertDontSee('test-document.pdf');
    }
}
