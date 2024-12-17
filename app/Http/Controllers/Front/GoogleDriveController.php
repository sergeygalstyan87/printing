<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    public static function getDriveService()
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
        $client->addScope(Drive::DRIVE);

        return new Drive($client);
    }

    /**
     * get file info
     *
     * @return mixed|object
     */
    public static function getFileInfo($file_path)
    {
        $fileMetadata = Storage::disk('google')->getMetadata($file_path);

        $path = $fileMetadata['path'];
        $file_id = explode('/', $path);
        $file_name = $fileMetadata['name'];
        $ext = $fileMetadata['extension'];

        return (object) [
            'filename' => $file_name,
            'ext' => $ext,
            'path' => $path,
            'fileId' => $file_id[1],
        ];
    }

    /**
     * get file from gdrive
     *
     * @return mixed
     */
    public static function get($file_path)
    {
        $fileinfo = self::getFileInfo($file_path);

        $rawData = Storage::disk('google')->get($fileinfo->fileId);

        return (object) [
            'file' => $rawData,
            'ext' => $fileinfo->ext,
            'filename' => $fileinfo->filename,
        ];
    }

    /**
     * make directory
     *
     * @return mixed|void
     */
    public static function makeDir($dirname)
    {
        Storage::disk('google')->makeDirectory($dirname);
    }

    /**
     * delete directory
     *
     * @return mixed|void
     */
    public static function deleteDir($dirpath)
    {
        Storage::disk('google')->deleteDirectory($dirpath);
    }
    public static function createFolder($folder_name, $driveService, $parent_folder_id)
    {
        $fileMetadata = new \Google\Service\Drive\DriveFile(array(
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($parent_folder_id) // Set the correct parent folder ID
        ));

        $folder = $driveService->files->create($fileMetadata, array(
            'fields' => 'id'
        ));

        $folder_id = $folder->id;

        // Set permissions for the folder
        $permission = new \Google\Service\Drive\Permission();
        $permission->setType('anyone');
        $permission->setRole('reader');
        $driveService->permissions->create($folder_id, $permission);

        return $folder_id;
    }

    public static function upload($image, $order_id=null, $product_title=null)
    {
        $ext = $image->getClientOriginalExtension();
        $new_name = rand() . '.' . $ext;
        $date = date('Y_m_d');
        $product_folder_name = $date;

        $driveService = self::getDriveService();

        // Check if the folder for the product title exists
        $product_folder_id = null;
        $product_folder_exists = false;

        $response = $driveService->files->listFiles(array(
            'q' => "mimeType='application/vnd.google-apps.folder' and name='$product_folder_name'",
            'spaces' => 'drive',
        ));

        foreach ($response->files as $file) {
            if ($file->name === $product_folder_name) {
                $product_folder_exists = true;
                $product_folder_id = $file->id;
                break;
            }
        }

        // If the folder for the product title doesn't exist, create it
        if (!$product_folder_exists) {
            // Create the product folder under the main parent folder
            $product_folder_id = self::createFolder($product_folder_name, $driveService, env('GOOGLE_DRIVE_FOLDER_ID'));
        }

        // If order_id is provided, create the folder for order ID within the product folder
        if ($order_id) {
            $order = Order::where('id', $order_id)->first();
            $est_number = $order->est_number;
            // Check if the folder for the order ID exists under the product folder
            $order_folder_id = null;
            $order_folder_exists = false;

            $response = $driveService->files->listFiles(array(
                'q' => "mimeType='application/vnd.google-apps.folder' and name='$est_number' and '{$product_folder_id}' in parents",
                'spaces' => 'drive',
            ));

            foreach ($response->files as $file) {
                if ($file->name === $est_number) {
                    $order_folder_exists = true;
                    $order_folder_id = $file->id;
                    break;
                }
            }

            // If the folder for the order ID doesn't exist under the product folder, create it
            if (!$order_folder_exists) {
                // Create the order folder under the product folder
                $order_folder_id = self::createFolder($est_number, $driveService, $product_folder_id);
            }

            // Upload the file to the order folder
            $path = Storage::disk('google')->putFileAs($order_folder_id, $image, $new_name);
        } else {
            // If order_id is not provided, upload the file directly to the product folder
            $path = Storage::disk('google')->putFileAs($product_folder_id, $image, $new_name);
        }

        // Retrieve the file ID from Google Drive
        $fileId = self::getFileInfo($path)->fileId;

        return $fileId;
    }

    public static function deleteFolder($folder_name){
        $driveService = self::getDriveService();
        $response = $driveService->files->listFiles(array(
            'q' => "mimeType='application/vnd.google-apps.folder' and name='$folder_name'",
            'spaces' => 'drive',
        ));

        if(count($response->files)){
            $driveService->files->delete($response->files[0]->id);
        }
    }

    public static function deleteFile(string $file_id){
        $driveService = self::getDriveService();
        $driveService->files->delete($file_id);
    }
}
