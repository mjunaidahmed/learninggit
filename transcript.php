<?php

// read the webhook sent by LiveChat
$data = json_decode(file_get_contents('php://input'));

// make sure the "Ticket Created" event occured
if ($data->event_type === 'ticket_created')
{
   //basic PHP mail
   $to      = 'support@mac-solutions.co.uk';
   $subject = $data->ticket->subject.'(LiveChat Ref: '.$data->ticket->id.')';
   $message = $data->ticket->events[0]->message;
   $headers = 'From: '.$data->ticket->requester->name. "\r\n".
    'Reply-To: ' .$data->ticket->requester->mail. "\r\n" .
    'X-Mailer: PHP/' . phpversion();

   mail($to, $subject, $message, $headers);
}