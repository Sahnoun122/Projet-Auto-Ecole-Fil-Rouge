<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>
</head>
<body>
    
<div class="flex-1 overflow-auto">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <!-- Header avec photo -->
            <div class="bg-gradient-to-r from-[#4D44B5] to-[#3a32a1] p-6 flex flex-col md:flex-row items-center">
                <div class="relative mr-6 mb-4 md:mb-0">
                    <img class="h-32 w-32 rounded-full border-4 border-white shadow-lg" 
                         src="{{ $user->profile_photo_url }}" 
                         alt="Photo de profil">
                    <span class="absolute bottom-2 right-2 block h-4 w-4 rounded-full bg-green-400 ring-2 ring-white"></span>
                </div>
                
                <div class="text-white">
                    <h1 class="text-2xl font-bold">{{ $user->prenom }} {{ $user->nom }}</h1>
                    <p class="text-indigo-200">
                        @if($user->isAdmin())
                            Administrateur
                        @elseif($user->isMoniteur())
                            Moniteur
                        @else
                            Candidat
                        @endif
                    </p>
                    
                    <div class="flex flex-wrap items-center mt-2 gap-4">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $user->email }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $user->telephone }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 border-b flex justify-end">
                <button onclick="openEditModal()" 
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier le profil
                </button>
            </div>

            <!-- Informations -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Colonne 1 -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informations personnelles</h2>
                        <div class="space-y-3">
                            <p>
                                <span class="font-medium text-gray-700">Adresse:</span> 
                                <span class="block mt-1">{{ $user->adresse ?? 'Non renseignée' }}</span>
                            </p>
                            <p>
                                <span class="font-medium text-gray-700">Date d'inscription:</span> 
                                <span class="block mt-1">{{ $user->created_at->format('d/m/Y') }}</span>
                            </p>
                        </div>
                    </div>

                    @if($user->isMoniteur())
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Disponibilités</h2>
                        <div class="space-y-2">
                            <p class="text-gray-600">Aucune disponibilité configurée</p>
                            <button class="text-[#4D44B5] hover:text-[#3a32a1] text-sm font-medium">
                                + Ajouter des disponibilités
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Colonne 2 -->
                <div class="space-y-6">
                    @if($user->isCandidat())
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Progression</h2>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="font-medium">Cours théoriques</span>
                                    <span class="text-sm">75%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="font-medium">Heures de conduite</span>
                                    <span class="text-sm">32/40h</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                            @if($user->isCandidat())
                                Permis visé
                            @elseif($user->isMoniteur())
                                Spécialisations
                            @else
                                Accès
                            @endif
                        </h2>
                        <div class="space-y-3">
                            @if($user->isCandidat())
                                <p>
                                    <span class="font-medium text-gray-700">Type de permis:</span> 
                                    <span class="inline-block px-2 py-1 bg-[#4D44B5] text-white text-xs font-medium rounded ml-2">
                                        {{ $user->type_permis ?? 'Non spécifié' }}
                                    </span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-700">Moniteur attitré:</span> 
                                    <span class="text-gray-600">Jean Dupont</span>
                                </p>
                            @elseif($user->isMoniteur())
                                <p>
                                    <span class="font-medium text-gray-700">Certifications:</span> 
                                    <span class="block mt-1">{{ $user->certifications ?? 'Non renseignées' }}</span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-700">Qualifications:</span> 
                                    <span class="block mt-1">{{ $user->qualifications ?? 'Non renseignées' }}</span>
                                </p>
                            @else
                                <p class="text-gray-600">Accès complet à toutes les fonctionnalités du système</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editProfileModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#4D44B5] to-[#3a32a1] p-4 text-white">
            <h2 class="text-xl font-bold">Modifier le profil</h2>
        </div>
        
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Photo de profil -->
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img id="profileImagePreview" class="h-32 w-32 rounded-full border-4 border-white shadow-lg" 
                             src="{{ $user->profile_photo_url }}" 
                             alt="Photo de profil">
                        <label for="photo_profile" class="absolute bottom-0 right-0 bg-[#4D44B5] text-white rounded-full p-2 cursor-pointer hover:bg-[#3a32a1] transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                        <input type="file" id="photo_profile" name="photo_profile" class="hidden" accept="image/*">
                    </div>
                    <p class="text-xs text-gray-500">Formats: jpeg, png, jpg. Max: 2MB</p>
                </div>

                <!-- Nom et prénom -->
                <div class="space-y-4">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                    </div>
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                    </div>
                </div>
            </div>

            <!-- Email et téléphone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                </div>
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                    <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                </div>
            </div>

            <!-- Adresse -->
            <div class="mb-6">
                <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                <textarea id="adresse" name="adresse" rows="2"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">{{ old('adresse', $user->adresse) }}</textarea>
            </div>

            <!-- Champs spécifiques -->
            @if($user->isCandidat())
            <div class="mb-6">
                <label for="type_permis" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                <select id="type_permis" name="type_permis"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                    <option value="">Sélectionnez un type</option>
                    <option value="A" {{ old('type_permis', $user->type_permis) == 'A' ? 'selected' : '' }}>Permis A (Moto)</option>
                    <option value="B" {{ old('type_permis', $user->type_permis) == 'B' ? 'selected' : '' }}>Permis B (Voiture)</option>
                    <option value="C" {{ old('type_permis', $user->type_permis) == 'C' ? 'selected' : '' }}>Permis C (Poids lourd)</option>
                </select>
            </div>
            @endif

            @if($user->isMoniteur())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="certifications" class="block text-sm font-medium text-gray-700 mb-1">Certifications</label>
                    <input type="text" id="certifications" name="certifications" value="{{ old('certifications', $user->certifications) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                </div>
                <div>
                    <label for="qualifications" class="block text-sm font-medium text-gray-700 mb-1">Qualifications</label>
                    <input type="text" id="qualifications" name="qualifications" value="{{ old('qualifications', $user->qualifications) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                </div>
            </div>
            @endif

            <!-- Mot de passe -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent"
                       placeholder="Laisser vide pour ne pas changer">
                <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères, avec majuscule, minuscule et chiffre</p>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()"
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

<script>
    // Gestion de la modale
    function openEditModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }

    // Prévisualisation de l'image
    document.getElementById('photo_profile').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('profileImagePreview').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Fermer la modale en cliquant à l'extérieur
    document.getElementById('editProfileModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>

</body>
</html>