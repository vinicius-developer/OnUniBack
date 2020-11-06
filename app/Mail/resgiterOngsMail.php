<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resgiterOngsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('onuniapi@gmail.com', 'OnUni');
        $this->subject('Confirmação de conta OnUni');
        $this->to($this->email, $this->name);
        return $this->markdown('mail.registerOng', [
            'nomeFantasia' => $this->name,
            'urlRegisterOng' => "https://www.youtube.com/watch?v=exPc4kmJOrM&t=399s"
        ]);
    }
}
