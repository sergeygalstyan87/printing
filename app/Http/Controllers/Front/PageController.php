<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\BannerService;
use App\Services\ProductService;
use App\Services\ReviewService;
use App\Services\ServiceService;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Shippo;
use Shippo_Address;
use PDF;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    protected $sliderService = null;
    protected $serviceService = null;
    protected $bannerService = null;
    protected $productService = null;
    protected $reviewService = null;

    public function __construct(
        ProductService $productService,
        SliderService  $sliderService,
        ServiceService $serviceService,
        BannerService  $bannerService,
        ReviewService $reviewService
    )
    {
        $this->sliderService = $sliderService;
        $this->serviceService = $serviceService;
        $this->bannerService = $bannerService;
        $this->productService = $productService;
        $this->reviewService = $reviewService;
    }

    public function home()
    {
        $sliders = $this->sliderService->getItemsWithCategory();
        $slidersMobile = $this->sliderService->getItemsWithCategoryMobile();
        $slidersTablet = $this->sliderService->getItemsWithCategoryTablet();
        $services = $this->serviceService->getItems();
        $banner = $this->bannerService->getItem(1);
        $products = $this->productService->getByCount(12);
        $bestsellers = $this->productService->getRandom(8);
        $reviews = $this->reviewService->getItems();
        $partnersLogo = $this->getAllPartnersLogo();
        return view('front.pages.home', compact(['sliders', 'slidersMobile', 'slidersTablet', 'services', 'banner', 'products', 'bestsellers', 'reviews', 'partnersLogo']));
    }

    public function about()
    {
        View::share('breadcrumb', 'About Us');

        $reviews = $this->reviewService->getItems();

        return view('front.pages.about', compact('reviews'));
    }

    public function faq()
    {
        View::share('breadcrumb', 'FAQ');

        return view('front.pages.faq');
    }

    public function policy()
    {
        View::share('breadcrumb', 'Privacy Policy');

        return view('front.pages.policy');
    }

    public function terms()
    {
        View::share('breadcrumb', 'Terms and Conditions');

        return view('front.pages.termsOfService');
    }

    public function refunds()
    {
        View::share('breadcrumb', 'Refunds');

        return view('front.pages.refunds');
    }

    public function contact()
    {
        View::share('breadcrumb', 'Contact Us');

        return view('front.pages.contact');
    }

    public function search(Request $request)
    {
        $products = $this->productService->searchWithOrder($request->text);
        if (count($products)) {
            $html = '<ul class="search_results">';
            foreach ($products as $product) {
                $images = json_decode($product->images, true);
                $title = preg_replace("/($request->text)/i", "<strong class='text-primary'>$1</strong>", $product->title);
                $html .= '<li>
                                <a href="' . route('product', ['slug' => $product->slug]) . '">
                                    <img src="' . asset('storage/content/' . $images[0]) . '" alt="' . $product->title . '" width="50">
                                    <span>' . $title . '</span>
                                </a>
                            </li>';
            }
            $html .= '</ul>';
            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'html' => '<ul class="search_results"><li>Nothing found</li></ul>',
            ]);
        }
    }

    public function shippo()
    {
        Shippo::setApiKey(env('SHIPPO_TOKEN'));
        $address = Shippo_Address::create([
            'object_purpose' => 'QUOTE',
            'name' => 'John Smith',
            'company' => 'Initech',
            'street1' => '6512 Greene Rd.',
            'city' => 'Woodridge',
            'state' => 'IL',
            'zip' => '60517',
            'country' => 'US',
            'phone' => '773 353 2345',
            'email' => 'jmercouris@iit.com',
            'metadata' => 'Customer ID 23424'
        ]);

        dd($address);
    }

    public function invoice($id)
    {

        $userId = Auth::user()->id;

        $item = Order::find($id);
        if($userId == $item->user_id){

            if(!empty($item->invoice_path)){
                $fileName = $item->invoice_path;
            }else{
                $fileName = $item->generateInvoice();
            }

            $filePath = 'app/public/invoice/' . $fileName;
            if (file_exists(storage_path($filePath))) {
                // If the file exists, return it as a download response
                $filePath = 'invoice/' . $fileName;
                if(isset($_GET['path']) && ($_GET['path'] == 1)){
                    $pdfContent = Storage::get($filePath);

                    $base64EncodedPDF = base64_encode($pdfContent);
                    echo $base64EncodedPDF;
                    exit;
                }else{
                    $filePath = 'app/public/invoice/' . $fileName;
                    return response()->download(storage_path($filePath), $fileName);
                }
// Read the contents of the PDF file

            } else {
                // If the file doesn't exist, return a 404 response
                abort(404);
            }

        }else{
            abort(404);
        }
        /*$pdf = PDF::loadView('front.pages.invoice', compact('item'));

        return $pdf->download('invoice.pdf');*/
    }

    public function getAllPartnersLogo()
    {
        $folderPath = public_path('/front/assets/images/partners-logo');
        if (File::isDirectory($folderPath)) {
            $files = File::files($folderPath);
            $images = [];
            foreach ($files as $file) {
                $images[] = $file->getRelativePathname();
            }
            return $images;
        }
    }

}
