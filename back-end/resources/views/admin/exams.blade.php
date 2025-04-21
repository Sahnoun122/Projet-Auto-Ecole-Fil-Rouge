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

@endsection