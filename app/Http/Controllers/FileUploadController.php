<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Notifications\TherapistFileUploaded;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\TherapistsController;
use Illuminate\Support\Facades\Storage;



class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($therapist): View
    {
        $therapist = User::find($therapist);
        $user = auth()->user();
        // $file_name = FileUpload::where('user_id', $therapist->id)->get();
        $file_name = FileUpload::where('user_id', $therapist->id)->orderBy('created_at', 'desc')->get();

        $expiredFiles = $file_name->filter(function ($file) {
            return $file->date && $file->date < now();
        });

        $pinnedForms = $file_name->where('user_id', $therapist->id)->where('pinned', 1)->sortByDesc('created_at');
        $unPinnedForms = $file_name->where('user_id', $therapist->id)->where('pinned', 0)->sortByDesc('created_at');

        return view('therapist.forms', [
            'file_name' => $file_name,
            'therapist' => $therapist,
            'user' => $user,
            'expiredFiles' => $expiredFiles,
            'pinnedForms' => $pinnedForms,
            'unPinnedForms' => $unPinnedForms,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('file-upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request, $therapist_id)
    {
        $therapist = User::find($therapist_id);
        // $user = $request->user();
        $user = auth()->user();
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:1048576',
        ]);
        $fileName = time() . $request->file->getClientOriginalName();
        $verified = $user->admin ? 1 : 0;
        $path = 'uploads/forms/therapist/' . $user->id . '/';
        $request->file->storeAs($path, $fileName);

        // update the user fields:
        switch($request->document_type) {
            case 'photographic_id':
                $therapist->update(['id_uploaded' => true]);
                break;
            case 'W9':
                $therapist->update(['W9_or_WBEN_uploaded' => true]);
                break;
            case 'clinical_license':
                $therapist->update(['license_uploaded' => true]);
                break;
            case 'public_liability_insurance':
                $therapist->update(['insurance_uploaded' => true]);
                break;
            case 'headshot':
                $therapist->update(['headshot_uploaded' => true]);
                break;
            case 'W8BENE':
                $therapist->update(['W9_or_WBEN_uploaded' => true]);
                break;
            case 'W8BEN':
                $therapist->update(['W9_or_WBEN_uploaded' => true]);
                break;
            default:
                break;
        }

        if ($user->admin == 1) {
            $therapist->fileUploads()->create([
                'file_path' => $path,
                'file_name' => $fileName,
                'document_type' => $request->document_type,
                'date' => $request->date,
                'note' => $request->note,
                'verified' => $verified,
                'file_title' => $request->file_title,
                'user_id' => $therapist->id,
                //'user_id' => $request->user_id,
                // 'therapist_id' => $therapist->id,
            ]);
        } else {
            $user->fileUploads()->create([
                'file_path' => $path,
                'file_name' => $fileName,
                'document_type' => $request->document_type,
                'date' => $request->date,
                'note' => $request->note,
                'verified' => $verified,
                'file_title' => $request->file_title,
                // 'user_id' => $therapist->id,
                'user_id' => $request->user_id,
                // 'therapist_id' => $therapist->id,
            ]);
        }

        if ($fileName) {
            $adminUsers = User::where('admin', 1)->get();
            Notification::send($adminUsers, new TherapistFileUploaded($user));
        }
        if ($user->admin == 1) {
            return redirect('therapist/forms/' . $therapist->id)
                ->with('success', 'File uploaded successfully')
                ->with('file_name', $fileName);

        } else {
            return redirect('user/profile')
                ->with('success', 'File uploaded successfully')
                ->with('file_name', $fileName);
        }
    }


    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
    //  */

    public function show($id): View
    {
        $therapistForm = FileUpload::findOrFail($id);
        $file_name = $therapistForm->file_name;
        $user = auth()->user();
        $therapist = User::find($user->id);
        $id = $user->id;



        return view('therapist.forms', ['id' => $id, 'file_name' => $file_name, 'user' => $user, 'therapist' => $therapist, 'therapistForm' => $therapistForm]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {

        $form = FileUpload::findOrFail($id);

        $user = auth()->user();
        if (!$user->admin && $form->user_id !== $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to edit this form.');
        }

        return view('therapist.forms-edit', compact('form', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $user = auth()->user();

    //     // $therapist = User::find($user->id);

    //     if (!$user->admin) {
    //         return redirect('therapist.forms');
    //     }

    //     $request->validate([
    //         // 'verified' => 'nullable|in:1',
    //         // 'verified' => $request->boolean('verified'),
    //         'verified' => 'nullable|boolean',

    //         // 'file_path' => $path,
    //         // 'file_name' => $request->file_name,
    //         'document_type' => $request->document_type,
    //         'date' => $request->date,
    //         'note' => $request->note,
    //         'file_title' => $request->file_title,
    //         // 'user_id' => $therapist->id,
    //         ''
    //     ]);

    //     $form = FileUpload::findOrFail($id);
    //     $form->update([
    //         // make the field nullable
    //         // 'verified' => $request->input('verified', null),
    //         // 'verified' => $request->has('verified'),
    //         'verified' => 'nullable|boolean',
    //         // 'verified' => $request->boolean('verified'),

    //         'pinned' => $request->has('pinned'),
    //         'file_title' => $request->file_title,
    //         'document_type' => $request->document_type,
    //         'date' => $request->date,
    //         'note' => $request->note,
    //         // 'user_id' => $therapist->id,

    //     ]);

    //     $therapist = User::find($form->user_id);

    //     //return redirect()->route('therapist.forms', ['id' => $form->user_id]);
    //     return redirect()->route('therapist.forms', ['therapist' => $therapist]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $user = auth()->user();

    //     if (!$user->admin) {
    //         return redirect('therapist.forms');
    //     }

    //     $request->validate([
    //         'document_type' => 'nullable|string',
    //         'date' => 'nullable|date',
    //         'file_title' => 'nullable|string',
    //     ]);

    //     $form = FileUpload::findOrFail($id);

    //     $form->update([
    //         'document_type' => $request->document_type,
    //         'date' => $request->date,
    //         'file_title' => $request->file_title,
    //         'note' => $request->note,
    //         'verified' => $request->has('verified') ? $request->verified : $form->verified,
    //         'pinned' => $request->has('pinned') ? $request->pinned : $form->pinned,
    //     ]);



    //     // Redirect back to the therapist forms page
    //     return redirect()->route('therapist.forms', ['therapist' => $form->user_id]);
    // }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user->admin) {
            return redirect('therapist.forms');
        }

        $request->validate([
            'document_type' => 'nullable|string',
            'date' => 'nullable|date',
            'file_title' => 'nullable|string',
        ]);

        $form = FileUpload::findOrFail($id);

        $therapist = $form->user;

        $form->update([
            'document_type' => $request->document_type ?? $form->document_type,
            'date' => $request->date ?? $form->date,
            'file_title' => $request->file_title ?? $form->file_title,
            'note' => $request->note ?? $form->note,
            // 'verified' => $request->has('verified') ? $request->verified : $form->verified,
            'pinned' => $request->has('pinned') ? $request->pinned : $form->pinned,
        ]);

        if ($request->has('verified') && $user->admin) {
            $form->verified = $request->verified;
        }

        $therapist->title = $request->input('title', $therapist->title);
        $therapist->notes = $request->input('notes', $therapist->notes);
        $therapist->save();

        return redirect()->route('therapist.forms', ['therapist' => $form->user_id]);
    }




    // public function update(Request $request, $id)
    // {
    //     $user = auth()->user();

    //     if (!$user->admin) {
    //         return redirect('therapist.forms');
    //     }

    //     $request->validate([
    //         'document_type' => 'required',
    //         'date' => 'nullable|date',
    //     ]);

    //     $form = FileUpload::findOrFail($id);

    //     $form->update([
    //         'document_type' => $request->document_type,
    //         'date' => $request->date,
    //         'verified' => $request->has('verified') ? $request->verified : $form->verified,
    //         'pinned' => $request->has('pinned') ? $request->pinned : $form->pinned,
    //         'file_title' => $request->filled('file_title') ? $request->file_title : $form->file_title,
    //         'note' => $request->filled('note') ? $request->note : $form->note,
    //     ]);

    //     // Redirect back to the therapist forms page
    //     return redirect()->route('therapist.forms', ['therapist' => $form->user_id]);
    // }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $therapist = User::find($request->therapist);
        $searchQuery = $request->input('search');

        $file_name = FileUpload::where('user_id', $therapist->id)
            ->where('file_name', 'LIKE', "%$searchQuery%")
            ->get();


        return view('therapist.forms', [
            'file_name' => $file_name,
            'therapist' => $therapist,
            'user' => auth()->user(),
        ]);
    }
}
