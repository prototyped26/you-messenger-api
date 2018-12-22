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
        $filename =  Str::random(60) .'.'.  $format;

        //$encoded_image = explode(",", $base64Image)[1];
        $encoded_image = $base64Image;
        $decoded_image = base64_decode($encoded_image);


        try {
            switch ($type) {
                case 'image' :
                    $fileInput = "data/images/".$filename;
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
                default:
                    $fileInput = "data/images/".$filename;
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

            return response()->json([
                'success'=> [
                    'file_name' => $filename,
                    'path' =>  asset(''.$fileInput)
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error'=> 'Error : ' .$e->getMessage()], 400);
        }


        return response()->json(['error'=> 'An error has occurred'], 400);

    }
}
