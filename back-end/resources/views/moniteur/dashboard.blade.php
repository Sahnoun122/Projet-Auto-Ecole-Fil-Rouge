@extends('layouts.moniteur')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50 min-h-screen">
    
    <header class="bg-[#4D44B5] text-white shadow-lg rounded-2xl mb-8 animate__animated animate__fadeIn">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-center md:text-left tracking-tight">Tableau de Bord Moniteur</h1>
            <p class="mt-2 text-sm text-indigo-100 text-center md:text-left">Consultez vos informations et gérez vos cours.</p>
        </div>
    </header>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInUp">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Derniers Cours de Conduite</h2>
                    {{-- Removed calendar icon link --}}
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($coursConduite as $cours)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $cours->date_heure->isoFormat('dddd D MMMM YYYY [à] HH[h]mm') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Durée: {{ $cours->duree_minutes }} minutes
                                </p>
                                @if($cours->vehicule)
                                <p class="text-xs text-gray-500 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                      </svg>
                                    Véhicule: {{ $cours->vehicule->marque }} {{ $cours->vehicule->modele }} ({{ $cours->vehicule->immatriculation }})
                                </p>
                                @endif
                            </div>
                            <div class="mt-2 sm:mt-0 sm:text-right">
                                <p class="text-sm font-semibold text-gray-700">Candidats:</p>
                                <ul class="text-xs text-gray-600 list-disc list-inside sm:list-none">
                                    @if($cours->candidat)
                                        <li>{{ $cours->candidat->prenom ?? 'Prénom?' }} {{ $cours->candidat->nom ?? 'Nom?' }} (Principal)</li>
                                    @endif
                                    @forelse($cours->candidatsAssignes->where('id', '!=', $cours->candidat_id) as $candidatPivot)
                                        <li>{{ $candidatPivot->prenom ?? 'Prénom?' }} {{ $candidatPivot->nom ?? 'Nom?' }}</li>
                                    @empty
                                        @if(!$cours->candidat)
                                            <li class="text-gray-400 italic">Aucun candidat assigné</li>
                                        @endif
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucun cours de conduite trouvé.
                    </div>
                    @endforelse
                </div>
                {{-- Remove Pagination Links as we are using get() now --}}
                {{-- @if ($coursConduite->hasPages()) --}}
                {{--    <div class="p-4 bg-gray-50 border-t border-gray-100"> --}}
                {{--        {{ $coursConduite->links() }} --}}
                {{--    </div> --}}
                {{-- @endif --}}
            </div>

            
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInUp">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Candidats Assignés (Récents)</h2>
                    
                    <a href="{{ route('moniteur.candidats') }}" class="text-indigo-600 hover:text-indigo-800" title="Voir tous les candidats">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                          </svg>
                    </a>
                </div>
                <div class="divide-y divide-gray-100">
                    
                    @forelse($candidatsAssignes as $candidat)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $candidat->profile_photo_url }}" alt="Photo de {{ $candidat->prenom }} {{ $candidat->nom }}">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    
                                    <p class="text-sm font-medium text-gray-900">{{ $candidat->prenom }} {{ $candidat->nom }}</p>
                                    {{-- <p class="text-xs text-gray-500 mt-1 sm:mt-0">Assigné le: Date</p> --}} {{-- Display assignment date if available --}}
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $candidat->email }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucun candidat assigné pour le moment.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInRight">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-blue-50">
                    <h2 class="text-lg font-semibold text-blue-800">Notifications</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $notifications->count() }}</span>
                </div>
                <div class="divide-y divide-gray-100">
                    
                    @forelse($notifications as $notification)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->data['message'] ?? '...' }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucune nouvelle notification.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush

@push('scripts')

@endpush
@endsection