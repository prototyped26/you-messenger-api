<?php

namespace App\Http\Controllers\Api;

use App\Models\Fichier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserFileController extends Controller
{
    //
    public function saveFile(Request $request) {
        $input = $request->all();

        $base64Image = $input['file'];
        $format = $input['format'];
        $type = $input['type'];

        //$filename =  Str::random(60) .'.'. ($type == 'image' ? 'jpg' :  $format);
        $label = "" . Str::random(60);
        $filename =  $label .'.'.  $format;
        $filename_compress =  $label .'_blur.'.  $format;

        //$encoded_image = explode(",", $base64Image)[1];
        $encoded_image = $base64Image;
        $decoded_image = base64_decode($encoded_image);


        try {
            switch ($type) {
                case 'image' :
                    $fileInput = "data/images/".$filename;
                    $filename_compress = "data/images/".$filename_compress;
                    break;
                case 'video':
                    $fileInput = "data/videos/".$filename;
                    break;
                case 'document':
                    $fileInput = "data/documents/".$filename;
                    break;
                case 'audio':
                    $fileInput = "data/audios/".$filename;
                    break;
                case 'profile':
                    $fileInput = "data/images/".$filename;
                    $filename_compress = "data/images/".$filename_compress;
                    break;
                default:
                    $fileInput = "data/images/".$filename;
                    $filename_compress = "data/images/".$filename_compress;
            }

            //$localPaht = asset($fileInput);
           $localPaht = ($fileInput);
            // http://192.168.43.97/
           // $localPaht = str_replace('http://192.168.43.97/', '', $localPaht);
            //  $localPaht = str_replace('http://localhost:8000/', '', $localPaht);
            //$localPaht = str_replace('public', 'resources', $localPaht);
            
            file_put_contents('' . $localPaht ,$decoded_image);
            //Storage::put('' .$fileInput , $contents);

            $fichier = new Fichier(['type' => $type, 'url' => $fileInput, 'nom' => $filename]);
            $fichier->save();

            // compress images
            if ($type == "image" || $type == "profile") {
                $this->compressFile($filename_compress, $base64Image);
            } else {
                $filename_compress = null;
            }

            if ($type == 'profile') {
               $user = $request->user();
               $user->photo = asset(''.$fileInput);
               $user->save();
            }

            return response()->json([
                'success'=> [
                    'file_name' => $filename,
                    'path' =>  asset(''.$fileInput),
                    'compress_file' => $filename_compress
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error'=> 'Error : ' .$e->getMessage()], 400);
        }


        return response()->json(['error'=> 'An error has occurred'], 400);

    }

    public function compressFile($fileName, $base64image) {

        $height = 175;
        $width = 175;

        $decode_image = base64_decode($base64image);

        $im = imagecreatefromstring($decode_image);

        $oldWidth = imagesx($im);
        $oldHeight = imagesy($im);

        $dst = imagecreatetruecolor($width, $height);
        imagecopyresampled($dst, $im, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);
        imagedestroy($im);

        imagepng($dst, "".$fileName, 0, PNG_ALL_FILTERS);
    }
}
