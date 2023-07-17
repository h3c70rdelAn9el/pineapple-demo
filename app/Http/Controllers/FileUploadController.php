<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\TherapistsController;


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
        $file_name = FileUpload::where('user_id', $therapist->id)->get();

        return view('therapist.forms', [
            'file_name' => $file_name,
            'therapist' => $therapist,
            'user' => $user,
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



    public function store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);
        $fileName = $request->file->getClientOriginalName();
        $verified = $user->admin ? 1 : 0;
        $request->file->storeAs('uploads/forms/therapist', $fileName);
        $request->file->move(public_path('uploads/forms/therapist'), $fileName);
        $user->fileUploads()->create([
            'file_path' => $fileName,
            'file_name' => $fileName,
            'document_type' => $request->document_type,
            'date' => $request->date,
            'note' => $request->note,
            'verified' => $verified,
            'file_title' => $request->file_title,
        ]);

        return redirect('user/profile')
            ->with('alert', 'success')
            ->with('message', 'Thank you. You have uploaded your file.')
            ->with('file_name', $fileName);
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

        return view('therapist-forms', ['id' => $id, 'file_name' => $file_name, 'user' => $user, 'therapist' => $therapist]);
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
            'form_id' => 'required',
            'verified' => 'required',
        ]);
        $form = FileUpload::findOrFail($id);
        $verified = $request->input('verified') === 'on' ? true : false;
        $form->fill([
            'verified' => $verified,
        ]);
        $therapist = User::find($form->user_id);
        $file_name = FileUpload::where('user_id', $therapist->id)->get();

        try {
            $form->save();
        } catch (\Exception $e) {
            return redirect()->back();
        }

        return view('therapist.forms', ['id' => $id, 'user' => $user, 'therapist' => $therapist, 'file_name' => $file_name, 'form' => $form]);
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
}
