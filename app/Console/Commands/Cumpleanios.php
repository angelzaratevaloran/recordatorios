<?php

namespace App\Console\Commands;

use App\Colaborador;
use App\Mail\CumpleaniosEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

include_once "vendor/swiftmailer/swiftmailer/lib/swift_required.php";

class Cumpleanios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Email:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia correo a los cumpleanieros';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        // set var email

        config([
            'mail.username' => config('mail.mail_cuentanos'), 
            'mail.password' => config('mail.pass_cuentanos'), 
            'mail.from.address' =>  config('mail.mail_cuentanos'), 
            'mail.from.name' => config('mail.name_cuentanos')
        ]);
        $cumpleaños = Colaborador::getCumpleañosHoy();
        $this->info('Fecha: ' . date('y-m-d'));
        foreach ($cumpleaños as $c) {
            if ($c->correo != '') {
                Mail::to($c->correo)->send(new CumpleaniosEmail($c));
                try {
                    $this->info('Correo enviado a  ' . $c->correo);
                } catch (Exception $ex) {}

            }
            if ($c->correoJefeInmediato && $c->correoDirector) {
                try {
                    $this->SendEvento($c->correoJefeInmediato, $c->correoDirector, $c->nombre, $c->puesto, $c->UDN);
                } catch (Exception $ex) {
                }

                // $this->SendEvento2($c->correoJefeInmediato , $c->correoDirector, $c->nombre, $c->puesto , $c->UDN);
            } else {
                if ($c->correoJefeInmediato) {
                    try {
                        $this->SendEvento2($c->correoJefeInmediato, $c->nombre, $c->puesto, $c->UDN);
                    } catch (Exception $ex) {

                    }

                } else {
                    try {
                        $this->SendEvento2($c->correoDirector, $c->nombre, $c->puesto, $c->UDN);
                    } catch (Exception $ex) {

                    }

                }
            }
            //$this->SendEvento($c->correoJefeInmediato , $c->correoDirector, $c->nombre, $c->puesto , $c->UDN);

            $this->info('Evento enviado a  ' . $c->correoJefeInmediato . ', ' . $c->correoDirector);
            //    Mail::to($c->correoJefeInmediato)->send(new MailCumpleañosJefe($c));

        }
        $this->info('Cumpleaños .- Los mensajes de felicitacion han sido enviados correctamente');
    }

    public function SendEvento($emailJefeDirecto, $correoDirector, $cumpleañero, $puesto, $udn)
    {

        $from_address = config('mail.username');
        $organizer = $from_address;
        $from = array($from_address);
        $subject = utf8_encode('Cumpleaños de ' . $cumpleañero);
        $topic = utf8_encode("cumpleaños valoran");
        $summary = utf8_encode("cumpleaños valoran");
        $description = utf8_encode("cumpleaños valoran");
        $location = $udn;
        $to = array(
            $emailJefeDirecto,
            $correoDirector,
        );

        $transport = new \Swift_SmtpTransport(config('mail.host'), config('mail.port'), config('mail.encryption'));
        $transport->setUsername(config('mail.username'));
        $transport->setPassword(config('mail.password'));
        $swift = new \Swift_Mailer($transport);

        $nl = "\r\n";
        $attendee = "";
        $to_string = "";
        foreach ($to as $e => $n) {
            $e = is_integer($e) ? $n : $e;
            $attendee .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;";
            $attendee .= "PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=$n;X-NUM-GUESTS=0:mailto:$e$nl";
            $to_string .= $e . ",";
        }
        $to_string = substr($to_string, 0, strlen($to_string) - 1);
        $src_tz = new \DateTimeZone('America/Mexico_City');
        $destination_tz = new \DateTimeZone('GMT');
        date_default_timezone_set($src_tz->getName());
        $today = date("Y-m-d H:i");
        $meeting_time = new \DateTime($today, $src_tz);
        $meeting_time->setTimezone($destination_tz);
        $dt_stamp = $meeting_time->format("Ymd\THis\Z");
        $dt_start = $meeting_time->add(new \DateInterval("PT20M"))->format("Ymd\THis\Z");
        $dt_end = $meeting_time->add(new \DateInterval("PT30M"))->format("Ymd\THis\Z");
        $repeat_rule = "";
        $eventStatus = "CONFIRMED"; /* TENTATIVE,CONFIRMED,CANCELLED */
        $html = file_get_contents("app/Console/Commands/mail.html");

        $html = str_replace("__INFO__", "Hoy es el Cumplea&ntilde;os de <strong>" . $cumpleañero . "</strong> <br> quien ocupa el puesto de " . $puesto, $html);

        $calendar_invite = utf8_encode(file_get_contents("app/Console/Commands/skeleton.txt"));

        $calendar_invite = str_replace("__FROM__", $from_address, $calendar_invite);
        $calendar_invite = str_replace("__TO__", $to_string, $calendar_invite);
        $calendar_invite = str_replace("__SUBJECT__", $subject, $calendar_invite);
        $calendar_invite = str_replace("__TOPIC__", $topic, $calendar_invite);
        $calendar_invite = str_replace("__ORGANIZER__", $organizer, $calendar_invite);
        $calendar_invite = str_replace("__ATTENDEE__", $attendee, $calendar_invite);
        $calendar_invite = str_replace("__DESCRIPTION__", $description, $calendar_invite);
        $calendar_invite = str_replace("__LOCATION__", $location, $calendar_invite);
        $calendar_invite = str_replace("__SUMMARY__", $summary, $calendar_invite);
        $calendar_invite = str_replace("__EVENT_STATUS__", $eventStatus, $calendar_invite);
        $calendar_invite = str_replace("__HTML__", $html, $calendar_invite);
        $calendar_invite = str_replace("__DTSTART__", date("Ymd"), $calendar_invite);
        $calendar_invite = str_replace("__DTEND__", date('Ymd', strtotime("+1 day", strtotime(date('Ymd')))), $calendar_invite);
        $calendar_invite = str_replace("__DTSTAMP__", $dt_stamp, $calendar_invite);
        $calendar_invite = str_replace("__REPEAT_RULE__", $repeat_rule, $calendar_invite);
        $calendar_invite = str_replace("__BOUNDARY__", md5(time()) . rand(0, 99999999), $calendar_invite);

        $messageObject = new \Swift_MyMessage();
        $messageObject->setFrom($from);
        $messageObject->setTo($to);

        $messageObject->setRawContent(iconv("UTF-8", "Windows-1252", $calendar_invite));

        if ($recipients = $swift->send($messageObject, $failures)) {
            echo 'Calendar invitation successfully sent!';
        } else {
            echo "There was an error:\n";
            print_r($failures);
        }

    }

    public function SendEvento2($emailJefeDirecto, $cumpleañero, $puesto, $udn)
    {

        $from_address = config('mail.username');
        $organizer = $from_address;
        $from = array($from_address);
        $subject = utf8_encode('Cumpleaños de ' . $cumpleañero);
        $topic = utf8_encode("cumpleaños valoran");
        $summary = utf8_encode("cumpleaños valoran");
        $description = utf8_encode("cumpleaños valoran");
        $location = $udn;
        $to = array(
            $emailJefeDirecto,
        );

        $transport = new \Swift_SmtpTransport(config('mail.host'), config('mail.port'), config('mail.encryption'));
        $transport->setUsername(config('mail.username'));
        $transport->setPassword(config('mail.password'));
        $swift = new \Swift_Mailer($transport);

        $nl = "\r\n";
        $attendee = "";
        $to_string = "";
        foreach ($to as $e => $n) {
            $e = is_integer($e) ? $n : $e;
            $attendee .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;";
            $attendee .= "PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=$n;X-NUM-GUESTS=0:mailto:$e$nl";
            $to_string .= $e . ",";
        }
        $to_string = substr($to_string, 0, strlen($to_string) - 1);
        $src_tz = new \DateTimeZone('America/Mexico_City');
        $destination_tz = new \DateTimeZone('GMT');
        date_default_timezone_set($src_tz->getName());
        $today = date("Y-m-d H:i");
        $meeting_time = new \DateTime($today, $src_tz);
        $meeting_time->setTimezone($destination_tz);
        $dt_stamp = $meeting_time->format("Ymd\THis\Z");
        $dt_start = $meeting_time->add(new \DateInterval("PT20M"))->format("Ymd\THis\Z");
        $dt_end = $meeting_time->add(new \DateInterval("PT30M"))->format("Ymd\THis\Z");
        $repeat_rule = "";
        $eventStatus = "CONFIRMED"; /* TENTATIVE,CONFIRMED,CANCELLED */
        $html = file_get_contents("app/Console/Commands/mail.html");

        $html = str_replace("__INFO__", "Hoy es el Cumplea&ntilde;os de <strong>" . $cumpleañero . "</strong> <br> quien ocupa el puesto de " . $puesto, $html);

        $calendar_invite = utf8_encode(file_get_contents("app/Console/Commands/skeleton.txt"));

        $calendar_invite = str_replace("__FROM__", $from_address, $calendar_invite);
        $calendar_invite = str_replace("__TO__", $to_string, $calendar_invite);
        $calendar_invite = str_replace("__SUBJECT__", $subject, $calendar_invite);
        $calendar_invite = str_replace("__TOPIC__", $topic, $calendar_invite);
        $calendar_invite = str_replace("__ORGANIZER__", $organizer, $calendar_invite);
        $calendar_invite = str_replace("__ATTENDEE__", $attendee, $calendar_invite);
        $calendar_invite = str_replace("__DESCRIPTION__", $description, $calendar_invite);
        $calendar_invite = str_replace("__LOCATION__", $location, $calendar_invite);
        $calendar_invite = str_replace("__SUMMARY__", $summary, $calendar_invite);
        $calendar_invite = str_replace("__EVENT_STATUS__", $eventStatus, $calendar_invite);
        $calendar_invite = str_replace("__HTML__", $html, $calendar_invite);
        $calendar_invite = str_replace("__DTSTART__", date("Ymd"), $calendar_invite);
        $calendar_invite = str_replace("__DTEND__", date('Ymd', strtotime("+1 day", strtotime(date('Ymd')))), $calendar_invite);
        $calendar_invite = str_replace("__DTSTAMP__", $dt_stamp, $calendar_invite);
        $calendar_invite = str_replace("__REPEAT_RULE__", $repeat_rule, $calendar_invite);
        $calendar_invite = str_replace("__BOUNDARY__", md5(time()) . rand(0, 99999999), $calendar_invite);

        $messageObject = new \Swift_MyMessage();
        $messageObject->setFrom($from);
        $messageObject->setTo($to);

        $messageObject->setRawContent(iconv("UTF-8", "Windows-1252", $calendar_invite));

        if ($recipients = $swift->send($messageObject, $failures)) {
            echo 'Calendar invitation successfully sent!';
        } else {
            echo "There was an error:\n";
            print_r($failures);
        }

    }

}
