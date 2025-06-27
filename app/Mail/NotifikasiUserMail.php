<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role;

    public function __construct($judul, $pesan, $penanggap = null, $tanggal = null, $judulPengaduan = null, $url = null, $role = null)
    {
        $this->judul = $judul;
        $this->pesan = $pesan;
        $this->penanggap = $penanggap;
        $this->tanggal = $tanggal;
        $this->judulPengaduan = $judulPengaduan;
        $this->url = $url;
        $this->role = $role;
    }

    public function build()
    {
        return $this->subject($this->judul)
            ->view('backend/emails.notifikasi_user');
    }

}
