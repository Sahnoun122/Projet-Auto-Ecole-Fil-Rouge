@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50 min-h-screen">
    
    <header class="bg-[#4D44B5] text-white shadow-lg rounded-2xl mb-8 animate__animated animate__fadeIn">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-center md:text-left tracking-tight">Tableau de Bord Administrateur</h1>
            
            <p class="mt-2 text-sm text-indigo-100 text-center md:text-left">Gérez efficacement vos données en temps réel</p>
        </div>
    </header>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Total Candidats</h3>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ number_format($totalCandidats) }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-semibold">+{{ rand(5, 15) }}%</span>
                    <span class="text-gray-500 text-sm ml-2">vs mois dernier</span>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Moniteurs Actifs</h3>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ number_format($totalMoniteurs) }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-semibold">+{{ rand(3, 10) }}%</span>
                    <span class="text-gray-500 text-sm ml-2">vs mois dernier</span>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Véhicules</h3>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{ number_format($totalVehicles) }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-semibold">+{{ rand(2, 8) }}%</span>
                    <span class="text-gray-500 text-sm ml-2">vs mois dernier</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            

            
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInUp">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Derniers Résultats d'Examens</h2>
                    
                    <a href="{{ route('admin.exams') }}" class="text-indigo-600 hover:text-indigo-800" title="Voir tout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Type</th> 
                                
                                
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Résultat</th> 
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($derniersExamens as $examen)
                                
                                @if(isset($examen->result) && strtolower($examen->result->resultat) !== 'indéfini')
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($examen->candidat)
                                                
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $examen->candidat->profile_photo_url }}" alt="Photo de {{ $examen->candidat->prenom }} {{ $examen->candidat->nom }}">
                                            @else
                                                
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        
                                        <div class="text-sm font-medium text-gray-900">{{ $examen->candidat ? $examen->candidat->prenom . ' ' . $examen->candidat->nom : 'Candidat Inconnu' }}</div>
                                        <div class="text-sm text-gray-500 hidden sm:block">{{ $examen->candidat->email ?? '' }}</div> 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell"> 
                                        {{ ucfirst($examen->type) }}
                                    </td>
                                    
                                    
                                    
                                    
                                    <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell"> 
                                        @php
                                            
                                            $resultat = $examen->result->resultat;
                                            $badgeColor = [
                                                'excellent' => 'bg-green-100 text-green-800',
                                                'reussi' => 'bg-green-100 text-green-800',
                                                'bien' => 'bg-green-100 text-green-800',
                                                'echec' => 'bg-red-100 text-red-800',
                                                'insuffisant' => 'bg-red-100 text-red-800',
                                            ][strtolower($resultat)] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                            {{ ucfirst($resultat) }}
                                        </span>
                                    </td>
                                </tr>
                                @endif
                            @empty
                            <tr>
                                
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucun examen récent trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInUp">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Nouveaux Candidats</h2>
                    
                    <a href="{{ route('admin.candidats') }}" class="text-indigo-600 hover:text-indigo-800" title="Voir tout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($candidats as $candidat)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($candidat->profile_photo_url)
                                    
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $candidat->profile_photo_url }}" alt="Photo de {{ $candidat->prenom }} {{ $candidat->nom }}">
                                @else
                                    
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                                        
                                        {{ $candidat->prenom ? substr($candidat->prenom, 0, 1) : '' }}{{ $candidat->nom ? substr($candidat->nom, 0, 1) : '' }}
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    
                                    <p class="text-sm font-medium text-gray-900">{{ $candidat->prenom }} {{ $candidat->nom }}</p>
                                    <p class="text-xs text-gray-500 mt-1 sm:mt-0">{{ $candidat->created_at ? $candidat->created_at->diffForHumans() : '' }}</p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $candidat->email }}</p>
                                <p class="text-xs text-gray-400 mt-1">Inscrit le: {{ $candidat->created_at ? $candidat->created_at->isoFormat('DD MMM YYYY') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    
                    <div class="p-5 text-center text-gray-500">
                        Aucun nouveau candidat récemment
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInRight">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-red-50">
                    <h2 class="text-lg font-semibold text-red-800">Alertes Paiements en Retard</h2>
                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">{{ $paiementsEnRetard->count() }}</span>
                </div>
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto">
                    @forelse($paiementsEnRetard as $paiement)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10">
                                
                                @if($paiement->candidat)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $paiement->candidat->profile_photo_url }}" alt="Photo de {{ $paiement->candidat->prenom }} {{ $paiement->candidat->nom }}">
                                @else
                                    
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    
                                    <p class="text-sm font-medium text-gray-900">{{ $paiement->candidat ? $paiement->candidat->prenom . ' ' . $paiement->candidat->nom : 'Candidat inconnu' }}</p>
                                    <p class="text-sm text-red-600 font-medium">{{ number_format($paiement->montant_total - $paiement->montant, 2) }} DH</p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Échéance: {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->isoFormat('DD MMM YYYY') : 'N/A' }}</p>
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-red-600 h-1.5 rounded-full" style="width: {{ $paiement->montant_total > 0 ? ($paiement->montant / $paiement->montant_total) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucun paiement en retard
                    </div>
                    @endforelse
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden animate__animated animate__fadeInRight">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-yellow-50">
                    <h2 class="text-lg font-semibold text-yellow-800">Alertes Maintenances à Venir</h2>
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">{{ $maintenancesAVenir->count() }}</span>
                </div>
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto">
                    @forelse($maintenancesAVenir as $vehicule)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $vehicule->marque }} {{ $vehicule->modele }}</p>
                                    <p class="text-xs font-medium {{ $vehicule->prochaine_maintenance && $vehicule->prochaine_maintenance->isToday() ? 'text-red-600' : 'text-yellow-600' }}">
                                        @if($vehicule->prochaine_maintenance)
                                            {{ $vehicule->prochaine_maintenance->isToday() ? 'Aujourd\\\'hui' : $vehicule->prochaine_maintenance->diffForHumans() }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $vehicule->immatriculation }}</p>
                                <p class="text-xs text-gray-400 mt-1">Dernière maintenance: {{ $vehicule->derniere_maintenance ? \Carbon\Carbon::parse($vehicule->derniere_maintenance)->isoFormat('DD MMM YYYY') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucune maintenance prévue dans les 7 prochains jours
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