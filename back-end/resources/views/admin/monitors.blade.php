@extends('layouts.admin')
@section('title', 'Moniteurs')
@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gestion des Moniteurs</h1>
            <button id="newMoniteurBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-plus mr-2"></i> Ajouter un Moniteur
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
                <h2 class="text-xl font-semibold text-gray-800">Liste des Moniteurs</h2>
                <form method="GET" action="{{ route('admin.monitors.index') }}" class="relative">
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
                        @forelse ($moniteurs as $moniteur)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.$moniteur->photo_profile) }}" alt="Photo profil">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $moniteur->nom }} {{ $moniteur->prenom }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $moniteur->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $moniteur->telephone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#4D44B5] text-white">
                                    {{ $moniteur->type_permis }}
                                </span>
                            </td>
                         
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="handleViewMoniteur('{{ $moniteur->id }}')" class="text-blue-500 hover:text-blue-700 mr-3" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="handleEditMoniteur('{{ $moniteur->id }}')" class="text-[#4D44B5] hover:text-[#3a32a1] mr-3" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="handleDeleteMoniteur('{{ $moniteur->id }}')" class="text-red-500 hover:text-red-700" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun moniteur disponible
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $moniteurs->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </main>

    <div id="moniteurModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white w-full max-w-2xl p-6 rounded-lg">
            <h2 id="modalTitle" class="text-lg font-bold mb-4">Nouveau Moniteur</h2>
            <form id="moniteurForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="moniteurId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="moniteurNom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                        <input type="text" id="moniteurNom" name="nom" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                    <div>
                        <label for="moniteurPrenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                        <input type="text" id="moniteurPrenom" name="prenom" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="moniteurEmail" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="moniteurEmail" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                    <div>
                        <label for="moniteurTelephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                        <input type="text" id="moniteurTelephone" name="telephone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="moniteurAdresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                    <input type="text" id="moniteurAdresse" name="adresse" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                </div>

                <div class="mb-4">
                    <label for="moniteurPermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                    <select id="moniteurPermisType" name="type_permis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
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
                        <label for="moniteurPhotoProfile" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil *</label>
                        <input type="file" id="moniteurPhotoProfile" name="photo_profile" accept="image/jpeg,image/png,image/jpg" class="w-full">
                        <p class="text-xs text-gray-500 mt-1">Formats acceptés: jpeg, png, jpg. Max: 2MB</p>
                        <div id="currentPhotoProfile" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Photo actuelle:</span>
                            <img id="photoProfilePreview" class="h-10 w-10 rounded-full object-cover mt-1">
                        </div>
                    </div>
                    <div>
                        <label for="moniteurPhotoIdentite" class="block text-sm font-medium text-gray-700 mb-1">Pièce d'identité *</label>
                        <input type="file" id="moniteurPhotoIdentite" name="photo_identite" accept="application/pdf" class="w-full">
                        <p class="text-xs text-gray-500 mt-1">Format accepté: PDF. Max: 2MB</p>
                        <div id="currentPhotoIdentite" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Fichier actuel:</span>
                            <a id="photoIdentiteLink" href="#" target="_blank" class="text-xs text-blue-500 hover:underline">
                                <i class="fas fa-file-pdf mr-1"></i> Voir le document
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="moniteurCertifications" class="block text-sm font-medium text-gray-700 mb-1">Certifications *</label>
                        <input type="file" id="moniteurCertifications" name="certifications" accept=".pdf,.doc,.docx" class="w-full">
                        <p class="text-xs text-gray-500 mt-1">Formats acceptés: pdf, doc, docx. Max: 2MB</p>
                        <div id="currentCertifications" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Fichier actuel:</span>
                            <a id="certificationsLink" href="#" target="_blank" class="text-xs text-blue-500 hover:underline">Voir le fichier</a>
                        </div>
                    </div>
                    <div>
                        <label for="moniteurQualifications" class="block text-sm font-medium text-gray-700 mb-1">Qualifications *</label>
                        <input type="file" id="moniteurQualifications" name="qualifications" accept=".pdf,.doc,.docx" class="w-full">
                        <p class="text-xs text-gray-500 mt-1">Formats acceptés: pdf, doc, docx. Max: 2MB</p>
                        <div id="currentQualifications" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Fichier actuel:</span>
                            <a id="qualificationsLink" href="#" target="_blank" class="text-xs text-blue-500 hover:underline">Voir le fichier</a>
                        </div>
                    </div>
                </div>

                <div class="mb-4" id="passwordField">
                    <label for="moniteurPassword" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                    <input type="password" id="moniteurPassword" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
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
                <h2 class="text-lg font-bold">Détails du Moniteur</h2>
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
                        <h3 class="text-sm font-medium text-gray-500">Pièce d'identité</h3>
                        <a id="detailPhotoIdentite" href="#" target="_blank" class="text-blue-500 hover:underline block mt-2">
                            <i class="fas fa-file-pdf mr-1"></i> Voir le document
                        </a>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Certifications</h3>
                        <a id="detailCertifications" href="#" target="_blank" class="text-blue-500 hover:underline">Voir le fichier</a>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Qualifications</h3>
                        <a id="detailQualifications" href="#" target="_blank" class="text-blue-500 hover:underline">Voir le fichier</a>
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
    const modal = $('#moniteurModal');
    const form = $('#moniteurForm');
    const passwordField = $('#passwordField');

    $('#newMoniteurBtn').click(function() {
        $('#modalTitle').text('Nouveau Moniteur');
        form.attr('action', "{{ route('admin.monitors.store') }}");
        $('#_method').val('POST');
        $('#moniteurId').val('');
        form.trigger('reset');
        passwordField.show();
        $('#moniteurPassword').attr('required', true);
        
        $('[id^="current"]').addClass('hidden');
        
        modal.removeClass('hidden');
    });

    window.handleViewMoniteur = function(id) {
        $.ajax({
            url: "{{ route('admin.monitors.show', '') }}/" + id,
            method: 'GET',
            success: function(data) {
                $('#detailNomComplet').text(data.nom + ' ' + data.prenom);
                $('#detailEmail').text(data.email);
                $('#detailTelephone').text(data.telephone);
                $('#detailAdresse').text(data.adresse);
                $('#detailPermisType').text(data.type_permis);
                $('#detailDateInscription').text(new Date(data.created_at).toLocaleDateString());
                
                if(data.photo_profile) {
                    $('#detailPhotoProfile').attr('src', "{{ asset('storage') }}/" + data.photo_profile);
                }
                if(data.photo_identite) {
                    $('#detailPhotoIdentite').attr('href', "{{ asset('storage') }}/" + data.photo_identite);
                }
                if(data.certifications) {
                    $('#detailCertifications').attr('href', "{{ asset('storage') }}/" + data.certifications);
                }
                if(data.qualifications) {
                    $('#detailQualifications').attr('href', "{{ asset('storage') }}/" + data.qualifications);
                }
                
                document.getElementById('detailModal').classList.remove('hidden');
            },
            error: function(xhr) {
                alert('Erreur lors du chargement des données: ' + xhr.responseJSON?.message);
            }
        });
    };

    window.handleEditMoniteur = function(id) {
        $('#modalTitle').text('Modifier Moniteur');
        form.attr('action', "{{ route('admin.monitors.update', '') }}/" + id);
        $('#_method').val('PUT');
        $('#moniteurId').val(id);
        passwordField.hide();
        $('#moniteurPassword').removeAttr('required');
        
        $.ajax({
            url: '/admin/monitors/' + id + '/edit',

            method: 'GET',
            success: function(data) {
                $('#moniteurNom').val(data.nom);
                $('#moniteurPrenom').val(data.prenom);
                $('#moniteurEmail').val(data.email);
                $('#moniteurTelephone').val(data.telephone);
                $('#moniteurAdresse').val(data.adresse);
                $('#moniteurPermisType').val(data.type_permis);
                
                if(data.photo_profile) {
                    $('#currentPhotoProfile').removeClass('hidden');
                    $('#photoProfilePreview').attr('src', "{{ asset('storage') }}/" + data.photo_profile);
                }
                
                if(data.photo_identite) {
                    $('#currentPhotoIdentite').removeClass('hidden');
                    $('#photoIdentiteLink').attr('href', "{{ asset('storage') }}/" + data.photo_identite);
                }
                
                if(data.certifications) {
                    $('#currentCertifications').removeClass('hidden');
                    $('#certificationsLink').attr('href', "{{ asset('storage') }}/" + data.certifications);
                }
                
                if(data.qualifications) {
                    $('#currentQualifications').removeClass('hidden');
                    $('#qualificationsLink').attr('href', "{{ asset('storage') }}/" + data.qualifications);
                }
            },
            error: function(xhr) {
                alert('Erreur lors du chargement des données: ' + xhr.responseJSON?.message);
            }
        });
        
        modal.removeClass('hidden');
    };

    window.handleDeleteMoniteur = function(id) {
        if (!confirm('Voulez-vous vraiment supprimer ce moniteur ?')) return;
        
        $.ajax({
            url: "{{ route('admin.monitors.destroy', '') }}/" + id,
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

    $('input[name="search"]').on('keyup', function(e) {
        if (e.key === 'Enter') {
            $(this).closest('form').submit();
        }
    });
});
</script>
@endsection