<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    // UBAH: Kita tidak lagi menggunakan $user, tapi properti terpisah
    public string $name;
    public string $code;

    /**
     * Create a new message instance.
     * UBAH: Constructor sekarang menerima nama dan kode secara langsung
     */
    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode Verifikasi Akun Anda',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification-code', // <-- MENJADI SEPERTI INI
            with: [
                'name' => $this->name,
                'code' => $this->code,
            ],
        );
    }
}
