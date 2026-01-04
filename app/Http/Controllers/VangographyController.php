<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\EncryptedFile;
use App\Models\VangographyPlan;
use Auth;
class VangographyController extends Controller
{
    public $filename ='';
    public function index(){
        $pageTitle = "Vangonography";
        $plans = VangographyPlan::all();
        $userData= session()->get('userData') ?? null;
        return view('vangography.index', compact('pageTitle','plans','userData'));
    }
    public function encodeIndex()
    {
        $pageTitle = "Vangonography Encode";
        $submenu=['link'=>route('vangography.index'), 'title'=>"Vangonography"];
        $plans = VangographyPlan::where('price', '!=' ,0)->get();
        return view('vangography.encode',compact('pageTitle','submenu','plans'));
    }
    public function decodeIndex()
    {
        $pageTitle = "Vangonography Decode";
        $submenu=['link'=>route('vangography.index'), 'title'=>"Vangonography"];
        return view('vangography.decode',compact('pageTitle','submenu'));
    }

    // public function encode(Request $request){
    //     $validator = Validator::make($request->all(),[
    //         'original' => 'required|string',
    //         'secret_file' => 'required|string',
    //         'offset'=>'integer|min:30|max:100',
    //         'password'=>'nullable|min:4'
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             "message"=>"false.",
    //             "success"=>false, 
    //             'errors' => $validator->errors()], 422);
    //     }
    //     try{
    //         $fileSize =0;
    //         $originalContent="";
    //         $originalFilePath = storage_path('app/public/'.$request->original);
    //         // Check if the file exists
    //         if (file_exists($originalFilePath)) {
    //             // File exists, read its contents
    //             $originalContent = file_get_contents($originalFilePath);
    //         } else {
    //             return response()->json(['error' => 'Cover file not found'], 404) 
    //             ->header('Access-Control-Allow-Origin', '*')
    //             ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
    //             ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    //         }
    //         $imageOriginal = imagecreatefromstring($originalContent);

    //         $x_dimension = imagesx($imageOriginal); //height
    //         $y_dimension = imagesy($imageOriginal); //width
    //         $key = $request->get('password');
    //         $offsetPercent = 0;
    //         // $request->get('offset');
    //         $qOffset = $request->get('offset');
    //         $quality = min((100 - $qOffset) + 25, 30);
    //         $lengthStegoContainer = $x_dimension * $y_dimension;
    //         $offset = round($lengthStegoContainer / 100 * $offsetPercent);
    //         // Reduce image quality based of offset size 
    //         $reducedImage = imagecreatetruecolor($x_dimension, $y_dimension);
    //         imagecopyresampled($reducedImage, $imageOriginal, 0, 0, 0, 0, $x_dimension, $y_dimension, $x_dimension, $y_dimension);
    //         ob_start();
    //         imagejpeg($reducedImage, null, $quality); // Adjust the quality (50 in this example)
    //         $reducedImageContent = ob_get_contents();
    //         ob_end_clean();
    //         imagedestroy($reducedImage);
    //         $imageOriginal = imagecreatefromstring($reducedImageContent);
    //         $imageCrypto = $imageOriginal;        
    //         // Check if a secret file is provided
    //         if ($request->secret_file) {
    //             $fileContent="";
    //             $originalFileName = basename($request->input('secret_file')); // Extract the filename from the URL
    //             $secretFilePath = storage_path('app/public/'.$request->secret_file);
    //             if (file_exists($secretFilePath)) {
    //                 $fileContent = file_get_contents($secretFilePath);
    //             } else {
    //                 return response()->json(['error' => 'Secret file not found'], 404);
    //             }
    //             $fileSize = strlen($fileContent);
    //             // $string = $originalFileName . '|file|' . $fileContent;
    //             // Compress the file content
    //             // $compressedContent = gzcompress($fileContent);
    //             // Include the compressed content in the string
    //             $string = $originalFileName . '|compressed|' . $fileContent;
    //             $stringCount = strlen($string);
    //             $iv = "1234567812345678";
    //             $stringCrypto = openssl_encrypt($string, 'AES-256-CFB', $key, OPENSSL_RAW_DATA, $iv);
    //             $bin = $this->textBinASCII2($stringCrypto); //string to array
        
    //             $stringLength = $this->textBinASCII2((string)strlen($bin));
        
