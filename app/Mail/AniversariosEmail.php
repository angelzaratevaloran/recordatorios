<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Colaborador;
use App\Plantilla;


class AniversariosEmail extends Mailable
{
    use Queueable, SerializesModels;

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
        return $this->subject(Plantilla::where('Name' , '=', 'Aniversario laboral')->first()->Asunto)->view('Plantilla.mail')->with('colaborador', $this->colaborador)->with('plantilla' , Plantilla::where('Name' , '=', 'Aniversario laboral')->first());
    }
}
