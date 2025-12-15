<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmacionMail;

class ReservaEmailService
{
    public static function enviarConfirmacion(
        string $email,
        string $localizador,
        string $hotel,
        string $tipo
    ): void {
        Mail::to($email)->send(
            new ReservaConfirmacionMail(
                $localizador,
                $hotel,
                $tipo
            )
        );
    }
}
?>