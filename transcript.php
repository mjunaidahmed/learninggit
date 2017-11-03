<?php

// read the webhook sent by LiveChat
$data = json_decode(file_get_contents('php://input'));

// make sure the "Ticket Created" event occured
if ($data->event_type === 'ticket_created')
{
   //basic PHP mail
   /*$to      = 'support@mac-solutions.co.uk';
   $subject = $data->ticket->subject.'(LiveChat Ref: '.$data->ticket->id.')';
   $message = $data->ticket->events[0]->message;
   $headers = 'From: '.$data->ticket->requester->name. "\r\n".
    'Reply-To: ' .$data->ticket->requester->mail. "\r\n" .
    'X-Mailer: PHP/' . phpversion();

   mail($to, $subject, $message, $headers);*/
   
   //Alternative email using SMTP
  //include('Mail.php');
    require_once "Mail.php";

    $recipients = 'junaid.a@mac-solutions.co.uk';

    $headers['From']    = $data->ticket->requester->name;
    $headers['To']      = $data->ticket->requester->mail;
    $headers['Subject'] = $data->ticket->subject.'(LiveChat Ref: '.$data->ticket->id.')';

    $body = $data->ticket->events[0]->message;

    $smtpinfo["host"] = "smtp.office365.com";
    $smtpinfo["port"] = "587";
    $smtpinfo["auth"] = true;
    $smtpinfo["username"] = "support@mac-solutions.co.uk";
    $smtpinfo["password"] = "IhX92%#7";


    // Create the mail object using the Mail::factory method
    $mail_object =& Mail::factory("smtp", $smtpinfo); 

    $mail_object->send($recipients, $headers, $body);
}