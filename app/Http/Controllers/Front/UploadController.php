<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Set;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\Image;

class UploadController extends Controller
{
    public function tmpUpload(Request $request)
    {
        $uploaded_files = [];
        $existingFiles = [];

        if($request->file('uploaded_files')){
            $uploaded_files = $request->file('uploaded_files');
        }else{
            $uploaded_files = $request->uploaded_files;
        }

        if($request->has('product_id')){
            if(session()->has('uploaded_files.' . $request->product_id)){
                $existingFiles = session('uploaded_files.' . $request->product_id);
            }
        }

        foreach ($request->file('uploaded_files') as $index => $fileType) {
            $uploaded_index = [];
            foreach ($fileType as $type => $file) {
                $type_files_folder = [];
                if(is_array($file)){
                    foreach ($file as $item) {
                        $fileName = pathinfo($item->getClientOriginalName(), PATHINFO_FILENAME);

                        $fileName = str_replace(' ', '_', $fileName);
                        $extension = $item->getClientOriginalExtension();
                        $folder = uniqid();
                        $uniqueFileName = $folder."_".$fileName .".". $extension;

                        $filePath = $folder . '/' . $uniqueFileName;

                        Storage::disk('tmp_upload')->put($filePath, file_get_contents($item));

                        $type_files_folder[] = $folder;


                        if($request->has('set_id') && $request->set_id){

                            $set_ids = is_array($request->set_id) ? $request->set_id : [$request->set_id];
                            foreach ($set_ids as $set_id){
                                $set = Set::find($set_id);
                                if ($set && $index == $set_id) {
                                    $uploaded_files = $set->uploaded_files;

                                    if (isset($uploaded_files[$type])) {
                                        if (!in_array($folder, $uploaded_files[$type])) {
                                            $uploaded_files[$type][] = $folder;
                                        }
                                    } else {
                                        $uploaded_files[$type] = [$folder];
                                    }

                                    $set->uploaded_files = $uploaded_files;
                                    $set->save();
                                }
                            }

                        }
                    }

                    $uploaded_index[$type] = $type_files_folder;
                }
            }

            $uploaded_files[$index] = $uploaded_index;

            if ($request->has('product_id') && session()->has('uploaded_files.' . $request->product_id)) {
                if (isset($existingFiles[$index])) {
                    foreach ($uploaded_index as $type => $folders) {
                        if (isset($existingFiles[$index][$type])) {
                            $existingFiles[$index][$type] = array_merge($existingFiles[$index][$type], $folders);
                        } else {
                            $existingFiles[$index][$type] = $folders;
                        }
                    }
                } else {
                    $existingFiles[$index] = $uploaded_index;
                }
            }

        }

        $productId = $request->input('product_id');

        if($productId){
            if (session()->has('uploaded_files.'.$productId)) {
                session()->forget('uploaded_files.' . $productId);
            }

            if($existingFiles){
                session()->put('uploaded_files.' . $productId, $existingFiles);
                return $existingFiles;
            }else{
                session()->put('uploaded_files.' . $productId, $uploaded_files);
                return $uploaded_files;
            }
        }else{
            return $uploaded_files;
        }
    }
    public function tmpPreview(Request $request)
    {
        $files_base64 = [];

        if($request->file('uploaded_files')){
            $uploaded_files = $request->file('uploaded_files');
        }else{
            $uploaded_files = $request->uploaded_files;
        }

        if($uploaded_files) {
            foreach ($uploaded_files as $fileType) {
                foreach ($fileType as $type => $file) {
                    if (is_array($file)) {
                        foreach ($file as $item) {

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
                                    $fileBase64 = $this->convertPdfToBase64($item);
                                    break;
                                case 'ai':
                                case 'eps':

                                    $fileBase64 = $this->convertAiOREPSORTIFToBase64($item);
                                    break;
                                case 'bmp':
                                case 'gif':
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                case 'svg':
                                    $fileBase64 = $this->convertImageToBase64($item);
                                    break;
                                case 'cdr':
                                    $fileBase64 = $this->convertCdrToBase64($item);
                                    break;
                                default:
                                    $fileBase64 = null;
                            }

                            $files_base64[] = [
                                'url' => $fileBase64,
                                'name' => $file_name,
                                'size' => $fileSize,
                                'folder' => $folder,
                            ];
                        }
                    }
                }
            }
        }
        return $files_base64;
    }

    public function tmpDelete(Request $request)
    {
        if($request->has('set_index')){ // removed from set_input
            $existingFiles = session('uploaded_files.' . $request->product_id) ?? [];

            foreach ($existingFiles as $index => $existingFile) {
                if($index == $request->set_index){
                    unset($existingFiles[$index]);
                }
            }

            session(['uploaded_files.' . $request->product_id => $existingFiles]);

            return response()->json(['status' => 'success', 'session_data'=>$existingFiles], 200);
        }else{
            $folder = $request->input('file');
            $file_type = $request->input('type');
            $existingFiles = [];

            if ($folder) {
                if (Storage::disk('tmp_upload')->deleteDirectory($folder)) {
                    if (session()->has('uploaded_files.' . $request->product_id)) {
                        $existingFiles = session('uploaded_files.' . $request->product_id);

                        foreach ($existingFiles as $index => $existingFile) {
                            if (isset($existingFile[$file_type]) && in_array($folder, $existingFile[$file_type])) {
                                $existingFiles[$index][$file_type] = array_filter($existingFile[$file_type], fn($item) => $item !== $folder);
                            }
                        }

                        session(['uploaded_files.' . $request->product_id => $existingFiles]);
                    }

                    if($request->has('set_id') && $request->set_id){
                        $set_id = $request->input('set_id');
                        $set = Set::find($set_id);
                        if($set){
                            $uploaded_files = $set->uploaded_files;
                            if(isset($uploaded_files[$file_type])){
                                $uploaded_files[$file_type] = array_filter($uploaded_files[$file_type], fn($item) => $item !== $folder);
                                $set->uploaded_files = $uploaded_files;
                                $set->save();
                            }
                        }
                    }
                    return response()->json(['status' => 'success', 'session_data'=>$existingFiles], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Folder not found or failed to delete'], 400);
                }
            }
        }

    }

    public function convertPdfToBase64($file)
    {
        $imagick = new \Imagick();
        // Read the PDF file and set the first page
        if (is_string($file)) {
            // If $file is a string, check if it's a valid file path
            $imagick->readImage($file);
        }else{
            $imagick->readImage($file->getPathname());
        }

        // Set image format and resolution
        $imagick->setImageFormat('png');
//        $imagick->setResolution(150, 150);  // Adjust resolution as needed

        $imagick->transparentPaintImage(
            $imagick->getImagePixelColor(0, 0),
            0,
            0,
            false
        );

        // Get the image content
        $imageData = $imagick->getImageBlob();

        // Convert to base64
        $base64 = 'data:image/png;base64,' . base64_encode($imageData);

        return $base64;
    }

    public function convertAiOREPSORTIFToBase64($file)
    {
        $pdfPath = tempnam(sys_get_temp_dir(), 'tempfile') . '.pdf';
        $command = "gs -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile={$pdfPath} " . escapeshellarg(is_string($file) ?$file : $file->getPathname());

        // Execute the command
        exec($command, $output, $return_var);
        // Check if Ghostscript command succeeded
        if ($return_var !== 0) {
            \Log::error('Ghostscript conversion failed: ' . implode("\n", $output));
            return null;
        }

        try {
            $imageData = $this->convertPdfToBase64($pdfPath);
            // Clean up the temporary file
            unlink($pdfPath);

            return $imageData;
        } catch (\ImagickException $e) {
            return null;
        }
    }

    public function convertImageToBase64($file)
    {
        $fileContent = file_get_contents($file);
        if(is_string($file)){
            $mimeType = $this->getFileMimType($file);
        }else{
            $mimeType = $file->getMimeType();
        }

        if ($mimeType === 'image/png') {
            $imagick = new \Imagick();
            if (is_string($file)) {
                $imagick->readImage($file);
            } else {
                $imagick->readImage($file->getPathname());
            }

            // Remove background color (assumes white background)
            $imagick->setImageAlphaChannel(\Imagick::ALPHACHANNEL_SET);
            $imagick->transparentPaintImage(
                $imagick->getImagePixelColor(0, 0),
                0,
                0,
                false
            );

            $imagick->setImageFormat('png');
            $fileContent = $imagick->getImageBlob();
        } else {
            // For other image types, read the file content directly
            $fileContent = file_get_contents(is_string($file) ? $file : $file->getPathname());
        }

        $base64 = 'data:' . $mimeType . ';base64,' . base64_encode($fileContent);

        return $base64;
    }

    public function getFileMimType($file)
    {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $mimeType = 'image/jpeg';
                break;
            case 'png':
                $mimeType = 'image/png';
                break;
            case 'gif':
                $mimeType = 'image/gif';
                break;
            case 'bmp':
                $mimeType = 'image/bmp';
                break;
            case 'svg':
                $mimeType = 'image/svg+xml';
                break;
            default:
                $mimeType = 'application/octet-stream';
                break;
        }

        return $mimeType;
    }

    public function convertCdrToBase64($file)
    {
       //
    }
}
