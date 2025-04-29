@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Auto-école Sahnoun
        @endcomponent
    @endslot

    # Nouveau cours de conduite assigné

    Bonjour {{ $user->prenom }},

    Un nouveau cours de conduite vous a été assigné.

    **Détails du cours:**
    - Date et heure: {{ $cours->date_heure->format('d/m/Y H:i') }}
    - Durée: {{ $cours->duree_minutes }} minutes
    - Candidat principal: {{ $cours->candidat->nom_complet }}
    @if($cours->candidats->count() > 1)
    - Autres candidats: {{ $cours->candidats->except($cours->candidat->id)->implode('nom_complet', ', ') }}
    @endif
    - Véhicule: {{ $cours->vehicule->marque }} ({{ $cours->vehicule->immatriculation }})

    @component('mail::button', ['url' => route('moniteur.conduite'), 'color' => 'primary'])
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