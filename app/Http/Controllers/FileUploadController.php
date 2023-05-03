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
    public function index($id)
    {

        $user = auth()->user();
        $therapist = User::find($id);
        $id = $user->id;
        $file_name = FileUpload::where('user_id', $user->id)
            ->get();

        return view('therapist-forms', ['file_name' => $file_name, 'user' => $user, 'therapist' => $therapist, 'id' => $id]);
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
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fileName = $request->file->getClientOriginalName();

        $request->file->storeAs('uploads/forms/therapist', $fileName);

        $request->file->move(public_path('uploads/forms/therapist'), $fileName);

        $user->fileUploads()->create([
            'file_path' => $fileName,
            'file_name' => $fileName,
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
        // Retrieve the file name based on the ID
        // $therapistForm = TherapistsController::findOrFail($id);
        $therapistForm = FileUpload::findOrFail($id);
        $file_name = $therapistForm->file_name;

        // dd($file_name);

        // Pass the ID and file name to the view
        // return view('therapist-forms', ['id' => $id, 'file_name' => $file_name]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
