<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class ReservaConfirmacionMail extends Mailable
{
    public function __construct(
        public string $localizador,
        public string $hotel,
        public string $tipo
    ) {}

    public function build()
    {
        return $this
            ->subject('Confirmación de reserva de transfer')
            ->view('emails.reserva_confirmacion');
    }
}
?>