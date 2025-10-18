<?php

namespace App\Mail;

use App\Models\Donation;
use App\Models\RecipientRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;



class DonationMatched extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;
    public $request;

    public function __construct(Donation $donation, RecipientRequest $request)
    {
        $this->donation = $donation;
        $this->request = $request;
    }

    public function build()
    {
        return $this->subject('Your Donation Has Been Matched with a Recipient!')
                    ->view('emails.donation-matched')
                    ->with([
                        'donation' => $this->donation,
                        'request' => $this->request
                    ]);
    }
}