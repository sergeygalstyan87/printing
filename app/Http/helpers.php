<?php

use App\Models\Setting;
use App\Services\AlertService;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use \Gumlet\ImageResize;

function setting($key)
{
    return Setting::where('key', $key)->first()->value;
}

function alerts()
{
    return (new AlertService())->getItems();
}

function upload($image, $resize = false)
{
    $image_original_name = str_replace(' ', '-', $image->getClientOriginalName());
    $image_name = strtotime(now()) . $image_original_name;
    Storage::disk('public_uploads')->put($image_name, file_get_contents($image));
    if ($resize) {
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize(public_path('storage/content/'.$image_name));

        $image = new ImageResize(public_path('storage/content/'.$image_name));

        // Resize the image
        $image->resize(320, 260);
        $image->save(public_path('storage/content/small-images/'.$image_name));
    }

    return $image_name;
}

function upload_templates($file)
{
    $randomNumber = rand(10000, 99999);
    $file_original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $file_original_name = str_replace(' ', '-', $file_original_name);
    $file_extension = $file->getClientOriginalExtension();

    $file_name = $file_original_name . '-' . $randomNumber . '.' . $file_extension;

    Storage::disk('public_template_uploads')->put($file_name, file_get_contents($file));

    return $file_name;
}
function upload_type_img($file)
{
    $randomNumber = rand(10000, 99999);
    $file_original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $file_original_name = str_replace(' ', '_', $file_original_name);
    $file_extension = $file->getClientOriginalExtension();

    $file_name = $file_original_name . '_' . $randomNumber . '.' . $file_extension;

    Storage::disk('public_type_uploads')->put($file_name, file_get_contents($file));

    return $file_name;
}
function upload_product_images_by_type($file)
{
    $randomNumber = rand(10000, 99999);
    $file_original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $file_original_name = str_replace(' ', '_', $file_original_name);
    $file_extension = $file->getClientOriginalExtension();

    $file_name = $file_original_name . '_' . $randomNumber . '.' . $file_extension;

    Storage::disk('product_images_by_type')->put($file_name, file_get_contents($file));

    return $file_name;
}


function uploadOrderProof($file)
{
    $file_original_name = str_replace(' ', '-', $file->getClientOriginalName());
    $file_name = strtotime(now()) . $file_original_name;
    Storage::disk('public_proof_uploads')->put($file_name, file_get_contents($file));

    return $file_name;
}

function deleteOrderProof($file_name) {
    return Storage::disk('public_proof_uploads')->delete($file_name);
}

function getFileIconByExtension($filename)
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $icons = [
        'jpeg' => asset('front/assets/images/icons/template_icons/tmp_jpeg.svg'),
        'jpg' => asset('front/assets/images/icons/template_icons/tmp_jpeg.svg'),
        'pdf' => asset('front/assets/images/icons/template_icons/tmp_pdf.svg'),
        'psd' => asset('front/assets/images/icons/template_icons/tmp_psd.svg'),
        'ai' => asset('front/assets/images/icons/template_icons/tmp_ai.svg'),
    ];

    return $icons[$extension] ?? asset('front/assets/images/icons/template_icons/tmp_jpeg.svg');
}

function getAddDesignUrl($product_id, $project_id)
{
    return env('ADD_DESIGN_URL')."?product_id=$product_id&project_id=$project_id";
}