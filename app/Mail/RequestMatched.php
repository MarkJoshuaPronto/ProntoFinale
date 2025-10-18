<?php

namespace App\Mail;

use App\Models\RecipientRequest;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;




class RequestMatched extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $donation;

    public function __construct(RecipientRequest $request, Donation $donation)
    {
        $this->request = $request;
        $this->donation = $donation;
    }

    public function build()
    {
        return $this->subject('Your Request Has Been Matched with a Donation!')
                    ->view('emails.request-matched')
                    ->with([
                        'request' => $this->request,
                        'donation' => $this->donation
                    ]);
    }
}