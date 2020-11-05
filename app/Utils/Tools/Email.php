<?php 

namespace Utils\Tools;

use Mail;

class Email {

    public function sendEmail($page, $to, $name) 
    {
        Mail::send($page, ['nomeFatasia' => $nome], function ($message) {
			$message->from('onuniapi@gmail.com', 'OnUni');
			$message->subject('Confirmação de conta OnUni');
			$message->to($to, 'John Doe');
		});
    }

}