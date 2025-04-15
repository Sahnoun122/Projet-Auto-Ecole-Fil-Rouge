@component('mail::message')
# Bonjour {{ $prenom }},

Nous avons reçu une demande pour réinitialiser votre mot de passe.

Pour procéder à la réinitialisation de votre mot de passe, cliquez sur le bouton ci-dessous :

@component('mail::button', ['url' => $url])
Réinitialiser mon mot de passe
@endcomponent

Le lien ci-dessus est valide pendant **60 minutes**.

Si vous n’avez pas demandé cette réinitialisation, vous pouvez ignorer cet email. Votre mot de passe restera inchangé.

Merci,<br>
**L'équipe de Sahnoun Auto-école**

@component('mail::panel')
Si vous avez des questions, n'hésitez pas à nous contacter à [support@sahnoun.com](mailto:support@sahnoun.com).
@endcomponent
@endcomponent
