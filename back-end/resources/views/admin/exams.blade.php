@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gestion des Examens</h1>
            <button onclick="openModal()" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Nouvel Examen
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any()))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Examens</h2>
                <form method="GET" action="{{ route('admin.exams') }}" class="relative">
                    <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}" 
                        class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
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
                        @foreach($exams as $exam)
                        <tr data-exam-id="{{ $exam->id }}" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($exam->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $exam->date_exam->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $exam->lieu }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"> admin.resultats.show
                                @if($exam->candidat)
                                <a href=""> {{ $exam->candidat->prenom }} {{ $exam->candidat->nom }}
                                </a>
                                @else
                                    <span class="text-gray-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $exam->statut === 'planifie' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($exam->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : 
                                       ($exam->statut === 'termine' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $exam->statut)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="openModal('{{ $exam->id }}')"
                                        class="text-blue-600 hover:text-blue-900 action-btn" 
                                        title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 action-btn" 
                                            title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $exams->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

    <!-- Exam Modal (Create/Edit) -->
    <div id="examModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-lg shadow-xl overflow-hidden">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Nouvel Examen</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="examForm" method="POST" class="needs-validation" novalidate>
                @csrf
                <div id="method-field"></div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="examType" class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                        <select id="examType" name="type" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="theorique">Théorique</option>
                            <option value="pratique">Pratique</option>
                        </select>
                        <div class="invalid-feedback text-red-500 text-sm mt-1">
                            Veuillez sélectionner un type d'examen.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="examDate" class="block text-sm font-medium text-gray-700 mb-1">Date et heure *</label>
                        <input type="datetime-local" id="examDate" name="date_exam" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required
                            min="{{ now()->format('Y-m-d\TH:i') }}">
                        <div class="invalid-feedback text-red-500 text-sm mt-1">
                            Veuillez sélectionner une date et heure valide (future).
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="examLieu" class="block text-sm font-medium text-gray-700 mb-1">Lieu *</label>
                        <input type="text" id="examLieu" name="lieu" maxlength="100"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required
                            pattern="^[a-zA-Z0-9\s\-.,'àâäéèêëîïôöùûüçÀÂÄÉÈÊËÎÏÔÖÙÛÜÇ]{3,100}$">
                        <div class="invalid-feedback text-red-500 text-sm mt-1">
                            Le lieu doit contenir entre 3 et 100 caractères (lettres, chiffres, espaces et -.,').
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="examPlaces" class="block text-sm font-medium text-gray-700 mb-1">Places max *</label>
                        <input type="number" id="examPlaces" name="places_max" min="1" max="50"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required
                            pattern="[1-9][0-9]*">
                        <div class="invalid-feedback text-red-500 text-sm mt-1">
                            Le nombre de places doit être entre 1 et 50.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="examStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                        <select id="examStatut" name="statut" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <option value="planifie">Planifié</option>
                            <option value="en_cours">En cours</option>
                            <option value="termine">Terminé</option>
                            <option value="annule">Annulé</option>
                        </select>
                        <div class="invalid-feedback text-red-500 text-sm mt-1">
                            Veuillez sélectionner un statut.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="examCandidat" class="block text-sm font-medium text-gray-700 mb-1">Candidat</label>
                        <select id="examCandidat" name="candidat_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                            <option value="">Non assigné</option>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}">
                                    {{ $candidat->prenom }} {{ $candidat->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4 md:col-span-2">
                        <label for="examInstructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                        <textarea id="examInstructions" name="instructions" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"
                            maxlength="500"></textarea>
                        <div class="text-sm text-gray-500 mt-1">
                            <span id="instructionsCounter">0</span>/500 caractères
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compteur de caractères pour les instructions
    const instructionsTextarea = document.getElementById('examInstructions');
    const instructionsCounter = document.getElementById('instructionsCounter');
    
    if (instructionsTextarea && instructionsCounter) {
        instructionsTextarea.addEventListener('input', function() {
            instructionsCounter.textContent = this.value.length;
        });
    }
    
    // Initialisation du flatpickr pour le datetime-local
    const examDateInput = document.getElementById('examDate');
    if (examDateInput) {
        flatpickr(examDateInput, {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            time_24hr: true,
            locale: "fr"
        });
    }
    
    // Si des erreurs de validation, on rouvre la modal
    @if($errors->any())
        const examId = {{ old('id') ?? 'null' }};
        openModal(examId);
        
        // Pré-remplir avec les anciennes valeurs en cas d'erreur
        @if(old('type'))
            document.getElementById('examType').value = '{{ old('type') }}';
        @endif
        @if(old('date_exam'))
            document.getElementById('examDate').value = '{{ old('date_exam') }}';
        @endif
        @if(old('lieu'))
            document.getElementById('examLieu').value = '{{ old('lieu') }}';
        @endif
        @if(old('places_max'))
            document.getElementById('examPlaces').value = '{{ old('places_max') }}';
        @endif
        @if(old('statut'))
            document.getElementById('examStatut').value = '{{ old('statut') }}';
        @endif
        @if(old('candidat_id'))
            document.getElementById('examCandidat').value = '{{ old('candidat_id') }}';
        @endif
        @if(old('instructions'))
            document.getElementById('examInstructions').value = '{{ old('instructions') }}';
            document.getElementById('instructionsCounter').textContent = '{{ old('instructions') }}'.length;
        @endif
    @endif
});

// Gestion de la modal
function openModal(examId = null) {
    const modal = document.getElementById('examModal');
    const form = document.getElementById('examForm');
    const methodField = document.getElementById('method-field');
    const modalTitle = document.getElementById('modalTitle');
    
    if (examId) {
        // Mode édition - Récupérer les données via AJAX
        fetch(`/admin/exams/${examId}/edit`)
            .then(response => response.json())
            .then(data => {
                modalTitle.textContent = 'Modifier Examen';
                form.action = `/admin/exams/${examId}`;
                methodField.innerHTML = '@method("PUT")';
                
                // Remplir les champs avec les données de l'examen
                document.getElementById('examType').value = data.type;
                document.getElementById('examDate').value = data.date_exam;
                document.getElementById('examLieu').value = data.lieu;
                document.getElementById('examPlaces').value = data.places_max;
                document.getElementById('examStatut').value = data.statut;
                document.getElementById('examCandidat').value = data.candidat_id || '';
                document.getElementById('examInstructions').value = data.instructions || '';
                
                // Mettre à jour le compteur d'instructions
                document.getElementById('instructionsCounter').textContent = data.instructions ? data.instructions.length : 0;
                
                // Afficher la modal
                modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors du chargement des données de l\'examen');
            });
    } else {
        // Mode création
        modalTitle.textContent = 'Nouvel Examen';
        form.action = '{{ route("admin.exams.store") }}';
        methodField.innerHTML = '';
        
        // Réinitialiser le formulaire
        form.reset();
        document.getElementById('instructionsCounter').textContent = '0';
        
        // Afficher la modal
        modal.classList.remove('hidden');
    }
}

