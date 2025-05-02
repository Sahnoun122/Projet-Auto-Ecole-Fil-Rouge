@extends('layouts.moniteur')

@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-xl md:text-2xl font-bold">Mes Examens Assignés</h1>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Liste des Examens</h2>
                <div class="relative w-full md:w-auto">
                    <input type="text" id="examSearch" placeholder="Rechercher..." 
                        class="pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none w-full">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 hidden sm:table-header-group">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($assignedExams as $exam) 
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Type</div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($exam->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Date</div>
                                <span>{{ $exam->date_exam->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Lieu</div>
                                <span>{{ $exam->lieu }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Candidat</div>
                                @if($exam->candidat)
                                    <div class="font-medium text-[#4D44B5]">{{ $exam->candidat->prenom }} {{ $exam->candidat->nom }}</div>
                                @else
                                    <span class="text-gray-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Statut</div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->statut === 'planifie' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($exam->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : 
                                       ($exam->statut === 'termine' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $exam->statut)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="sm:hidden text-xs font-medium text-gray-500 uppercase mb-1">Actions</div>
                                <div class="flex items-center space-x-3">
                                    <button onclick="openDetailsModal(
                                        '{{ $exam->id }}',
                                        '{{ $exam->type }}',
                                        '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                        '{{ $exam->lieu }}',
                                        '{{ $exam->places_max }}',
                                        '{{ $exam->statut }}',
                                        '{{ $exam->candidat ? $exam->candidat->prenom . ' ' . $exam->candidat->nom : 'Non assigné' }}',
                                        '{{ $exam->instructions }}',
                                        '{{ $exam->result->score ?? '' }}', 
                                        '{{ $exam->result->resultat ?? '' }}',
                                        '{{ $exam->result->feedbacks ?? '' }}',
                                        '{{ $exam->result ? (int)$exam->result->present : '' }}'
                                    )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucun examen ne vous est assigné pour le moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $assignedExams->appends(request()->query())->links() }} 
                </div>
            </div>
        </div>
    </main>

    <div id="detailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="modalDetailsTitle" class="text-xl font-bold"></h2>
                <button id="closeDetailsBtn" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Informations de l'examen</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Type</p>
                                <p id="detailType" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Date</p>
                                <p id="detailDate" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Lieu</p>
                                <p id="detailLieu" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Places max</p>
                                <p id="detailPlaces" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Statut</p>
                                <p id="detailStatut" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Candidat</p>
                                <p id="detailCandidat" class="text-gray-800 font-medium"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div id="detailResults" class="bg-gray-50 p-5 rounded-lg">
                        <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Résultats</h3>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Instructions</h3>
                    <p id="detailInstructions" class="text-gray-700 whitespace-pre-line"></p>
                </div>
                
                <div id="detailFeedbacks" class="bg-gray-50 p-5 rounded-lg">
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" id="closeDetailsBtnBottom"
                    class="px-5 py-2.5 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>

 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    window.openDetailsModal = function(id, type, date, lieu, places, statut, candidat, instructions, score, resultat, feedbacks, present) {
        $('#modalDetailsTitle').text('Détails de l\'Examen #' + id);
        $('#detailType').text(type.charAt(0).toUpperCase() + type.slice(1));
        $('#detailDate').text(date);
        $('#detailLieu').text(lieu);
        $('#detailPlaces').text(places);
        $('#detailStatut').text(statut.charAt(0).toUpperCase() + statut.slice(1).replace('_', ' '));
        $('#detailCandidat').text(candidat);
        $('#detailInstructions').text(instructions || 'Aucune instruction spécifiée');
        
        if(score !== '' && resultat !== '' && present !== '') {
            let resultatClass = '';
            let resultatText = resultat.replace('_', ' ').charAt(0).toUpperCase() + resultat.replace('_', ' ').slice(1);
            
            switch(resultat) {
                case 'reussi':
                case 'excellent':
                    resultatClass = 'bg-green-100 text-green-800';
                    break;
                case 'bien':
                    resultatClass = 'bg-blue-100 text-blue-800';
                    break;
                case 'moyen':
                    resultatClass = 'bg-yellow-100 text-yellow-800';
                    break;
                case 'echoue':
                    resultatClass = 'bg-red-100 text-red-800';
                    break;
                default:
                    resultatClass = 'bg-gray-100 text-gray-800';
            }
            
            $('#detailResults').html(`
                <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Résultats</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Présence</p>
                        <p class="font-medium ${present === '1' ? 'text-green-600' : 'text-red-600'}">${present === '1' ? '<i class="fas fa-check-circle mr-1"></i>Présent' : '<i class="fas fa-times-circle mr-1"></i>Absent'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Score</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                            <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: ${score}%"></div>
                        </div>
                        <p class="text-gray-800 font-medium mt-1">${score}/100</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Résultat</p>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full ${resultatClass}">
                            ${resultatText}
                        </span>
                    </div>
                </div>
            `);
            
            if(feedbacks && feedbacks.trim() !== '') {
                $('#detailFeedbacks').html(`
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                        <p class="text-gray-700 whitespace-pre-line">${feedbacks}</p>
                    </div>
                `).removeClass('hidden'); 
            } else {
                $('#detailFeedbacks').html(`
                    <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                    <p class="text-gray-500 italic">Aucun feedback disponible</p>
                `).removeClass('hidden'); 
            }
            $('#detailResults').removeClass('hidden'); 

        } else {
            
            $('#detailResults').html(`
                <h3 class="font-semibold text-lg text-[#4D44B5] mb-4">Résultats</h3>
                <p class="text-gray-500 italic">Aucun résultat enregistré pour cet examen.</p>
            `).removeClass('hidden'); 
            $('#detailFeedbacks').html(`
                 <h3 class="font-semibold text-lg text-[#4D44B5] mb-3">Feedback</h3>
                 <p class="text-gray-500 italic">Aucun feedback disponible.</p>
            `).removeClass('hidden');
        }
        
        $('#detailsModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    };

    $('#closeDetailsBtn, #closeDetailsBtnBottom').click(function() {
        $('#detailsModal').addClass('hidden'); 
        $('body').removeClass('overflow-hidden');
    });

    $('#examSearch').on('input', function() {
        let searchText = $(this).val().toLowerCase();
        $('tbody tr').each(function() {
            let rowText = $(this).text().toLowerCase();
            if ($(this).find('td[colspan]').length > 0) {
                $(this).toggle(searchText === ''); 
            } else {
                $(this).toggle(rowText.indexOf(searchText) > -1);
            }
        });
        if ($('tbody tr:visible').length === 0 && $('tbody tr').length > 1) { 
        }
    });
});
</script>

<style>
@media (max-width: 640px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }
    
    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    
    tr {
        margin-bottom: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    
    td {
        position: relative;
        padding: 12px 15px;
        padding-left: 15px; 
        border-bottom: 1px solid #e2e8f0;
    }

    td:before {
        content: attr(data-label);
        position: absolute;
        left: 6px;
        width: 45%; 
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.75rem; 
        color: #6b7280; 
        display: none; 
    }
    
    .sm\:hidden { display: block; } 
    td > span, td > div:not(.sm\:hidden) { padding-left: 50%; display: block; } 
    td > .flex { padding-left: 0; } 


    td:last-child {
        border-bottom: none;
    }
}
</style>
@endsection
