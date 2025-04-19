@extends('layouts.admin')
@section('title', 'Candidats')
@section('content')
            <div class="flex-1 overflow-auto">
                <header class="bg-[#4D44B5] text-white shadow-md">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                        <h1 class="text-2xl font-bold">Gestion des Candidats</h1>
                        <button id="newCandidatBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                            <i class="fas fa-plus mr-2"></i> Ajouter un Candidat
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
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800">Liste des Candidats</h2>
                            <form method="GET" action="{{ route('admin.candidats') }}" class="relative">
                                <input type="text" name="search" placeholder="Rechercher..." 
                                       value="{{ request('search') }}" 
                                       class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </form>
                        </div>
            
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom & Prénom</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type Permis</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($candidats as $candidat)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.$candidat->photo_profile) }}" alt="Photo profil">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $candidat->nom }} {{ $candidat->prenom }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $candidat->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $candidat->telephone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#4D44B5] text-white">
                                                {{ $candidat->type_permis }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button onclick="handleViewCandidat('{{ $candidat->id }}')" class="text-blue-500 hover:text-blue-700 mr-3" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="handleEditCandidat('{{ $candidat->id }}')" class="text-[#4D44B5] hover:text-[#3a32a1] mr-3" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="handleDeleteCandidat('{{ $candidat->id }}')" class="text-red-500 hover:text-red-700" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Aucun candidat disponible
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
            
                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $candidats->appends(['search' => request('search')])->links() }}
                        </div>
                    </div>
                </main>
            
                <div id="candidatModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white w-full max-w-2xl p-6 rounded-lg">
                        <h2 id="modalTitle" class="text-lg font-bold mb-4">Nouveau Candidat</h2>
                        <form id="candidatForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="candidatId" name="id">
                            <input type="hidden" id="_method" name="_method" value="POST">
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="candidatNom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                                    <input type="text" id="candidatNom" name="nom" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
                                <div>
                                    <label for="candidatPrenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                                    <input type="text" id="candidatPrenom" name="prenom" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
                            </div>
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="candidatEmail" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" id="candidatEmail" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
                                <div>
                                    <label for="candidatTelephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                                    <input type="text" id="candidatTelephone" name="telephone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
                            </div>
            
                            <div class="mb-4">
                                <label for="candidatAdresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                                <input type="text" id="candidatAdresse" name="adresse" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            </div>
            
                            <div class="mb-4">
                                <label for="candidatPermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                                <select id="candidatPermisType" name="type_permis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="A">Permis A (Moto)</option>
                                    <option value="B">Permis B (Voiture)</option>
                                    <option value="C">Permis C (Poids lourd)</option>
                                    <option value="D">Permis D (Bus)</option>
                                    <option value="EB">Permis EB (Remorque)</option>
                                </select>
                            </div>
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="candidatPhotoProfile" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil *</label>
                                    <input type="file" id="candidatPhotoProfile" name="photo_profile" accept="image/jpeg,image/png,image/jpg" class="w-full">
                                    <p class="text-xs text-gray-500 mt-1">Formats acceptés: jpeg, png, jpg. Max: 2MB</p>
                                    <div id="currentPhotoProfile" class="mt-2 hidden">
                                        <span class="text-xs text-gray-500">Photo actuelle:</span>
                                        <img id="photoProfilePreview" class="h-10 w-10 rounded-full object-cover mt-1">
                                    </div>
                                </div>
                                <div>
                                    <label for="candidatPhotoIdentite" class="block text-sm font-medium text-gray-700 mb-1">Photo d'identité *</label>
                                    <input type="file" id="candidatPhotoIdentite" name="photo_identite" accept="image/jpeg,image/png,image/jpg" class="w-full">
                                    <p class="text-xs text-gray-500 mt-1">Formats acceptés: jpeg, png, jpg. Max: 2MB</p>
                                    <div id="currentPhotoIdentite" class="mt-2 hidden">
                                        <span class="text-xs text-gray-500">Photo actuelle:</span>
                                        <img id="photoIdentitePreview" class="h-10 w-10 rounded-full object-cover mt-1">
                                    </div>
                                </div>
                            </div>
            
                            <div class="mb-4" id="passwordField">
                                <label for="candidatPassword" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                                <input type="password" id="candidatPassword" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères, avec majuscule, minuscule et chiffre</p>
                            </div>
            
                            <div class="flex justify-end space-x-2">
                                <button type="button" id="cancelBtn"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                    Annuler
                                </button>
                                <button type="submit" id="submitBtn"
                                    class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            
                <div id="detailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white w-full max-w-2xl p-6 rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold">Détails du Candidat</h2>
                            <button onclick="document.getElementById('detailModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Photo de profil</h3>
                                    <img id="detailPhotoProfile" class="h-24 w-24 rounded-full object-cover mt-2">
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Photo d'identité</h3>
                                    <img id="detailPhotoIdentite" class="h-24 w-24 rounded-full object-cover mt-2">
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Nom complet</h3>
                                    <p id="detailNomComplet" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                    <p id="detailEmail" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Téléphone</h3>
                                    <p id="detailTelephone" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Adresse</h3>
                                    <p id="detailAdresse" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Type de permis</h3>
                                    <p id="detailPermisType" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Date d'inscription</h3>
                                    <p id="detailDateInscription" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button onclick="document.getElementById('detailModal').classList.add('hidden')" 
                                class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            $(document).ready(function() {
                const modal = $('#candidatModal');
                const form = $('#candidatForm');
                const passwordField = $('#passwordField');
            
                // Nouveau candidat
                $('#newCandidatBtn').click(function() {
                    $('#modalTitle').text('Nouveau Candidat');
                    form.attr('action', "{{ route('admin.candidats.store') }}");
                    $('#_method').val('POST');
                    $('#candidatId').val('');
                    form.trigger('reset');
                    passwordField.show();
                    $('#candidatPassword').attr('required', true);
                    
                    // Cacher les prévisualisations
                    $('[id^="current"]').addClass('hidden');
                    
                    modal.removeClass('hidden');
                });
            
                window.handleViewCandidat = function(id) {
                    $.ajax({
                        url: "{{ route('admin.candidats') }}/" + id,
                        method: 'GET',
                        success: function(data) {
                            // Remplir les détails dans la modal
                            $('#detailNomComplet').text(data.nom + ' ' + data.prenom);
                            $('#detailEmail').text(data.email);
                            $('#detailTelephone').text(data.telephone);
                            $('#detailAdresse').text(data.adresse);
                            $('#detailPermisType').text(data.type_permis);
                            $('#detailDateInscription').text(new Date(data.created_at).toLocaleDateString());
                            
                            // Afficher les photos
                            if(data.photo_profile) {
                                $('#detailPhotoProfile').attr('src', "{{ asset('storage') }}/" + data.photo_profile);
                            }
                            if(data.photo_identite) {
                                $('#detailPhotoIdentite').attr('src', "{{ asset('storage') }}/" + data.photo_identite);
                            }
                            
                            document.getElementById('detailModal').classList.remove('hidden');
                        },
                        error: function(xhr) {
                            alert('Erreur lors du chargement des données: ' + xhr.responseJSON?.message);
                        }
                    });
                };
            
                window.handleEditCandidat = function(id) {
                    $('#modalTitle').text('Modifier Candidat');
                    form.attr('action', "{{ route('admin.candidats.update', '') }}/" + id);
                    $('#_method').val('PUT');
                    $('#candidatId').val(id);
                    passwordField.hide();
                    $('#candidatPassword').removeAttr('required');
                    
                    $.ajax({
                        url: "{{ route('admin.candidats') }}/" + id + "/edit",
                        method: 'GET',
                        success: function(data) {
                            $('#candidatNom').val(data.nom);
                            $('#candidatPrenom').val(data.prenom);
                            $('#candidatEmail').val(data.email);
                            $('#candidatTelephone').val(data.telephone);
                            $('#candidatAdresse').val(data.adresse);
                            $('#candidatPermisType').val(data.type_permis);
                            
                            // Afficher les fichiers actuels
                            if(data.photo_profile) {
                                $('#currentPhotoProfile').removeClass('hidden');
                                $('#photoProfilePreview').attr('src', "{{ asset('storage') }}/" + data.photo_profile);
                            }
                            
                            if(data.photo_identite) {
                                $('#currentPhotoIdentite').removeClass('hidden');
                                $('#photoIdentitePreview').attr('src', "{{ asset('storage') }}/" + data.photo_identite);
                            }
                        },
                        error: function(xhr) {
                            alert('Erreur lors du chargement des données: ' + xhr.responseJSON?.message);
                        }
                    });
                    
                    modal.removeClass('hidden');
                };
            
                window.handleDeleteCandidat = function(id) {
                    if (!confirm('Voulez-vous vraiment supprimer ce candidat ?')) return;
                    
                    $.ajax({
                        url: "{{ route('admin.candidats.destroy', '') }}/" + id,
                        method: 'POST',
                        data: { 
                            _method: 'DELETE', 
                            _token: "{{ csrf_token() }}" 
                        },
                        success: function() {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            alert('Erreur lors de la suppression: ' + xhr.responseJSON?.message);
                        }
                    });
                };
            
                $('#cancelBtn').click(function() {
                    modal.addClass('hidden');
                });
            
                // Gestion de la recherche en temps réel (optionnel)
                $('input[name="search"]').on('keyup', function(e) {
                    if (e.key === 'Enter') {
                        $(this).closest('form').submit();
                    }
                });
            });
            </script>
       @endsection

