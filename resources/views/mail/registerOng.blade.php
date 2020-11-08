@component('mail::message')
    

<h1>Obrigado por fazer parte de nossa comunidade de ongs {{ $nomeFantasia }}.</h1>

 <p>
    Todos nós recebemos vocês de braços abertos e esperamos que gostem da nossa plataforma.
    Por favor acesse esse <a href="{{ $urlRegisterOng }}" target="_blank">link</a> para continuarmos 
    seu cadastro.
 </p>



@endcomponent()