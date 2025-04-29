@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Auto-école Sahnoun
        @endcomponent
    @endslot

    # Nouveau cours de conduite programmé

    Bonjour {{ $user->prenom }},

    Un nouveau cours de conduite a été programmé pour vous.

    **Détails du cours:**
    - Date et heure: {{ $cours->date_heure->format('d/m/Y H:i') }}
    - Durée: {{ $cours->duree_minutes }} minutes
    - Moniteur: {{ $cours->moniteur->nom_complet }}
    - Véhicule: {{ $cours->vehicule->marque }} ({{ $cours->vehicule->immatriculation }})

    @component('mail::button', ['url' => route('candidat.conduite'), 'color' => 'primary'])
        Voir mes cours
    @endcomponent

    Cordialement,<br>
    L'équipe de l'auto-école Sahnoun

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} Auto-école Sahnoun. Tous droits réservés.
        @endcomponent
    @endslot
@endcomponent