    //             $signBegin = $this->textBinASCII2('stego');
    //             $sign = $this->textBinASCII2('gravitation');
        
    //             $binaryText = str_split($signBegin.$stringLength.$sign.$bin);
    //             $textCount = count($binaryText) + $offset;
    //             $count = 0;
    //             $countOffset = 0;
    //             for ($x = 0; $x < $x_dimension; $x++) {
        
    //                 if ($count >= $textCount)
    //                 break;
        
    //                 for ($y = 0; $y < $y_dimension; $y++) {
        
    //                     // if ($countOffset < $offset) {
    //                     //     $countOffset++;
    //                     //     continue;
    //                     // }
        
    //                     if ($count >= $textCount)
    //                         break;
        
    //                     $rgbOriginal = imagecolorat($imageOriginal, $x, $y);
        
    //                     $r = ($rgbOriginal >> 16) & 0xFF;
    //                     $g = ($rgbOriginal >> 8) & 0xFF;
    //                     $b = $rgbOriginal & 0xFF;
        
    //                     $redBinaryArray = str_split((string)base_convert($r,10,2));
    //                     $redBinaryArray[count($redBinaryArray)-1] = $binaryText[$count];
    //                     $redBinary = implode($redBinaryArray);
        
    //                     if(array_key_exists((int)($count-$offset+1), $binaryText)) {
    //                         $greenBinaryArray = str_split((string)base_convert($g, 10, 2));
    //                         $greenBinaryArray[count($greenBinaryArray) - 1] = $binaryText[$count+ 1];
    //                         $greenBinary = implode($greenBinaryArray);
    //                     }
        
    //                     if(array_key_exists((int)($count-$offset+2), $binaryText)) {
    //                         $blueBinaryArray = str_split((string)base_convert($b, 10, 2));
    //                         $blueBinaryArray[count($blueBinaryArray) - 1] = $binaryText[$count + 2];
    //                         $blueBinary = implode($blueBinaryArray);
    //                     }
        
    //                     $color = imagecolorallocate($imageOriginal,
    //                         bindec($redBinary),
    //                         bindec($greenBinary),
    //                         bindec($blueBinary));
        
    //                     imagesetpixel($imageCrypto, $x, $y, $color);
        
    //                     $count+=3;
    //                 }
    //             }
    //         }
    //         else {
    //             $string =  $request->get('text');
    //             $stringCount = strlen($string);
    //             $iv = "1234567812345678";
    //             $stringCrypto = openssl_encrypt($string, 'AES-256-CFB', $key, OPENSSL_RAW_DATA, $iv);
    //             $bin = $this->textBinASCII2($stringCrypto); //string to array
    //             $stringLength = $this->textBinASCII2((string)strlen($bin));
    //             $signBegin = $this->textBinASCII2('stego');
    //             $sign = $this->textBinASCII2('gravitation');
    //             $binaryText = str_split($signBegin.$stringLength.$sign.$bin);
    //             $textCount = count($binaryText) + $offset;
    //             $count = $offset;
    //             $countOffset = 0;
    //                 for ($x = 0; $x < $x_dimension; $x++) {
    //                 if ($count >= $textCount)
    //                     break;
    //                     for ($y = 0; $y < $y_dimension; $y++) {
    //                         if ($countOffset < $offset) {
    //                             $countOffset++;
    //                             continue;
    //                         }
    //                         if ($count >= $textCount)
    //                             break;
    //                         $rgbOriginal = imagecolorat($imageOriginal, $x, $y);
    //                         $r = ($rgbOriginal >> 16) & 0xFF;
    //                         $g = ($rgbOriginal >> 8) & 0xFF;
    //                         $b = $rgbOriginal & 0xFF;
    //                         $redBinaryArray = str_split((string)base_convert($r,10,2));
    //                         $redBinaryArray[count($redBinaryArray)-1] = $binaryText[$count-$offset];
    //                         $redBinary = implode($redBinaryArray);
    //                         if(array_key_exists((int)($count-$offset+1), $binaryText)) {
    //                             $greenBinaryArray = str_split((string)base_convert($g, 10, 2));
    //                             $greenBinaryArray[count($greenBinaryArray) - 1] = $binaryText[$count - $offset + 1];
    //                             $greenBinary = implode($greenBinaryArray);
    //                         }
    //                         if(array_key_exists((int)($count-$offset+2), $binaryText)) {
    //                             $blueBinaryArray = str_split((string)base_convert($b, 10, 2));
    //                             $blueBinaryArray[count($blueBinaryArray) - 1] = $binaryText[$count - $offset + 2];
    //                             $blueBinary = implode($blueBinaryArray);
    //                         }
    //                         $color = imagecolorallocate($imageOriginal,
    //                             bindec($redBinary),
    //                             bindec($greenBinary),
    //                             bindec($blueBinary));
    //                         imagesetpixel($imageCrypto, $x, $y, $color);
    //                         $count+=3;
    //                     }
    //                 }
    //         }               
    //         ob_start();
    //         imagepng($imageCrypto);
    //         $image_string = base64_encode(ob_get_contents());
    //         ob_end_clean();
    //         $randomNumber = random_int(1, 9999);  
    //         $encryptedImageFilename = 'IMG_' . str_pad($randomNumber, 4, '0', STR_PAD_LEFT).".png";
    //                     // Define the storage path
    //         $directoryPath = storage_path('app/public/encrypted_files/');
    //         if (!file_exists($directoryPath)) {
    //             mkdir($directoryPath, 0755, true);
    //         }
    //         $storagePath = $directoryPath . $encryptedImageFilename;
            
