<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\TransactionModel;

class StrukTransaksiMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Variabel publik akan otomatis tersedia di dalam view email.
     */
    public $transaction;

    /**
     * Create a new message instance.
     */
    public function __construct(TransactionModel $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Struk Transaksi - ' . $this->transaction->kode_transaksi,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Menentukan view Blade yang akan digunakan sebagai badan email.
        return new Content(
            view: 'emails.struk_transaksi',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
