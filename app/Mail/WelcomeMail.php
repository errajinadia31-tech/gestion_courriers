<?php

namespace App\Mail;  // 🔹 مهم بزاف

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $courrier;

    public function __construct($courrier = null)
    {
        $this->courrier = $courrier;
    }

    public function build()
    {
        $mail = $this->view('emails.email')
                     ->subject('Nouveau Courrier Reçu');

        if ($this->courrier && $this->courrier->file) {
            $filePath = storage_path('app/public/' . $this->courrier->file);
            if (file_exists($filePath)) {
                $mail->attach($filePath, [
                    'as' => 'courrier_'.$this->courrier->reference.'.pdf',
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $mail;
    }
}