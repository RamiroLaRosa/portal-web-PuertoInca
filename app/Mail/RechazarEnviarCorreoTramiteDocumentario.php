<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RechazarEnviarCorreoTramiteDocumentario extends Mailable
{
    use Queueable, SerializesModels;
    public $areaorigen;
    public $asunto;
    public $solicitante;
    public $codigotd;
    public $motivoRechazo;
    public $file;
    public $nombredoc;



    /**
     * Create a new message instance.
     */
    public function __construct($areaorigen, $asunto, $solicitante, $codigotd, $motivoRechazo, $file, $nombredoc)
    {


        $this->areaorigen = $areaorigen;
        $this->asunto = $asunto;
        $this->solicitante = $solicitante;
        $this->codigotd = $codigotd;
        $this->motivoRechazo = $motivoRechazo;
        $this->file = $file;
        $this->nombredoc = $nombredoc;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Tramite Documentario Rechazado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.rechazar.correotramitedoc',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {


        return [
            Attachment::fromPath($this->file['attachment'])
                ->as( $this->nombredoc)
                ->withMime('application/pdf')
        ];
    }
}