    //         // Save the encrypted image to storage
    //         imagepng($imageCrypto, $storagePath);
    //         // Get the public URL of the stored image
    //         $imageUrl = asset('storage/encrypted_files/' . $encryptedImageFilename);
    //          // Get the public URL of the stored image
    //          $encryptedFile=EncryptedFile::create([
    //              'user_id'=>Auth::guard('seed')->id() ?? null,
    //              'path'=>'encrypted_files/'.$encryptedImageFilename,
    //              'size'=>$fileSize,
    //              'amount'=>$request->amount ?? 0,
    //              'is_paid'=>$request->is_paid ?? 0,
    //          ]);
    //          $path =$encryptedFile->path;
    //          $fileSizeInMB = $fileSize / (1024 * 1024);
    //          if (!Auth::guard("seed")->check() && $fileSizeInMB > 2) {
    //             $fileIds = session()->get('file_ids', []);
    //             // Push the new encrypted file id into the array
    //             $fileIds[] = $encryptedFile->id;
    //             // Put the updated array back into the session
    //             session()->put('file_ids', $fileIds);
    //             $path=null;
    //         }
    //             // Clean up and destroy the image resource
    //         imagedestroy($imageCrypto);
    //         if (!$path) {
    //             return response()->json([
    //                 'url' => route('vangography.payment.success', $encryptedFile->id),
    //                 'path'=>$path
    //             ],200)
    //             ->header('Access-Control-Allow-Origin', '*')
    //             ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
    //             ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    //         }
    //         else{
    //             return response()->json([
    //                 'path'=>$path
    //             ],200)->header('Access-Control-Allow-Origin', '*')
    //             ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
    //             ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    //         }
    //     }
    //     catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500)->header('Access-Control-Allow-Origin', '*')
    //         ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
    //         ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    //     }
    // }
    
    
    public function encode(Request $request){
        $validator = Validator::make($request->all(),[
            'original' => 'required|string',
            'secret_file' => 'required|string',
            'offset'=>'integer|min:30|max:100',
            'password'=>'nullable|min:4'
        ]);
           
        if ($validator->fails()) {
            return response()->json([
                "message"=>"false.",
                "success"=>false, 
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $fileSize = 0;
    
            // --- Load Cover Image Dynamically ---
            $originalFilePath = storage_path('app/public/'.$request->original);
            if (!file_exists($originalFilePath)) {
                return response()->json(['error' => 'Cover file not found'], 404);
            }
            $coverExtension = strtolower(pathinfo($originalFilePath, PATHINFO_EXTENSION));

            $imageInfo = getimagesize($originalFilePath);
            $mime = $imageInfo['mime'];
    
            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':
                    $imageOriginal = imagecreatefromjpeg($originalFilePath);
                    break;
    
                case 'image/png':
                    $imageOriginal = imagecreatefrompng($originalFilePath);
                    break;
    
                case 'image/heic':
                case 'image/heif':
                    if (!extension_loaded('imagick')) {
                        return response()->json(['error' => 'HEIC support requires Imagick extension'], 500);
                    }
                    $imagick = new \Imagick($originalFilePath);
                    $imagick->setImageFormat('png'); // convert HEIC to PNG
                    $imageOriginal = imagecreatefromstring($imagick->getImageBlob());
                    $imagick->clear();
                    $imagick->destroy();
                    break;
    
                default:
                    return response()->json(['error' => 'Unsupported image type'], 415);
            }
    
            $x_dimension = imagesx($imageOriginal);
            $y_dimension = imagesy($imageOriginal);
    
            // --- Resize Large Images (Memory Optimization) ---
            $maxWidth = 1920;
            $maxHeight = 1080;
            if ($x_dimension > $maxWidth || $y_dimension > $maxHeight) {
                $ratio = min($maxWidth/$x_dimension, $maxHeight/$y_dimension);
                $newWidth = round($x_dimension * $ratio);
                $newHeight = round($y_dimension * $ratio);
    
                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resizedImage, $imageOriginal, 0,0,0,0,$newWidth,$newHeight,$x_dimension,$y_dimension);
                imagedestroy($imageOriginal);
    
                $imageOriginal = $resizedImage;
                $x_dimension = $newWidth;
                $y_dimension = $newHeight;
            }
    
            $imageCrypto = $imageOriginal; // Use single resource for stego
    
            $key = $request->get('password') ?? '';
            $offsetPercent = 0;
            $qOffset = $request->get('offset') ?? 30;
    
            // --- Encode Secret File or Text ---
            if ($request->secret_file) {
                $secretFilePath = storage_path('app/public/'.$request->secret_file);
                if (!file_exists($secretFilePath)) {
                    return response()->json(['error' => 'Secret file not found'], 404);
                }
    
                $fileContent = file_get_contents($secretFilePath);
                $fileSize = strlen($fileContent);
                $originalFileName = basename($request->secret_file);
    
                $string = $originalFileName . '|compressed|' . $fileContent;
                $iv = "1234567812345678";
                $stringCrypto = openssl_encrypt($string, 'AES-256-CFB', $key, OPENSSL_RAW_DATA, $iv);
                $bin = $this->textBinASCII2($stringCrypto);
    
                $stringLength = $this->textBinASCII2((string)strlen($bin));
                $signBegin = $this->textBinASCII2('stego');
                $sign = $this->textBinASCII2('gravitation');
    
                $binaryText = str_split($signBegin.$stringLength.$sign.$bin);
                $textCount = count($binaryText) + $offsetPercent;
                $count = 0;
    
                for ($x = 0; $x < $x_dimension; $x++) {
                    if ($count >= $textCount) break;
                    for ($y = 0; $y < $y_dimension; $y++) {
                        if ($count >= $textCount) break;
    
                        $rgbOriginal = imagecolorat($imageOriginal, $x, $y);
                        $r = ($rgbOriginal >> 16) & 0xFF;
                        $g = ($rgbOriginal >> 8) & 0xFF;
                        $b = $rgbOriginal & 0xFF;
    
                        $redBinaryArray = str_split((string)base_convert($r,10,2));
                        $redBinaryArray[count($redBinaryArray)-1] = $binaryText[$count];
                        $redBinary = implode($redBinaryArray);
    
                        $greenBinary = $blueBinary = null;
                        if(array_key_exists($count+1, $binaryText)) {
                            $greenBinaryArray = str_split((string)base_convert($g,10,2));
                            $greenBinaryArray[count($greenBinaryArray)-1] = $binaryText[$count+1];
                            $greenBinary = implode($greenBinaryArray);
                        }
    
                        if(array_key_exists($count+2, $binaryText)) {
                            $blueBinaryArray = str_split((string)base_convert($b,10,2));
                            $blueBinaryArray[count($blueBinaryArray)-1] = $binaryText[$count+2];
                            $blueBinary = implode($blueBinaryArray);
                        }
    
                        $color = imagecolorallocate(
                            $imageOriginal,
                            bindec($redBinary),
                            bindec($greenBinary ?? '0'),
                            bindec($blueBinary ?? '0')
                        );
    
                        imagesetpixel($imageCrypto, $x, $y, $color);
                        $count += 3;
                    }
                }
    
            } else if ($request->text) {
                $string = $request->get('text');
                $iv = "1234567812345678";
                $stringCrypto = openssl_encrypt($string, 'AES-256-CFB', $key, OPENSSL_RAW_DATA, $iv);
                $bin = $this->textBinASCII2($stringCrypto);
    
                $stringLength = $this->textBinASCII2((string)strlen($bin));
                $signBegin = $this->textBinASCII2('stego');
                $sign = $this->textBinASCII2('gravitation');
    
                $binaryText = str_split($signBegin.$stringLength.$sign.$bin);
                $textCount = count($binaryText) + $offsetPercent;
                $count = $offsetPercent;
                $countOffset = 0;
    
                for ($x = 0; $x < $x_dimension; $x++) {
                    if ($count >= $textCount) break;
                    for ($y = 0; $y < $y_dimension; $y++) {
                        if ($countOffset < $offsetPercent) { $countOffset++; continue; }
                        if ($count >= $textCount) break;
    
                        $rgbOriginal = imagecolorat($imageOriginal, $x, $y);
                        $r = ($rgbOriginal >> 16) & 0xFF;
                        $g = ($rgbOriginal >> 8) & 0xFF;
                        $b = $rgbOriginal & 0xFF;
    
                        $redBinaryArray = str_split((string)base_convert($r,10,2));
                        $redBinaryArray[count($redBinaryArray)-1] = $binaryText[$count-$offsetPercent];
                        $redBinary = implode($redBinaryArray);
    
                        $greenBinary = $blueBinary = null;
                        if(array_key_exists($count-$offsetPercent+1, $binaryText)) {
                            $greenBinaryArray = str_split((string)base_convert($g,10,2));
                            $greenBinaryArray[count($greenBinaryArray)-1] = $binaryText[$count-$offsetPercent+1];
                            $greenBinary = implode($greenBinaryArray);
                        }
    
                        if(array_key_exists($count-$offsetPercent+2, $binaryText)) {
                            $blueBinaryArray = str_split((string)base_convert($b,10,2));
                            $blueBinaryArray[count($blueBinaryArray)-1] = $binaryText[$count-$offsetPercent+2];
                            $blueBinary = implode($blueBinaryArray);
                        }
    
                        $color = imagecolorallocate(
                            $imageOriginal,
                            bindec($redBinary),
                            bindec($greenBinary ?? '0'),
                            bindec($blueBinary ?? '0')
                        );
    
                        imagesetpixel($imageCrypto, $x, $y, $color);
                        $count += 3;
                    }
                }
            }
    
            // --- Save Encrypted Image ---
            $directoryPath = storage_path('app/public/encrypted_files/');
            if (!file_exists($directoryPath)) mkdir($directoryPath, 0755, true);
    
            $encryptedImageFilename = 'IMG_' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT).".".$coverExtension;
            $storagePath = $directoryPath . $encryptedImageFilename;
    
            imagepng($imageCrypto, $storagePath);
    
            $encryptedFile = EncryptedFile::create([
                'user_id' => Auth::guard('seed')->id() ?? null,
                'path' => 'encrypted_files/'.$encryptedImageFilename,
                'size' => $fileSize,
                'amount' => $request->amount ?? 0,
                'is_paid' => $request->is_paid ?? 0,
            ]);
    
            imagedestroy($imageCrypto);
    
            return response()->json([
                'path' => $encryptedFile->path
            ], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        }
    }
    

