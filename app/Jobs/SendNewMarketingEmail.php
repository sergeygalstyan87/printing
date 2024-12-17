<?php

namespace App\Jobs;

use App\Mail\MarketingEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewMarketingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $sentEmail;

    public function __construct($sentEmail)
    {
        $this->sentEmail = $sentEmail;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->sentEmail->email)->send(new MarketingEmail($this->sentEmail->subject, $this->sentEmail->content));
        $this->sentEmail->update(['sent' => true]);
    }
}
