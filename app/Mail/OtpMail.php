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
    public $otp_id;

    /**
     * Create a new message instance.
     */
    public function __construct($otp_code, $nama, $otp_id = null)
    {
        $this->otp_code = $otp_code;
        $this->nama = $nama;
        $this->otp_id = $otp_id;
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
                'otp_id' => $this->otp_id,
            ]);
    }
}
