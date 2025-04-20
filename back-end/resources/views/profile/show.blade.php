<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="relative bg-gradient-to-r from-[#4D44B5] to-[#3a32a1] p-8 flex justify-center">
                    <div class="absolute -bottom-16">
                        <img class="h-32 w-32 rounded-full border-4 border-white shadow-xl object-cover" 
                             src="{{ $user->profile_photo_url ?? asset('default-avatar.png') }}" 
                             alt="Photo de profil">
                    </div>
                </div>

                <div class="pt-20 pb-6 px-6 text-center">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $user->prenom }} {{ $user->nom }}</h1>
                    <div class="inline-block mt-2 bg-indigo-100 text-[#4D44B5] px-3 py-1 rounded-full text-sm font-medium">
                        {{ ucfirst($user->role) }}
                    </div>

                    <div class="mt-4 flex flex-wrap justify-center gap-4 text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-indigo-500"></i>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-2 text-indigo-500"></i>
                            <span>{{ $user->telephone }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-id-card mr-2 text-[#4D44B5]"></i>
                                Informations personnelles
                            </h2>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 mr-3 text-gray-500"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Adresse</p>
                                        <p class="text-gray-600">{{ $user->adresse ?? 'Non renseignée' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-calendar-alt mt-1 mr-3 text-gray-500"></i>
                                    <div>
                                        <p class="font-medium text-gray-700">Date d'inscription</p>
                                        <p class="text-gray-600">{{ $user->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($user->role === 'moniteur')
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-calendar-check mr-2 text-[#4D44B5]"></i>
                                Disponibilités
                            </h2>
                            <p class="text-gray-600 pl-8">Aucune disponibilité définie.</p>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-6">

                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-[#4D44B5]"></i>
                                @if($user->role === 'admin')
                                    Droits d'accès
                                @elseif($user->role === 'moniteur')
                                    Spécialisations
                                @else
                                    Objectif permis
                                @endif
                            </h2>
                            <div class="pl-8 space-y-3">
                                @if($user->role === 'admin')
                                    <p class="text-gray-600">Accès complet à l'application</p>
                                @elseif($user->role === 'moniteur')
                                    <div class="flex items-start">
                                        <i class="fas fa-certificate mt-1 mr-3 text-gray-500"></i>
                                        <div>
                                            <p class="font-medium text-gray-700">Certifications</p>
                                            <p class="text-gray-600">{{ $user->certifications ?? 'Non renseignées' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-award mt-1 mr-3 text-gray-500"></i>
                                        <div>
                                            <p class="font-medium text-gray-700">Qualifications</p>
                                            <p class="text-gray-600">{{ $user->qualifications ?? 'Non renseignées' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-start">
                                        <i class="fas fa-car mt-1 mr-3 text-gray-500"></i>
                                        <div>
                                            <p class="font-medium text-gray-700">Permis visé</p>
                                            <p class="text-gray-600">{{ $user->type_permis ?? 'Non spécifié' }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6">
                    <button onclick="openEditModal()" 
                            class="w-full md:w-auto px-6 py-3 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center justify-center gap-2">
                        <i class="fas fa-edit"></i> Modifier le profil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="editProfileModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg overflow-hidden max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-gradient-to-r from-[#4D44B5] to-[#3a32a1] p-4 text-white flex justify-between items-center">
                <h2 class="text-xl font-bold">Modifier le profil</h2>
                <button onclick="closeEditModal()" class="text-white hover:text-gray-200 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            <img id="profileImagePreview" class="h-32 w-32 rounded-full border-4 border-white shadow-lg object-cover" 
                                 src="{{ $user->profile_photo_url }}" 
                                 alt="Photo de profil">
                            <label for="photo_profile" class="absolute bottom-0 right-0 bg-[#4D44B5] text-white rounded-full p-2 cursor-pointer hover:bg-[#3a32a1] transition">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="photo_profile" name="photo_profile" class="hidden" accept="image/*">
                        </div>
                        <p class="text-xs text-gray-500">Formats: jpeg, png, jpg. Max: 2MB</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-user mr-2 text-[#4D44B5]"></i> Prénom *
                            </label>
                            <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                        </div>
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-user mr-2 text-[#4D44B5]"></i> Nom *
                            </label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-envelope mr-2 text-[#4D44B5]"></i> Email *
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                    </div>
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-phone mr-2 text-[#4D44B5]"></i> Téléphone *
                        </label>
                        <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-[#4D44B5]"></i> Adresse *
                    </label>
                    <textarea id="adresse" name="adresse" rows="2"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">{{ old('adresse', $user->adresse) }}</textarea>
                </div>

                @if($user->isCandidat())
                <input type="hidden" name="type_permis" value="{{ $user->type_permis }}">
                @endif

                @if($user->isMoniteur())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="certifications" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-certificate mr-2 text-[#4D44B5]"></i> Certifications *
                        </label>
                        <input type="text" id="certifications" name="certifications" value="{{ old('certifications', $user->certifications) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                    </div>
                    <div>
                        <label for="qualifications" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-award mr-2 text-[#4D44B5]"></i> Qualifications *
                        </label>
                        <input type="text" id="qualifications" name="qualifications" value="{{ old('qualifications', $user->qualifications) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent" required>
                    </div>
                </div>
                @endif

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class="fas fa-lock mr-2 text-[#4D44B5]"></i> Nouveau mot de passe
                    </label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent"
                           placeholder="Laisser vide pour ne pas changer">
                    <p class="text-xs text-gray-500 mt-1 pl-7">Minimum 8 caractères, avec majuscule, minuscule et chiffre</p>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition flex items-center gap-2">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center gap-2">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeEditModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('photo_profile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux (max 2MB)');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profileImagePreview').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });

        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openEditModal();
            });
        @endif
    </script>
</body>
</html>