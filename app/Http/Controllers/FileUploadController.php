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
        if($user->admin ==1)
        {
            return redirect('therapist/forms/' . $therapist->id)
            ->with('success', 'File uploaded successfully')
            ->with('file_name', $fileName);

        }
        else
        {
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
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user->admin) {
            return redirect('therapist.forms');
        }

        $request->validate([
            'verified' => 'nullable|in:1',
        ]);

        $form = FileUpload::findOrFail($id);
        $form->update([
            'verified' => $request->has('verified'),
            'pinned' => $request->has('pinned'),
        ]);

        $therapist = User::find($form->user_id);

        //return redirect()->route('therapist.forms', ['id' => $form->user_id]);
        return redirect()->route('therapist.forms', ['therapist' => $therapist]);
    }

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
