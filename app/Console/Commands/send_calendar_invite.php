<?php
// include_once "lib/swift_required.php";

// $credentials = explode("\r\n", file_get_contents("gmail.txt"));
// $from_address = $credentials[3];
// $organizer = $from_address;
// $from = array($from_address);
// $subject = 'Calendar invite using Php & SwiftMailer';
// $topic = "Some Calendar Topic";
// $summary = "Some Calendar Summary";
// $description = "Some Calendar Description";
// $location = "Some Calendar Location";
// $to = array(
//     'angelzarate@valoran.com.mx'    
// );

// $transport = Swift_SmtpTransport::newInstance($credentials[0], intval($credentials[1]), $credentials[2]);
// $transport->setUsername($from_address);
// $transport->setPassword($credentials[4]);
// $swift = Swift_Mailer::newInstance($transport);

// $nl = "\r\n";
// $attendee = "";
// $to_string = "";
// foreach ($to as $e => $n) {
//     $e = is_integer($e) ? $n : $e;
//     $attendee .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;";
//     $attendee .= "PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=$n;X-NUM-GUESTS=0:mailto:$e$nl";
//     $to_string .= $e . ",";
// }
// $to_string = substr($to_string, 0, strlen($to_string) - 1);
// $src_tz = new DateTimeZone('Asia/Dhaka');
// $destination_tz = new DateTimeZone('GMT');
// date_default_timezone_set($src_tz->getName());
// $today = date("Y-m-d H:i");
// $meeting_time = new DateTime($today, $src_tz);
// $meeting_time->setTimezone($destination_tz);
// $dt_stamp =  $meeting_time->format("Ymd\THis\Z");
// $dt_start = $meeting_time->add(new DateInterval("PT20M"))->format("Ymd\THis\Z");
// $dt_end = $meeting_time->add(new DateInterval("PT30M"))->format("Ymd\THis\Z");

// $repeat_rule = "";
// //$repeat_rule = $nl . "RRULE:FREQ=WEEKLY;COUNT=2;BYDAY=WE,FR";
// //$repeat_rule = $nl . "RRULE:FREQ=WEEKLY;UNTIL=20170228T040000Z;BYDAY=MO,TU,WE,TH,FR";
// //$repeat_rule = $nl . "RRULE:FREQ=MONTHLY;COUNT=4;BYMONTHDAY=4";

// $eventStatus = "CONFIRMED"; /* TENTATIVE,CONFIRMED,CANCELLED */

// $html = utf8_encode(file_get_contents("mail.html"));
// $calendar_invite = file_get_contents("skeleton.txt");

// $calendar_invite = str_replace("__FROM__", $from_address, $calendar_invite);
// $calendar_invite = str_replace("__TO__", $to_string, $calendar_invite);
// $calendar_invite = str_replace("__SUBJECT__", $subject, $calendar_invite);
// $calendar_invite = str_replace("__TOPIC__", $topic, $calendar_invite);
// $calendar_invite = str_replace("__ORGANIZER__", $organizer, $calendar_invite);
// $calendar_invite = str_replace("__ATTENDEE__", $attendee, $calendar_invite);
// $calendar_invite = str_replace("__DESCRIPTION__", $description, $calendar_invite);
// $calendar_invite = str_replace("__LOCATION__", $location, $calendar_invite);
// $calendar_invite = str_replace("__SUMMARY__", $summary, $calendar_invite);
// $calendar_invite = str_replace("__EVENT_STATUS__", $eventStatus, $calendar_invite);
// $calendar_invite = str_replace("__HTML__", $html, $calendar_invite);
// $calendar_invite = str_replace("__DTSTART__", $dt_start, $calendar_invite);
// $calendar_invite = str_replace("__DTEND__", $dt_end, $calendar_invite);
// $calendar_invite = str_replace("__DTSTAMP__", $dt_stamp, $calendar_invite);
// $calendar_invite = str_replace("__REPEAT_RULE__", $repeat_rule, $calendar_invite);
// $calendar_invite = str_replace("__BOUNDARY__", md5(time()) . rand(0, 99999999), $calendar_invite);

// $messageObject = new Swift_MyMessage();
// $messageObject->setFrom($from);
// $messageObject->setTo($to);
// $messageObject->setRawContent($calendar_invite);

// if ($recipients = $swift->send($messageObject, $failures)) {
//     echo 'Calendar invitation successfully sent!';
// }
// else {
//     echo "There was an error:\n";
//     print_r($failures);
// }
?>
