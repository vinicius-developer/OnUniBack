<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterDoadorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $nome;
    public $sobrenome;
    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $nome, $sobrenome, $id)
    {
        $this->email = $email;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$url = 'https://onuni.herokuapp.com/autenticacao/active/activeUsr.html?id=' . $this->id;
        $url = 'http://127.0.0.1:8001/autenticacao/active/activeUsr.html?id=' . $this->id;

        $this->from('onuniapi@gmail.com', 'OnUni');
        $this->subject('Confirmação de conta OnUni');
        $this->to($this->email, $this->nome . " " . $this->sobrenome);
        return $this->markdown('mail.registerDoadores', [
            'nome' => $this->nome,
            'urlRegisterDoador' => $url
        ]);
    }
}