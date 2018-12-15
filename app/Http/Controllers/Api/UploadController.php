<?php

namespace App\Http\Controllers\Api;

use App\Models\Fichier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

class UploadController extends Controller
{
    //
    public function saveFileWithBase64(Request $request) {
        $input = $request->all();

        $base64Image = $input['file'];
        $format = $input['format'];
        $type = $input['type'];

        $filename =  Str::random(60) .'.'. $format;

        $encoded_image = explode(",", $base64Image)[1];
        $decoded_image = base64_decode($encoded_image);


        try {
            switch ($type) {
                case 'image' :
                    $fileInput = "resources/images/".$filename;
                    break;
                case 'video':
                    $fileInput = "resources/videos/".$filename;
                    break;
                case 'document':
                    $fileInput = "resources/documents/".$filename;
                    break;
                case 'audio':
                    $fileInput = "resources/audios/".$filename;
                    break;
                default:
                    $fileInput = "resources/images/".$filename;
            }

            file_put_contents('' .$fileInput,$decoded_image);

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
