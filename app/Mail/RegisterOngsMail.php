<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterOngsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $name;
    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $id)
    {
        $this->email = $email;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$url = 'https://onuni.herokuapp.com/autenticacao/active/activeOng.html?id=' . $this->id;
        $url = 'http://127.0.0.1:8001/autenticacao/active/activeOng.html?id=' . $this->id;

        $this->from('onuniapi@gmail.com', 'OnUni');
        $this->subject('Confirmação de conta OnUni');
        $this->to($this->email, $this->name);
        return $this->markdown('mail.registerOng', [
            'nomeFantasia' => $this->name,
            'urlRegisterOng' => $url
        ]);
    }
}
