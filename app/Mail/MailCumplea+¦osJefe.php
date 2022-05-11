<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Colaborador;

class MailCumpleañosJefe extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $Colaborador;
   
    public function __construct(Colaborador $col)
    {
        //
	$this->Colaborador = $col;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recordatorio de Cumpleaños')->view('Plantilla.mailJefe')->with('colaborador', $this->Colaborador);
    }
}