    public function uploadFile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required', // Adjust the validation rules as needed
        ]);
        // Store the uploaded file in the storage directory
        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $fileName = time() . '_' . str_replace(' ', '_', $originalFileName);
        $filePath="";
        if($request->type === 'cover'){
            $filePath = $file->storeAs('cover_files', $fileName, 'public');
        }
        if($request->type === 'secret'){
            $filePath = $file->storeAs('secret_files', $fileName, 'public');
        }
        // Generate an asset URL for the stored file
        // $imageUrl = asset('storage/' . $filePath);

        // Return a response with the asset URL
        return response()->json(['image_url' => $filePath
        ], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    
    }
    public function decode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pictures.original' => 'required',
            'password'=>'nullable|min:4'
        ], [
            'pictures.original.required' => 'Image is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message"=>"false.",
                "success"=>false, 
                'errors' => $validator->errors()], 422);
        }
        try{
            $pictures = $request->get('pictures');
            $original = preg_replace('/data:image\/\w+;base64,/', '', $pictures['original']);
            $original = base64_decode($original);
            $imageOriginal = imagecreatefromstring($original);

            $x_dimension = imagesx($imageOriginal); //height
            $y_dimension = imagesy($imageOriginal); //width

            $binaryString = '';

            for ($x = 0; $x < $x_dimension; $x++) {

                for ($y = 0; $y < $y_dimension; $y++) {

                    $rgbOriginal = imagecolorat($imageOriginal, $x, $y);

                    $r = ($rgbOriginal >> 16) & 0xFF;
                    $g = ($rgbOriginal >> 8) & 0xFF;
                    $b = $rgbOriginal & 0xFF;

                    $redBinaryArray = str_split((string)base_convert($r, 10, 2));
                    $bitRed = $redBinaryArray[count($redBinaryArray) - 1];

                    $greenBinaryArray = str_split((string)base_convert($g, 10, 2));
                    $bitGreen = $greenBinaryArray[count($greenBinaryArray) - 1];

                    $blueBinaryArray = str_split((string)base_convert($b, 10, 2));
                    $bitBlue = $blueBinaryArray[count($blueBinaryArray) - 1];

                    $binaryString .= $bitRed.$bitGreen.$bitBlue;
                }
            }

            $iv = "1234567812345678";
            $key = $request->get('password');

            $sign = $this->textBinASCII2('gravitation');
            $signBegin = $this->textBinASCII2('stego');

            $lengthSign = strlen($sign);
            $lengthSignBegin = strlen($signBegin);

            $positionSign = strpos($binaryString, $sign);
            $positionSignBegin = strpos($binaryString, $signBegin);
            $lengthLength = $positionSign - $positionSignBegin - $lengthSignBegin;

            $offsetToLength = $positionSignBegin + $lengthSignBegin;

            $lengthBinData = mb_substr($binaryString, $offsetToLength, $lengthLength);

            $lengthData = $this->stringBinToStringChars8($lengthBinData);
            $positionData = $positionSign + $lengthSign;
            if (!ctype_digit($lengthData)) {
                return response()->json(["message"=> "No secret file found.", 'error'=>"No secret file found."],400)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            }
            $binaryData = mb_substr($binaryString, $positionData, $lengthData);
            $cryptoString = $this->stringBinToStringChars8($binaryData);
            $output = openssl_decrypt($cryptoString, 'AES-256-CFB', $key, OPENSSL_RAW_DATA, $iv);
            // $filenameSeparatorPos = strpos($output, '|file|');
            $filenameSeparatorPos = strpos($output, '|compressed|');
            $mimeType = $this->getMimeTypeFromBuffer($output);
            if($request->checkPassword && $mimeType == "application/octet-stream" && $filenameSeparatorPos == false){
                return response()->json(["password"=> true],200) 
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            }
            if($mimeType == "application/octet-stream" && $filenameSeparatorPos == false){
                return response()->json(["message"=> "invalid password, Valid password is required to decode file.",
                        'error'=>"Invalid password, Valid password is required to decode file."],400);
            }
            if($request->checkPassword && $mimeType == "application/octet-stream" && $filenameSeparatorPos == false){
                return response()->json(["password"=> true],400)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            }
            if ($filenameSeparatorPos == false) {
                return response()->json(["message"=> "No secret file found.", 'error'=>"No secret file found."],400)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            }
            $originalFileName = substr($output, 0, $filenameSeparatorPos);
            $fileContent = substr($output, $filenameSeparatorPos + 12);
            // $compressedContent = substr($output, $filenameSeparatorPos + 12);
        
            // Decompress the content
            // $fileContent = gzuncompress($fileContent);
    
            // Generate a unique filename
            $filename = $originalFileName;
            // Set the desired storage path
            $path = 'public/secret/' . $filename;
    
            // Store the decrypted content to storage
            Storage::put($path, $fileContent);
            $downloadUrl = asset('storage/secret/' . $filename);
            return response()->json(['message' => 'Secret file saved successfully.','file'=>$downloadUrl,'name'=>$filename],200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
           
        } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function stringBinToStringChars8($strBin)
    {
        $arrayChars = str_split($strBin, 8);
        $result = '';
        for ($i = 0; $i<count($arrayChars); $i++)
        {
            $result.=$this->ASCIIBinText2($arrayChars[$i]);
        }
        return $result;
    }

    function textBinASCII2($text)
    {
        $bin = array();
        $max = 0;
        for($i=0; strlen($text)>$i; $i++) {
            $bin[] = decbin(ord($text[$i]));
            if(strlen($bin[$i]) < 8)
            {
                $countNull = 8 - strlen($bin[$i]);
                $stringNull = '';
                for($j = 0; $j < $countNull; $j++) {
                    $stringNull .= '0';
                }
                $bin[$i] = $stringNull.$bin[$i];
            }
            if(strlen($bin[$i]) > 8 && strlen($bin[$i]) > $max)
            {
                $max = strlen($bin[$i]);
            }
        }
        return implode('',$bin);
    }

    function ASCIIBinText2($bin)
    {
        $text = array();
        $bin = explode(" ", $bin);
        for($i=0; count($bin)>$i; $i++)
            $text[] = chr(bindec($bin[$i]));
        return implode($text);
    }
    private function saveBinaryDataToFile($output, $request)
    {

        $mimeType = $this->getMimeTypeFromBuffer($output);
        $extension = $this->mime2ext($mimeType); 
        // Generate a unique filename
        $filename = 'secretfile_' . uniqid() . '.'.$extension;

        // Set the desired storage path
        $path = 'public/secret/' . $filename;

        // Store the decrypted content to storage
        Storage::put($path, $output);
    }
    private function getMimeTypeFromBuffer($buffer)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        return $finfo->buffer($buffer);
    }
    private function mime2ext($mime)
    {
        $mime_to_ext = [
            // Document Types
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/zip' => 'zip',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'text/plain' => 'txt',
            'text/html' => 'html',
            'application/json' => 'json',
            'application/xml' => 'xml',
            'application/xhtml+xml' => 'xhtml',
            'text/xml'=>'xml',
            'text/csv'=>'csv',
            // Image Types
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp'=> 'webp',
            'image/bmp' => 'bmp',
            'image/tiff' => 'tiff',
            'image/x-icon' => 'ico',
            'image/svg+xml' => 'svg',
            'image/vnd.wap.wbmp' => 'wbmp',
            'image/vnd.microsoft.icon'=> 'ico',

            // Audio Types
            'audio/mpeg' => 'mp3',
            'audio/wav' => 'wav',
            'audio/ogg' => 'ogg',
            'audio/aiff' => 'aiff',
            'audio/x-midi' => 'midi',
            'audio/x-wav' => 'wav',

            // Video Types
            'video/mp4' => 'mp4',
            'video/quicktime' => 'mov',
            'video/x-msvideo' => 'avi',
            'video/x-flv' => 'flv',
            'video/webm' => 'webm',
            'video/x-quicktime' => 'mov',
            'video/avi' => 'avi',

            // Archive Types
            'application/x-7z-compressed' => '7z',
            'application/x-rar-compressed' => 'rar',
            'application/x-tar' => 'tar',
            'application/gzip' => 'gz',
            'application/x-bzip2' => 'bz2',
            'application/x-cd-image' => 'iso',
            'application/bat' => 'bat',
            // Executable Types
            'application/vnd.android.package-archive' => 'apk',
            'application/x-msdownload' => 'exe',

            // Font Types
            'application/x-font-ttf' => 'ttf',
            'application/x-font-otf' => 'otf',

            // Certificate Types
            'application/x-pkcs12' => 'p12',
            'application/x-pkcs7-certificates' => 'p7b',
            'application/x-pkcs7-certreqresp' => 'p7r',
            'application/x-pkcs7-mime' => 'p7m',
            'application/x-pkcs7-signature' => 'p7s',

            // Other Types
            'application/vnd.oasis.opendocument.text' => 'odt',
            'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
            'application/vnd.oasis.opendocument.presentation' => 'odp',
            'application/x-dvi' => 'dvi',
            'application/x-latex' => 'latex',
            'text/x-php' => 'php',
            'text/x-script.python' => 'py',
            'text/x-java-source' => 'java',
            'text/x-csrc' => 'c',
            'text/x-c++src' => 'cpp',
            'text/x-csharp' => 'cs',
            'text/x-htaccess' => 'htaccess',
            'text/x-markdown' => 'md',
            'text/css' => 'css',
    ];

        return $mime_to_ext[$mime] ?? 'txt'; 
    }
}
