@extends('layouts.moniteur')

@section('content')
<div class="w-full">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-xl sm:text-2xl font-bold">Mes Cours de Conduite</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden mb-8">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Cours Planifiés</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Date/Heure</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Durée</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs hidden sm:table-cell">Véhicule</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Candidats</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($cours as $cour)
                        <tr data-course-id="{{ $cour->id }}">
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap">
                                {{ $cour->date_heure}}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap">
                                {{ $cour->duree_minutes }} min
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                @if($cour->vehicule)
                                    {{ $cour->vehicule->marque }} ({{ $cour->vehicule->immatriculation }})
                                @else
                                    <span class="text-red-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($cour->candidat)
                                        <span class="text-gray-800 px-1 py-0.5 sm:px-2 sm:py-1 rounded text-xs">
                                            {{ $cour->candidat->nom }} {{ $cour->candidat->prenom }}
                                        </span>
                                    @endif
                            
                                    @foreach($cour->candidats as $candidat)
                                        @if(!$cour->candidat || $candidat->id != $cour->candidat_id)
                                            <span class="text-gray-800 px-1 py-0.5 sm:px-2 sm:py-1 rounded text-xs">
                                                {{ $candidat->nom }} {{ $candidat->prenom }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <button class="show-presence-btn text-[#4D44B5] hover:text-[#3a32a1] px-2 py-1 bg-[#4D44B5]/10 rounded text-xs sm:text-sm"
                                    data-course-id="{{ $cour->id }}"
                                    data-course-date="{{ $cour->date_heure }}">
                                    <i class="fas fa-user-check mr-1"></i>Présence
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Aucun cours planifié
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

<!-- Presence Modal Template -->
<div id="presenceModalTemplate" style="display: none;">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-[#4D44B5] text-white">
            <h2 class="text-lg font-bold">Gestion des Présences</h2>
            <p class="course-date text-sm opacity-90 mt-1"></p>
        </div>

        <form class="presence-form" method="POST" action="">
            @csrf
            <div class="p-4 sm:p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <!-- Candidat Principal -->
                <div class="border rounded-lg p-4 bg-gray-50">
                    <h3 class="font-medium text-lg mb-3">Candidat Principal</h3>
                    <div class="candidate-presence flex items-center justify-between mb-3">
                        <span class="candidate-name"></span>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="present[]" value="" 
                                class="rounded border-gray-300 text-[#4D44B5] focus:ring-[#4D44B5]">
                            <span class="ml-2">Présent</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes[]" rows="2" 
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
                    </div>
                </div>

                <!-- Autres Candidats -->
                <div class="other-candidates-container border rounded-lg p-4 bg-gray-50">
                    <h3 class="font-medium text-lg mb-3">Autres Candidats</h3>
                    <div class="other-candidates space-y-4">
                        <!-- Dynamically filled -->
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" class="cancel-presence-btn px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Store all courses data in a variable
    const coursesData = {
        @foreach($cours as $cour)
        "{{ $cour->id }}": {
            id: {{ $cour->id }},
            date_heure: "{{ $cour->date_heure }}",
            candidat: @json($cour->candidat),
            candidats: @json($cour->candidats),
            presenceData: @json($cour->candidats->mapWithKeys(function ($candidat) {
                return [
                    $candidat->id => [
                        'present' => $candidat->pivot->present ?? false,
                        'notes' => $candidat->pivot->notes ?? ''
                    ]
                ];
            }))
        },
        @endforeach
    };

    // Show presence modal
    $(document).on('click', '.show-presence-btn', function() {
        const courseId = $(this).data('course-id');
        const course = coursesData[courseId];
        
        // Clone the modal template
        const $modal = $('<div>').addClass('fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4')
            .append($('#presenceModalTemplate').html());
        
        // Set modal content
        $modal.find('.course-date').text('Cours du ' + course.date_heure);
        $modal.find('.presence-form').attr('action', '/moniteur/conduite/' + courseId + '/presences');
        
        if (course.candidat) {
            const principalPresent = course.presenceData[course.candidat.id]?.present || false;
            const principalNotes = course.presenceData[course.candidat.id]?.notes || '';
            
            $modal.find('.candidate-name').text(course.candidat.nom + ' ' + course.candidat.prenom);
            $modal.find('.candidate-presence input').val(course.candidat.id);
            $modal.find('.candidate-presence input').prop('checked', principalPresent);
            $modal.find('.candidate-presence textarea').val(principalNotes);
        } else {
            $modal.find('.candidate-presence').closest('div').hide();
        }
        
        // Set other candidates
        const $otherCandidates = $modal.find('.other-candidates');
        $otherCandidates.empty();
        
        course.candidats.forEach(candidat => {
            if (!course.candidat || candidat.id !== course.candidat.id) {
                const present = course.presenceData[candidat.id]?.present || false;
                const notes = course.presenceData[candidat.id]?.notes || '';
                
                const $candidateDiv = $(`
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span>${candidat.nom} ${candidat.prenom}</span>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="present[]" value="${candidat.id}" 
                                    class="rounded border-gray-300 text-[#4D44B5] focus:ring-[#4D44B5]"
                                    ${present ? 'checked' : ''}>
                                <span class="ml-2">Présent</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes[]" rows="2" 
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">${notes}</textarea>
                        </div>
                    </div>
                `);
                
                $otherCandidates.append($candidateDiv);
            }
        });
        
        // Hide other candidates section if no other candidates
        if (course.candidats.length <= 1 || (course.candidats.length === 1 && course.candidat)) {
            $modal.find('.other-candidates-container').hide();
        }
        
        // Add close handler
        $modal.on('click', '.cancel-presence-btn', function() {
            $modal.remove();
            $('body').removeClass('overflow-hidden');
        });
        
        // Close when clicking outside
        $modal.on('click', function(e) {
            if (e.target === this) {
                $modal.remove();
                $('body').removeClass('overflow-hidden');
            }
        });
        
        // Add to DOM
        $('body').addClass('overflow-hidden').append($modal);
    });
});
</script>

<style>
/* Responsive table */
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
    
    /* Add data labels for mobile */
    td:nth-of-type(1):before { content: "Date/Heure"; }
    td:nth-of-type(2):before { content: "Durée"; }
    td:nth-of-type(3):before { content: "Véhicule"; }
    td:nth-of-type(4):before { content: "Candidats"; }
    td:nth-of-type(5):before { content: "Actions"; }
}

/* Custom scrollbar for modal */
.presence-form > div::-webkit-scrollbar {
    width: 6px;
}

.presence-form > div::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.presence-form > div::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.presence-form > div::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>
@endsection