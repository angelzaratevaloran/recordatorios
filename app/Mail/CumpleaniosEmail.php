<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Colaborador;
use App\Plantilla;


class CumpleaniosEmail extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;


    private $colaborador;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Colaborador $_colaborador)
    {
        //
        $this->colaborador = $_colaborador;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Plantilla::where('Name' , '=', 'Cumpleaños')->first()->Asunto)->view('Plantilla.mail')->with('colaborador', $this->colaborador)->with('plantilla' , Plantilla::where('Name' , '=', 'Cumpleaños')->first());
    }
}
