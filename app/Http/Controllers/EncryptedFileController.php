<?php

namespace App\Http\Controllers;

use App\Models\EncryptedFile;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;
class EncryptedFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageTitle ="Encrypted Files";
        $files = EncryptedFile::query();
        if($user->role == 'user'){
            $files->where('user_id',$user->id);
        }
        $files = $files->where('is_paid',1)->get();
        return view('dashboard.encrypted-files.index',compact('files','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EncryptedFile  $encryptedFile
     * @return \Illuminate\Http\Response
     */
    public function show(EncryptedFile $encryptedFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EncryptedFile  $encryptedFile
     * @return \Illuminate\Http\Response
     */
    public function edit(EncryptedFile $encryptedFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EncryptedFile  $encryptedFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EncryptedFile $encryptedFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EncryptedFile  $encryptedFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(EncryptedFile $encryptedFile)
    {
        $encryptedFile->delete();
        return redirect()->back()->with('success',"File deleted successfully.");
    }
    // public function download(EncryptedFile $encryptedFile){
    //     if (file_exists($encryptedFile->path)) {
    //         return response()->download(storage_path('app/public/' . $filePath))->with('success',"File downloaded successfully.");
    //     } else {
    //         // If the file does not exist, return an error response
    //         return redirect()->back()->with(['error' => 'File not found']);
    //     } 
    // }
}
