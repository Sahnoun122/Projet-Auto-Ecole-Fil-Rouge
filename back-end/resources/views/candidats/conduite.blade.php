@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <div class="min-h-screen">
        <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-bold">Mes Cours de Conduite</h1>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Planning des Cours</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-1 sm:px-3 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Date/Heure</th>
                                <th class="px-2 py-1 sm:px-3 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Durée</th>
                                <th class="px-2 py-1 sm:px-3 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell text-xs">Moniteur</th>
                                <th class="px-2 py-1 sm:px-3 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell text-xs">Véhicule</th>
                                <th class="px-2 py-1 sm:px-3 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Statut</th>
                                <th class="px-2 py-1 sm:px-3 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($cours as $cour)
                            <tr>
                                <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap" data-label="Date/Heure">
                                    {{ $cour->date_heure }}
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap" data-label="Durée">
                                    {{ $cour->duree_minutes }} min
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden sm:table-cell" data-label="Moniteur">
                                    {{ $cour->moniteur->nom }} {{ $cour->moniteur->prenom }}
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden md:table-cell" data-label="Véhicule">
                                    @if($cour->vehicule)
                                        {{ $cour->vehicule->marque }} ({{ $cour->vehicule->immatriculation }})
                                    @else
                                        <span class="text-red-500">Non assigné</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap" data-label="Statut">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($cour->statut === 'planifie') bg-blue-100 text-blue-800
                                        @elseif($cour->statut === 'termine') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($cour->statut) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap text-sm font-medium" data-label="Actions">
                                    <button onclick="showCourseDetails({{ $cour->id }})" 
                                        class="text-[#4D44B5] hover:text-[#3a32a1] px-2 py-1 bg-[#4D44B5]/10 rounded">
                                        <i class="fas fa-eye mr-1"></i>Détails
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Aucun cours programmé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-4 py-2">
                        {{ $cours->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div id="detailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-[#4D44B5] text-white">
            <h2 class="text-lg font-bold">Détails du Cours</h2>
            <button onclick="closeDetailsModal()" class="absolute top-3 right-3 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-4 sm:p-6">
            <div id="modalLoading" class="flex justify-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#4D44B5]"></div>
            </div>

            <div id="modalContent" class="hidden space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-medium text-gray-700">Date/Heure</h3>
                        <p id="modalDate" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-700">Durée</h3>
                        <p id="modalDuree" class="text-gray-900"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-medium text-gray-700">Moniteur</h3>
                        <p id="modalMoniteur" class="text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-700">Véhicule</h3>
                        <p id="modalVehicule" class="text-gray-900"></p>
                    </div>
                </div>

                <div>
                    <h3 class="font-medium text-gray-700">Statut</h3>
                    <p id="modalStatut" class="text-gray-900"></p>
                </div>

                <div id="presenceSection">
                    <h3 class="font-medium text-gray-700">Ma présence</h3>
                    <div id="modalPresence" class="mt-1"></div>
                </div>

                <div id="notesSection" class="hidden">
                    <h3 class="font-medium text-gray-700">Notes du Moniteur</h3>
                    <div id="modalNotes" class="bg-gray-50 p-3 rounded-lg mt-1"></div>
                </div>

                <div id="otherCandidatesSection" class="hidden">
                    <h3 class="font-medium text-gray-700">Autres Candidats</h3>
                    <div id="modalCandidates" class="space-y-2 mt-2"></div>
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeDetailsModal()" 
                class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                Fermer
            </button>
        </div>
    </div>
</div>

<script>
function showCourseDetails(courseId) {
    document.getElementById('detailsModal').classList.remove('hidden');
    document.getElementById('modalLoading').classList.remove('hidden');
    document.getElementById('modalContent').classList.add('hidden');
    document.body.classList.add('overflow-hidden');
    
    fetch(`/candidats/conduite/${courseId}/show`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
           
            return response.json();
        })
        .then(result => {
            const data = result.data
            document.getElementById('modalDate').textContent = 
                new Date(data.date_heure).toLocaleString('fr-FR');
            document.getElementById('modalDuree').textContent = 
                `${data.duree_minutes} minutes`;
            document.getElementById('modalMoniteur').textContent = 
                `${data.moniteur.nom} ${data.moniteur.prenom}`;
            document.getElementById('modalVehicule').textContent = 
                data.vehicule ? `${data.vehicule.marque} (${data.vehicule.immatriculation})` : 'Non assigné';
            document.getElementById('modalStatut').textContent = 
                data.statut.charAt(0).toUpperCase() + data.statut.slice(1);

            const presenceDiv = document.getElementById('modalPresence');
            if (data.presences && data.presences.length > 0) {
                const presence = data.presences[0];
                if (presence.present) {
                    presenceDiv.innerHTML = `
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            <i class="fas fa-check mr-1"></i>Présent
                        </span>
                    `;
                } else {
                    presenceDiv.innerHTML = `
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                            <i class="fas fa-times mr-1"></i>Absent
                        </span>
                    `;
                }
            } else {
                presenceDiv.innerHTML = `
                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                        <i class="fas fa-question mr-1"></i>Non enregistré
                    </span>
                `;
            }

            if (data.presences && data.presences.length > 0 && data.presences[0].notes) {
                document.getElementById('notesSection').classList.remove('hidden');
                document.getElementById('modalNotes').textContent = data.presences[0].notes;
            } else {
                document.getElementById('notesSection').classList.add('hidden');
            }

            // Afficher les autres candidats si disponible
            if (data.candidats && data.candidats.length > 1) {
                document.getElementById('otherCandidatesSection').classList.remove('hidden');
                const candidatesContainer = document.getElementById('modalCandidates');
                candidatesContainer.innerHTML = '';
                
                data.candidats.forEach(candidat => {
                    if (candidat.id !== {{ Auth::id() }}) {
                        const div = document.createElement('div');
                        div.className = 'bg-gray-50 p-2 rounded';
                        div.textContent = `${candidat.nom} ${candidat.prenom}`;
                        candidatesContainer.appendChild(div);
                    }
                });
            } else {
                document.getElementById('otherCandidatesSection').classList.add('hidden');
            }

            document.getElementById('modalLoading').classList.add('hidden');
            document.getElementById('modalContent').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('modalLoading').innerHTML = 
                '<p class="text-red-500">Erreur lors du chargement des détails</p>';
        });
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

document.getElementById('detailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailsModal();
    }
});
</script>

<style>
@media (max-width: 640px) {
    table {
        display: block;
        width: 100%;
    }
    
    thead {
        display: none;
    }
    
    tbody {
        display: block;
    }
    
    tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
    }
    
    td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    td:last-child {
        border-bottom: none;
    }
    
    td::before {
        content: attr(data-label);
        font-weight: 600;
        margin-right: 1rem;
    }
}
</style>
@endsection