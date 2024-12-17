<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubscriptionRequest;
use App\Jobs\SendNewMarketingEmail;
use App\Mail\MarketingEmail;
use App\Models\SentEmail;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    protected $subscriptionService = null;

    public function __construct( SubscriptionService $subscriptionService )
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $items = $this->subscriptionService->getItems();
        return view('dashboard.pages.subscriptions.index', compact('items'));
    }

    public function add()
    {
        return view('dashboard.pages.subscriptions.form');
    }

    public function store(SubscriptionRequest $request)
    {
        $this->subscriptionService->create($request->except('_token'));
        return redirect()->route('dashboard.subscriptions.index');
    }

    public function storeFromFront(SubscriptionRequest $request)
    {
        $this->subscriptionService->create($request->except('_token'));
        return response()->json(['message' => 'Subscription successful'], 200);
    }

    public function edit($id)
    {
        $item = $this->subscriptionService->getItem($id);
        return view('dashboard.pages.subscriptions.form', compact(['item']));
    }

    public function update(SubscriptionRequest $request, $id)
    {
        $this->subscriptionService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.subscriptions.index');
    }

    public function delete($id)
    {
        $this->subscriptionService->delete($id);
        return redirect()->route('dashboard.subscriptions.index')->with('success', 'Subscription deleted successfully');
    }

    public function unsubscribe($email)
    {
        $subscription = $this->subscriptionService->getItemByEmail($email);
        if ($subscription) {
            $subscription->delete();
        }
    }

    public function sendEmail(Request $request)
    {
        $subject = $request->input('email_subject');
        $text = $request->input('email_text');

        // Invoke the Artisan command
        Artisan::call('mail:send', [
            '--subject' => $subject,
            '--text' => $text,
        ]);

        return response()->json(['success' => true]);
    }
}