function closeModal() {
    document.getElementById('examModal').classList.add('hidden');
}

// Validation côté client
(function() {
    'use strict';
    
    // Sélectionnez tous les formulaires avec la classe needs-validation
    const forms = document.querySelectorAll('.needs-validation');
    
    // Boucle sur chaque formulaire pour empêcher la soumission
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Afficher les messages d'erreur pour tous les champs invalides
                const invalidFields = form.querySelectorAll(':invalid');
                invalidFields.forEach(field => {
                    field.nextElementSibling.style.display = 'block';
                });
            }
            
            form.classList.add('was-validated');
        }, false);
    });
    
    // Validation en temps réel pour chaque champ
    const fields = document.querySelectorAll('#examForm [required], #examForm [pattern]');
    fields.forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            this.nextElementSibling.style.display = 'none';
            
            if (this.checkValidity()) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
                this.nextElementSibling.style.display = 'block';
            }
        });
    });
    
    // Validation personnalisée pour le lieu
    const lieuInput = document.getElementById('examLieu');
    if (lieuInput) {
        lieuInput.addEventListener('input', function() {
            const regex = /^[a-zA-Z0-9\s\-.,'àâäéèêëîïôöùûüçÀÂÄÉÈÊËÎÏÔÖÙÛÜÇ]{3,100}$/;
            if (!regex.test(this.value)) {
                this.setCustomValidity('Le lieu doit contenir entre 3 et 100 caractères valides');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Validation pour la date (doit être dans le futur)
    const dateInput = document.getElementById('examDate');
    if (dateInput) {
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const now = new Date();
            
            if (selectedDate < now) {
                this.setCustomValidity('La date doit être dans le futur');
            } else {
                this.setCustomValidity('');
            }
        });
    }
})();
</script>

<style>
.action-btn {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.action-btn:hover {
    background-color: rgba(0, 0, 0, 0.05);
    transform: scale(1.1);
}

/* Styles de validation */
.is-valid {
    border-color: #28a745 !important;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    display: none;
}

.was-validated .invalid-feedback {
    display: block;
}

/* Amélioration du calendrier */
.flatpickr-input {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234D44B5' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 16px;
    padding-right: 2.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    
    .flex.justify-between.items-center {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    #examModal .grid {
        grid-template-columns: 1fr;
    }
    
    #examModal {
        padding: 1rem;
    }
    
    .flatpickr-input {
        padding-right: 0.75rem;
        background-image: none;
    }
}
</style>
@endsection