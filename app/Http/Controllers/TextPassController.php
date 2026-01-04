<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TextPass;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use QrCode;
class TextPassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'TXTPass';
        return view('txt-pass.index',compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'TXTPass';
        $submenu=['link'=>route('txt.pass.index'), 'title'=>"TXTPass"];
        return view('txt-pass.create',compact('pageTitle','submenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pageTitle="TXTPass";
        $request->validate([
            'text' => 'required|min:10',
            'password' => 'nullable|required_if:password_protected,1|confirmed|min:8',
            ],[
               'password.required_if'=>"Password is required, When password protection is enabled.",
            ]
        );
    
        $data = $request->only(['text', 'password_protected', 'password']);
        
        // Hash the password if it is present
        if (isset($data['password_protected']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // If password is not present or password protection is not enabled, set password to null
            $data['password'] = null;
        }
        $textPass = TextPass::create($data);
        return redirect()->route('txt.pass.success',$textPass->id);
    }
    public function success(Request $request, $id)
    {
        $pageTitle = "TXTPass";
        $submenu=['link'=>route('txt.pass.index'), 'title'=>"TXTPass"];
        $text = TextPass::where('id', $id)->first();
        if ($text) {
            $shortLink = env('APP_URL') . '/' . base64_encode($id) . '/txt';
            if(!$text->qr_code){
                // Generate QR code
                $qrCode = QrCode::format('png')->size(500)->backgroundColor(255, 255, 255);
                // Get the path to your logo image
                $logoPath = public_path('assets/logo/logo-white-0073.jpg');
                // Check if the logo file exists
                if (file_exists($logoPath)) {
                    // Merge the QR code with the logo
                    $qrCode->merge($logoPath, 0.3, true);
                }
                $filename=substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
                // Generate the final QR code
                $qrCode = $qrCode->generate($shortLink);
                // Save QR code to storage
                $filePath = "public/qrcodes/{$filename}.png";
                Storage::put($filePath, $qrCode);

                $text->qr_code = $filePath;
                $text->save();
            }
            $qrpath = $text->qr_code;
            return view('txt-pass.success', compact('shortLink', 'pageTitle', 'qrpath','submenu'));
        } else {
            return redirect()->route('txt.pass.index')->with("error", "Text has already been read and destructed. , Please create a new one and share.");
        }
    }
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'id' => 'required',

        ]);
        $txtpass = TextPass::where('id', $request->id)->first();
        // Check if the provided password matches the actual password
        if (Hash::check($request->input('password'), $txtpass->password)) {
            $txtpass->is_read=1;
            $txtpass->save();
            return response()->json(['status' => 'success', 'txt'=>$txtpass]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Incorrect password.']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = "TXTPass";
        $submenu=['link'=>route('txt.pass.index'), 'title'=>"TXTPass"];
        $text = TextPass::find($id);
        if($text){
            if ($text->is_read==1) {
                $text->delete();
                return redirect()->route('txt.pass.index')->with('error', 'Text has already been read and destructed.');
            }
            return view('txt-pass.show',compact('pageTitle','id','submenu'));
        }
        else{
            return redirect()->route('txt.pass.index')->with('error', 'Text has already been read and destructed.');
        }
    }
    public function getText(Request $request, $id)
    {
        $text = TextPass::find($id);
        if (!$text) {
            return response()->json(['status' => 'error', 'message' => 'Text has already been read and destructed.']);
        }
        if($text->password_protected == 1) {
            return response()->json(['status' => 'success', 'protected' => true, 'text'=>'']);
        }
        else{
            $text->is_read =1;
            $text->save();
            return response()->json(['status' => 'success', 'text' => $text]);
        }
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
        $text = TextPass::find($id);
        if($text) {
            $text->delete();
            return redirect()->route('txt.pass.index')->with('error', 'Text has been deleted successfully.');
        }
        else{
            return redirect()->route('txt.pass.index')->with('error', 'Text has already been read and destructed.');
        }
    }
}
