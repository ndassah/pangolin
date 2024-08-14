<x-mail::message>
<p>Bonjour {{$user->nom}},</p>
<p>
    Nous avons recus votre demande de verification de votre compte pangolin par votre adresse e-mail. <br>
    Votre code de verification Pangolin est le :
</p>
<p>
    <strong>{{$code}}</strong>
</p>
<h4>
    veuillez ne pas partager ce code avec quiconque.
</h4>
Merci,<br>
{{ config('app.name') }}
</x-mail::message>
