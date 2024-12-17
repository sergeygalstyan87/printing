<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function filePreview(Request $request)
    {
        $uploadController = new \App\Http\Controllers\Front\UploadController();

        if($request->file('file_preview')){
            $item = $request->file('file_preview');
        }else{
            $item = $request->file_preview;
        }

        if($item) {
            if (is_string($item)) {
                if (Storage::disk('tmp_upload')->exists($item)) {

                    $file_path = Storage::disk('tmp_upload')->files($item)[0];
                    $localPath = Storage::disk('tmp_upload')->path($file_path);
                    $extension = pathinfo($localPath, PATHINFO_EXTENSION);
                    $fileSize = filesize($localPath);
                    $file_name = basename($file_path);;
                    $folder = $item;
                    $item = $localPath;
                }
            } else {
                $extension = $item->getClientOriginalExtension();
                $fileSize = $item->getSize();
                $file_name = $item->getClientOriginalName();
                $folder = '';
            }

            switch (strtolower($extension)) {
                case 'pdf':
                case 'psd':
                case 'tiff':
                case 'tif':
                    $fileBase64 = $uploadController->convertPdfToBase64($item);
                    break;
                case 'ai':
                case 'eps':

                    $fileBase64 = $uploadController->convertAiOREPSORTIFToBase64($item);
                    break;
                case 'bmp':
                case 'gif':
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'svg':
                    $fileBase64 = $uploadController->convertImageToBase64($item);
                    break;
                case 'cdr':
                    $fileBase64 = $uploadController->convertCdrToBase64($item);
                    break;
                default:
                    $fileBase64 = null;
            }

            return response()->json([
                'url' => $fileBase64,
                'name' => $file_name,
                'size' => $fileSize,
                'folder' => $folder,
                'success' => true,
            ], 200);
        }else{
            return response()->json([
                'error' => 'File not found',
            ], 404);
        }

    }
}
