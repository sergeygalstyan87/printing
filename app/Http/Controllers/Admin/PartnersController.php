<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gumlet\ImageResize;
use Gumlet\ImageResizeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PartnersController extends Controller
{
    public function index()
    {
        $directory = public_path('front/assets/images/partners-logo');
        $imageFiles = File::files($directory);

        $imageFileNames = [];
        foreach ($imageFiles as $file) {
            $imageFileNames[] = pathinfo($file, PATHINFO_BASENAME);
        }

        return view('dashboard.pages.partners.form', compact('imageFileNames'));
    }

    public function image_upload(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $urls = [];
        foreach ($request->images as $image) {
            $path = $this->upload($image);
            $urls[] = asset('front/assets/images/partners-logo/' . $path);
        }

        return response()->json(['success' => 1, 'images' => json_encode($urls)], 200);
    }

    /**
     * @throws ImageResizeException
     */
    public function upload($image)
    {
        $image_original_name = str_replace(' ', '-', $image->getClientOriginalName());
        $image_name = time() . '_' . $image_original_name;

        // Store the original image
        $image->move(public_path('front/assets/images/partners-logo'), $image_name);

        return $image_name;
    }

    public function image_delete(Request $request)
    {
        $imagePath = $request->get('image');

        $fullPath = public_path('front/assets/images/partners-logo/' . $imagePath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }
    }
}
