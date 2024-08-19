<x-mail::message>
<p>Bonjour {{$user->nom}},</p>

@if ($otp->type=='verification')
Nous avons recus votre demande de verification de votre compte pangolin par votre adresse e-mail.
Votre code de verification Pangolin est le :
@endif

@if ($otp->type=='password-reset')
Nous avons reçu votre demande de réinitialisation de votre mot de passe.
Vous pouvez utiliser ce code pour réinitialiser votre mot de passe :
@endif 
<p>
    <strong>{{$otp->code}}</strong>
</p>
<h4>
    veuillez ne pas partager ce code avec quiconque.
</h4>
Merci,<br>

<p style="color: #1fc5e2; font-size: 30px; font-weight: bold"> {{ config('app.name') }}</p>
</x-mail::message>
