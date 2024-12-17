<?php

namespace App\Console\Commands;

use App\Mail\MarketingEmail;
use App\Models\SentEmail;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {--subject= : The subject of the email} {--text= : The content of the email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a marketing email to a subscribe users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subject = $this->option('subject');
        $text = $this->option('text');

        if (empty($subject) || empty($text)) {
            $this->error('Subject and text parameters are required.');
            return 1; // Error exit code
        }

        $subscribers = Subscription::all();
        foreach ($subscribers as $subscriber) {
            $sentEmail = SentEmail::create([
                'email' => $subscriber->email,
                'subject' => $subject,
                'content' => $text,
            ]);
            Mail::to($subscriber->email)->send(new MarketingEmail($subject, $text));
            $sentEmail->update(['sent' => true]);
        }


        $this->info('Marketing emails sent successfully!');
        return 0;
    }
}
