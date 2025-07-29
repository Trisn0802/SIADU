<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp_code;
    public $nama;

    /**
     * Create a new message instance.
     */
    public function __construct($otp_code, $nama)
    {
        $this->otp_code = $otp_code;
        $this->nama = $nama;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Kode OTP SIADU')
            ->view('emails.otp')
            ->with([
                'otp_code' => $this->otp_code,
                'nama' => $this->nama,
            ]);
    }
}
