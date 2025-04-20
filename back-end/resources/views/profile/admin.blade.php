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