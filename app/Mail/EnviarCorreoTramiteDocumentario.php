<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarCorreoTramiteDocumentario extends Mailable
{
    use Queueable, SerializesModels;

    public $asunto;
    public $solicitante;
    public $codigotd;

    /**
     * Create a new message instance.
     */
    public function __construct($asunto, $solicitante, $codigotd)
    {

        $this->asunto = $asunto;
        $this->solicitante = $solicitante;
        $this->codigotd = $codigotd;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        //configuracion mensaje del ASUNTO del correo
        return new Envelope(
            subject: 'Solicitud de Tramite Documentario',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        //vista del contenido del correo
        return new Content(
            view: 'mail.solicitar.correotramitedoc',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        //nos permite adjuntar archivos
        return [];
    }
}
