<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('file-upload');
        return response(view('file-upload'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('file-upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
    //     ]);

    //     // $fileName = time().'.'.$request->file->extension();
    //     $fileName = $request->file->getClientOriginalName();

    //     $request->file->storeAs('uploads', $fileName);

    //     $request->file->move(public_path('uploads'), $fileName);

    //     return back()
    //         ->with('success', 'Thank you.  You have uploaded your file.')
    //         ->with('file', $fileName);
    // }

    // use Illuminate\Http\Response;

    public function store(Request $request): Response
    {
        $user = $request->user();
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fileName = $request->file->getClientOriginalName();

        $request->file->storeAs('uploads', $fileName);

        $request->file->move(public_path('uploads/forms/therapist'), $fileName);

        $response = new Response();
        $response->setContent('File uploaded successfully');
        $response->setStatusCode(Response::HTTP_CREATED);

        $user->fileUploads()->create([
            'file_path' => $fileName,
            'file_name' => $fileName,
        ]);
        return $response;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
