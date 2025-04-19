@extends('layouts.admin')
@section('content')

            <div class="overflow-x-auto w-full">
                            <header class="bg-[#4D44B5] text-white shadow-md">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                        <h1 class="text-2xl font-bold">Cours de Conduite</h1>
                        <button id="newCourseBtn"
                            class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                            <i class="fas fa-plus mr-2"></i> Nouveau Cours
                        </button>
                    </div>
                </header>
            
            
                <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
            
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Liste des Cours Programmes</h2>
                        </div>
            
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Véhicule</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moniteur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Véhicule</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidats</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($cours as $cour)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $cour->date_heure}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $cour->duree_minutes }} minutes
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($cour->moniteur)
                                                {{ $cour->moniteur->nom }} {{ $cour->moniteur->prenom }}
                                            @else
                                                <span class="text-red-500">Non assigné</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($cour->vehicule)
                                                {{ $cour->vehicule->marque }} ({{ $cour->vehicule->immatriculation }})
                                            @else
                                                <span class="text-red-500">Non assigné</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @if($cour->candidat)
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                                        {{ $cour->candidat->nom }} {{ $cour->candidat->prenom }} (Principal)
                                                    </span>
                                                @else
                                                    <span class="text-red-500 text-xs">Aucun candidat principal</span>
                                                @endif
                                        
                                                @foreach($cour->candidats as $candidat)
                                                    @if(!$cour->candidat || $candidat->id != $cour->candidat_id)
                                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">
                                                            {{ $candidat->nom }} {{ $candidat->prenom }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($cour->statut === 'planifie') bg-blue-100 text-blue-800
                                                @elseif($cour->statut === 'termine') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($cour->statut) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="openEditModal(
                                                '{{ $cour->id }}',
                                                '{{ $cour->date_heure}}',
                                                '{{ $cour->duree_minutes }}',
                                                '{{ $cour->moniteur_id }}',
                                                '{{ $cour->vehicule_id }}',
                                                '{{ $cour->candidat_id }}',
                                                `{{ json_encode($cour->candidats->pluck('id')->toArray()) }}`,
                                                '{{ $cour->statut }}'
                                            )" class="text-[#4D44B5] hover:text-[#3a32a1] mr-3">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.conduite.destroy', $cour->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"
                                                    class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <button onclick="openPresenceModal('{{ $cour->id }}')" 
                                                class="text-purple-600 hover:text-purple-800 ml-2">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
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
            
                <!-- Cours Modal (Create/Edit) -->
                <div id="courseModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white w-full max-w-2xl p-6 rounded-lg">
                        <h2 id="modalCourseTitle" class="text-lg font-bold mb-4">Nouveau Cours de Conduite</h2>
                        <form id="courseForm" method="POST">
                            @csrf
                            <input type="hidden" id="courseId" name="id">
                            <input type="hidden" id="_method" name="_method" value="POST">
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label for="courseDateHeure" class="block text-sm font-medium text-gray-700 mb-1">Date/Heure *</label>
                                    <input type="datetime-local" id="courseDateHeure" name="date_heure"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="courseDuree" class="block text-sm font-medium text-gray-700 mb-1">Durée (minutes) *</label>
                                    <input type="number" id="courseDuree" name="duree_minutes" min="30" max="240"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
                            </div>
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label for="courseMoniteur" class="block text-sm font-medium text-gray-700 mb-1">Moniteur *</label>
                                    <select id="courseMoniteur" name="moniteur_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                        <option value="">Sélectionner un moniteur</option>
                                        @foreach($moniteurs as $moniteur)
                                            <option value="{{ $moniteur->id }}">{{ $cour->moniteur->nom }} {{ $cour->moniteur->prenom }}</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="mb-4">
                                    <label for="courseVehicule" class="block text-sm font-medium text-gray-700 mb-1">Véhicule *</label>
                                    <select id="courseVehicule" name="vehicule_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                        <option value="">Sélectionner un véhicule</option>
                                        @foreach($vehicules as $vehicule)
                                            <option value="{{ $vehicule->id }}">{{ $vehicule->marque }} ({{ $vehicule->immatriculation }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
            
                            <div class="mb-4">
                                <label for="courseCandidatPrincipal" class="block text-sm font-medium text-gray-700 mb-1">Candidat Principal *</label>
                                <select id="courseCandidatPrincipal" name="candidat_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    <option value="">Sélectionner un candidat</option>
                                    @foreach($candidats as $candidat)
                                        <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="mb-4">
                                <label for="courseCandidatPrincipal" class="block text-sm font-medium text-gray-700 mb-1">Candidat Principal *</label>
                                <select id="courseCandidatPrincipal" name="candidat_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    <option value="">Sélectionner un candidat</option>
                                    @foreach($candidats as $candidat)
                                        <option value="{{ $candidat->id }}">{{ $cour->candidat->nom }} {{ $cour->candidat->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="courseCandidatsSupplementaires" class="block text-sm font-medium text-gray-700 mb-1">Candidats Supplémentaires</label>
                                <select id="courseCandidatsSupplementaires" name="candidat_ids[]" multiple
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                    @foreach($candidats as $candidat)
                                        <option value="{{ $candidat->id }}">{{ $cour->candidat->nom }} {{ $cour->candidat->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="mb-4">
                                <label for="courseStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                                <select id="courseStatut" name="statut" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    <option value="planifie">Planifié</option>
                                    <option value="termine">Terminé</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>
                            
                            <div class="flex justify-end space-x-2">
                                <button type="button" id="cancelCourseBtn"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                    Annuler
                                </button>
                                <button type="submit" id="submitCourseBtn"
                                    class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            
                <!-- Presence Modal -->
                <div id="presenceModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white w-full max-w-md p-6 rounded-lg">
                        <h2 class="text-lg font-bold mb-4">Marquer les Présences</h2>
                        <div id="presenceContent">
                            <!-- Content will be loaded via AJAX -->
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" id="closePresenceBtn"
                                class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            
            <script>
            $(document).ready(function() {
                // Initialize multi-select
                $('#courseCandidatsSupplementaires').select2({
                    placeholder: "Sélectionner des candidats",
                    width: '100%'
                });
            
                // New course button
                $('#newCourseBtn').click(function() {
                    $('#modalCourseTitle').text('Nouveau Cours de Conduite');
                    $('#courseForm').attr('action', "{{ route('admin.conduite.store') }}");
                    $('#_method').val('POST');
                    $('#courseId').val('');
                    $('#courseForm')[0].reset();
                    $('#courseDateHeure').val(new Date().toISOString().slice(0, 16));
                    $('#courseModal').removeClass('hidden');
                });
            
                // Edit course modal
                window.openEditModal = function(id, dateHeure, duree, moniteurId, vehiculeId, candidatId, candidatIds, statut) {
                    $('#modalCourseTitle').text('Modifier Cours de Conduite');
                    $('#courseForm').attr('action', "/admin/conduite/" + id);
                    $('#_method').val('PUT');
                    $('#courseId').val(id);
                    $('#courseDateHeure').val(dateHeure);
                    $('#courseDuree').val(duree);
                    $('#courseMoniteur').val(moniteurId);
                    $('#courseVehicule').val(vehiculeId);
                    $('#courseCandidatPrincipal').val(candidatId); // Champ unique pour le candidat principal
                    $('#courseStatut').val(statut);
                    
                    try {
                        const ids = Array.isArray(candidatIds) ? candidatIds : JSON.parse(candidatIds.replace(/&quot;/g, '"'));
                        $('#courseCandidatsSupplementaires').val(ids).trigger('change');
                    } catch (e) {
                        console.error('Error parsing candidat_ids:', e);
                    }
                    
                    $('#courseModal').removeClass('hidden');
                };
            
                // Close modals
                $('#cancelCourseBtn, #closePresenceBtn').click(function() {
                    $('#courseModal, #presenceModal').addClass('hidden');
                });
            
                // Open presence modal
                window.openPresenceModal = function(courseId) {
                    $.ajax({
                        url: "{{ route('admin.conduite.presence', '') }}/" + courseId,
                        type: 'GET',
                        success: function(response) {
                            $('#presenceContent').html(response);
                            $('#presenceModal').removeClass('hidden');
                        },
                        error: function(xhr) {
                            alert('Erreur lors du chargement des présences');
                        }
                    });
                };
            
                // Handle presence form submission
                $(document).on('submit', '#presenceForm', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const url = form.attr('action');
                    
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if(response.success) {
                                alert('Présences enregistrées avec succès');
                                $('#presenceModal').addClass('hidden');
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            alert('Erreur lors de l\'enregistrement des présences');
                        }
                    });
                });
            });
            </script>
            <style>
            .select2-container--default .select2-selection--multiple {
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                padding: 0.25rem;
                min-height: 42px;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #4D44B5;
                border: none;
                border-radius: 0.25rem;
                color: white;
                padding: 0 0.5rem;
            }
            </style>
              @endsection


