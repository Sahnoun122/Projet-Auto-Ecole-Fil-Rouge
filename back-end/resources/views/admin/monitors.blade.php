@extends('layouts.admin')
@section('title', 'Moniteurs')
@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold mb-2 md:mb-0">Gestion des Moniteurs</h1>
            <button id="newMoniteurBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Ajouter un Moniteur
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
                <p>{{ session('success') }}</p>
            </div>
        @endif
         @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Moniteurs</h2>
                <form method="GET" action="{{ route('admin.monitors.index') }}" class="relative w-full md:w-auto">
                    <input type="text" name="search" placeholder="Rechercher..."
                           value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent w-full">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom & Prénom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Téléphone</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type Permis</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($moniteurs as $moniteur)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover border" src="{{ $moniteur->photo_profile ? asset('storage/'.$moniteur->photo_profile) : asset('images/default-profile.png') }}" alt="Photo profil">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $moniteur->nom }} {{ $moniteur->prenom }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-500">{{ $moniteur->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-sm text-gray-500">{{ $moniteur->telephone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#4D44B5] bg-opacity-80 text-white">
                                    {{ $moniteur->type_permis }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button onclick="handleViewMoniteur('{{ $moniteur->id }}')" class="text-blue-500 hover:text-blue-700" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="handleEditMoniteur('{{ $moniteur->id }}')" class="text-[#4D44B5] hover:text-[#3a32a1]" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="handleDeleteMoniteur('{{ $moniteur->id }}')" class="text-red-500 hover:text-red-700" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun moniteur disponible
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                {{ $moniteurs->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </main>

    <!-- Modal Ajout/Modification -->
    <div id="moniteurModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">
             <div class="flex justify-between items-center mb-4 pb-2 border-b">
                 <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Nouveau Moniteur</h2>
                 <button type="button" id="cancelBtnTop" class="text-gray-400 hover:text-gray-600">
                     <i class="fas fa-times fa-lg"></i>
                 </button>
            </div>
            <form id="moniteurForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="moniteurId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="moniteurNom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                        <input type="text" id="moniteurNom" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-nom"></span>
                    </div>
                    <div>
                        <label for="moniteurPrenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                        <input type="text" id="moniteurPrenom" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                         <span class="text-red-500 text-xs mt-1 error-message" id="error-prenom"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="moniteurEmail" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="moniteurEmail" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                         <span class="text-red-500 text-xs mt-1 error-message" id="error-email"></span>
                    </div>
                    <div>
                        <label for="moniteurTelephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                        <input type="text" id="moniteurTelephone" name="telephone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                         <span class="text-red-500 text-xs mt-1 error-message" id="error-telephone"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="moniteurAdresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                    <input type="text" id="moniteurAdresse" name="adresse" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                     <span class="text-red-500 text-xs mt-1 error-message" id="error-adresse"></span>
                </div>

                <div class="mb-4">
                    <label for="moniteurPermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis enseigné *</label>
                    <select id="moniteurPermisType" name="type_permis" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent bg-white">
                        <option value="">Sélectionnez un type</option>
                        <option value="A">Permis A (Moto)</option>
                        <option value="B">Permis B (Voiture)</option>
                        <option value="C">Permis C (Poids lourd)</option>
                        <option value="D">Permis D (Bus)</option>
                        <option value="EB">Permis EB (Remorque)</option>
                    </select>
                     <span class="text-red-500 text-xs mt-1 error-message" id="error-type_permis"></span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="moniteurPhotoProfile" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                        <input type="file" id="moniteurPhotoProfile" name="photo_profile" accept="image/jpeg,image/png,image/jpg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#e0dff7] file:text-[#4D44B5] hover:file:bg-[#c8c5f0]">
                        <p class="text-xs text-gray-500 mt-1">Formats: JPG, PNG. Max: 2MB. <span class="text-red-500">(Requis pour nouveau moniteur)</span></p>
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-photo_profile"></span>
                        <div id="currentPhotoProfile" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Photo actuelle:</span>
                            <img id="photoProfilePreview" class="h-16 w-16 rounded-full object-cover mt-1 border">
                        </div>
                    </div>
                    <div>
                        <label for="moniteurPhotoIdentite" class="block text-sm font-medium text-gray-700 mb-1">Pièce d'identité</label>
                        <input type="file" id="moniteurPhotoIdentite" name="photo_identite" accept="application/pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#e0dff7] file:text-[#4D44B5] hover:file:bg-[#c8c5f0]">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF. Max: 2MB. <span class="text-red-500">(Requis pour nouveau moniteur)</span></p>
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-photo_identite"></span>
                        <div id="currentPhotoIdentite" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Fichier actuel:</span>
                            <a id="photoIdentiteLink" href="#" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm block mt-1">
                                <i class="fas fa-file-pdf mr-1"></i> Voir le document
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="moniteurCertifications" class="block text-sm font-medium text-gray-700 mb-1">Certifications</label>
                        <input type="file" id="moniteurCertifications" name="certifications" accept=".pdf,.doc,.docx" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#e0dff7] file:text-[#4D44B5] hover:file:bg-[#c8c5f0]">
                        <p class="text-xs text-gray-500 mt-1">Formats: PDF, DOC, DOCX. Max: 2MB. <span class="text-red-500">(Requis pour nouveau moniteur)</span></p>
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-certifications"></span>
                        <div id="currentCertifications" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Fichier actuel:</span>
                            <a id="certificationsLink" href="#" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm block mt-1">Voir le fichier</a>
                        </div>
                    </div>
                    <div>
                        <label for="moniteurQualifications" class="block text-sm font-medium text-gray-700 mb-1">Qualifications</label>
                        <input type="file" id="moniteurQualifications" name="qualifications" accept=".pdf,.doc,.docx" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#e0dff7] file:text-[#4D44B5] hover:file:bg-[#c8c5f0]">
                        <p class="text-xs text-gray-500 mt-1">Formats: PDF, DOC, DOCX. Max: 2MB. <span class="text-red-500">(Requis pour nouveau moniteur)</span></p>
                         <span class="text-red-500 text-xs mt-1 error-message" id="error-qualifications"></span>
                        <div id="currentQualifications" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Fichier actuel:</span>
                            <a id="qualificationsLink" href="#" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm block mt-1">Voir le fichier</a>
                        </div>
                    </div>
                </div>

                <div class="mb-4" id="passwordField">
                    <label for="moniteurPassword" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                    <input type="password" id="moniteurPassword" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères, avec majuscule, minuscule et chiffre. <span id="passwordEditHint" class="hidden text-blue-600">Laissez vide si vous ne souhaitez pas changer le mot de passe.</span></p>
                     <span class="text-red-500 text-xs mt-1 error-message" id="error-password"></span>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelBtn"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition font-medium">
                        Annuler
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition font-medium flex items-center">
                         <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Détails -->
     <div id="detailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6 pb-3 border-b">
                <h2 class="text-xl font-bold text-gray-800">Détails du Moniteur</h2>
                <button onclick="document.getElementById('detailModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                     <i class="fas fa-times fa-lg"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1 space-y-4">
                     <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Photo de profil</h3>
                        <img id="detailPhotoProfile" class="h-24 w-24 rounded-full object-cover border">
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Pièce d'identité</h3>
                        <a id="detailPhotoIdentiteLink" href="#" target="_blank" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200">
                            <i class="fas fa-file-pdf mr-2"></i> Voir
                        </a>
                         <p id="noIdentiteDoc" class="text-sm text-gray-500 mt-1 hidden">Aucun document</p>
                    </div>
                     <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Certifications</h3>
                        <a id="detailCertificationsLink" href="#" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm hover:bg-green-200">
                            <i class="fas fa-file-alt mr-2"></i> Voir
                        </a>
                         <p id="noCertifDoc" class="text-sm text-gray-500 mt-1 hidden">Aucun document</p>
                    </div>
                     <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Qualifications</h3>
                        <a id="detailQualificationsLink" href="#" target="_blank" class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm hover:bg-purple-200">
                           <i class="fas fa-file-alt mr-2"></i> Voir
                        </a>
                         <p id="noQualifDoc" class="text-sm text-gray-500 mt-1 hidden">Aucun document</p>
                    </div>
                </div>

                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nom complet</h3>
                        <p id="detailNomComplet" class="mt-1 text-sm text-gray-900 font-semibold"></p>
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
                        <h3 class="text-sm font-medium text-gray-500">Type de permis enseigné</h3>
                        <p id="detailPermisType" class="mt-1 text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Date d'inscription</h3>
                        <p id="detailDateInscription" class="mt-1 text-sm text-gray-900"></p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t flex justify-end">
                <button onclick="document.getElementById('detailModal').classList.add('hidden')"
                    class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition font-medium">
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
    const detailModal = $('#detailModal');
    const form = $('#moniteurForm');
    const passwordField = $('#passwordField');
    const passwordInput = $('#moniteurPassword');
    const passwordEditHint = $('#passwordEditHint');
    const defaultProfilePic = "{{ asset('images/default-profile.png') }}";

    function closeModal() {
        modal.addClass('hidden');
        $('.error-message').text('');
        $('input, select').removeClass('border-red-500');
        form.trigger('reset');
        $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Enregistrer');
    }

    function showFileLink(elementId, linkId, noDocId, filePath) {
        const linkElement = $('#' + linkId);
        const noDocElement = $('#' + noDocId);
        if (filePath) {
            linkElement.attr('href', "{{ asset('storage') }}/" + filePath).show();
            noDocElement.addClass('hidden');
        } else {
            linkElement.hide();
            noDocElement.removeClass('hidden');
        }
    }

    $('#newMoniteurBtn').click(function() {
        $('#modalTitle').text('Nouveau Moniteur');
        form.attr('action', "{{ route('admin.monitors.store') }}");
        $('#_method').val('POST');
        $('#moniteurId').val('');
        form.trigger('reset');
        passwordField.show();
        passwordInput.attr('required', true);
        passwordEditHint.addClass('hidden');

        $('[id^="current"]').addClass('hidden');
        $('#photoProfilePreview').attr('src', '#');
        $('#photoIdentiteLink').attr('href', '#');
        $('#certificationsLink').attr('href', '#');
        $('#qualificationsLink').attr('href', '#');

        modal.removeClass('hidden');
    });

    window.handleViewMoniteur = function(id) {
        $.ajax({
            url: "{{ route('admin.monitors.show', '') }}/" + id,
            method: 'GET',
            success: function(data) {
                $('#detailNomComplet').text(data.nom + ' ' + data.prenom);
                $('#detailEmail').text(data.email || '-');
                $('#detailTelephone').text(data.telephone || '-');
                $('#detailAdresse').text(data.adresse || '-');
                $('#detailPermisType').text(data.type_permis || '-');
                $('#detailDateInscription').text(data.created_at ? new Date(data.created_at).toLocaleDateString('fr-FR') : '-');

                if(data.photo_profile) {
                    $('#detailPhotoProfile').attr('src', "{{ asset('storage') }}/" + data.photo_profile).show();
                } else {
                     $('#detailPhotoProfile').attr('src', defaultProfilePic).show();
                }

                showFileLink('detailPhotoIdentite', 'detailPhotoIdentiteLink', 'noIdentiteDoc', data.photo_identite);
                showFileLink('detailCertifications', 'detailCertificationsLink', 'noCertifDoc', data.certifications);
                showFileLink('detailQualifications', 'detailQualificationsLink', 'noQualifDoc', data.qualifications);

                detailModal.removeClass('hidden');
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Erreur lors du chargement des détails du moniteur.');
            }
        });
    };

    window.handleEditMoniteur = function(id) {
        $('#modalTitle').text('Modifier Moniteur');
        form.attr('action', "{{ route('admin.monitors.update', '') }}/" + id);
        $('#_method').val('PUT');
        $('#moniteurId').val(id);
        passwordField.show();
        passwordInput.removeAttr('required');
        passwordEditHint.removeClass('hidden');

        $('.error-message').text('');
        $('input, select').removeClass('border-red-500');
        $('[id^="current"]').addClass('hidden');

        $.ajax({
            url: "{{ url('admin/monitors') }}/" + id + '/edit',
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

                 modal.removeClass('hidden');
            },
            error: function(xhr) {
                 console.error(xhr);
                 alert('Erreur lors du chargement des données pour modification.');
            }
        });
    };

    window.handleDeleteMoniteur = function(id) {
        if (!confirm('Voulez-vous vraiment supprimer ce moniteur ? Cette action est irréversible.')) return;

        $.ajax({
            url: "{{ route('admin.monitors.destroy', '') }}/" + id,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                 if(response.success) {
                     window.location.reload();
                 } else {
                     window.location.reload();
                 }
            },
            error: function(xhr) {
                 console.error(xhr);
                 alert('Erreur lors de la suppression: ' + (xhr.responseJSON?.message || 'Erreur inconnue'));
            }
        });
    };

    $('#cancelBtn, #cancelBtnTop').click(closeModal);

     modal.click(function(event) {
        if (event.target === this) {
            closeModal();
        }
    });
     detailModal.click(function(event) {
        if (event.target === this) {
            detailModal.addClass('hidden');
        }
    });

    function validateField(field, regex, errorMessage, errorElementId, isRequired = true) {
        const value = field.val().trim();
        const errorElement = $('#' + errorElementId);
        let isValid = true;

        if (isRequired && !value) {
            isValid = false;
            errorMessage = field.prev('label').text().replace('*','').trim() + ' est requis.';
        } else if (value && regex && !regex.test(value)) {
            isValid = false;
        }

        if (!isValid) {
            field.addClass('border-red-500');
            errorElement.text(errorMessage);
            return false;
        } else {
            field.removeClass('border-red-500');
            errorElement.text('');
            return true;
        }
    }

    function validateSelect(field, errorMessage, errorElementId) {
        const value = field.val();
        const errorElement = $('#' + errorElementId);
        if (!value) {
            field.addClass('border-red-500');
            errorElement.text(errorMessage);
            return false;
        } else {
            field.removeClass('border-red-500');
            errorElement.text('');
            return true;
        }
    }

    function validateFile(field, isRequired, errorMessage, errorElementId) {
        const errorElement = $('#' + errorElementId);
        const file = field[0].files[0];
        if (isRequired && !file) {
            errorElement.text(errorMessage);
            return false;
        } else {
            errorElement.text('');
            return true;
        }
    }

    const nameRegex = /^[a-zA-ZÀ-ÿ\s\-']+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

    form.submit(function(event) {
        event.preventDefault();
        let isValid = true;

        $('.error-message').text('');
        $('input, select').removeClass('border-red-500');

        isValid &= validateField($('#moniteurNom'), nameRegex, 'Le nom contient des caractères invalides.', 'error-nom');
        isValid &= validateField($('#moniteurPrenom'), nameRegex, 'Le prénom contient des caractères invalides.', 'error-prenom');
        isValid &= validateField($('#moniteurEmail'), emailRegex, 'Veuillez entrer une adresse email valide.', 'error-email');
        isValid &= validateField($('#moniteurTelephone'), phoneRegex, 'Veuillez entrer un numéro de téléphone valide (ex: 0612345678 ou +33 6 12 34 56 78).', 'error-telephone');
        isValid &= validateField($('#moniteurAdresse'), null, 'L\'adresse est requise.', 'error-adresse');
        isValid &= validateSelect($('#moniteurPermisType'), 'Veuillez sélectionner un type de permis.', 'error-type_permis');

        const isNewMoniteur = !$('#moniteurId').val();
        const passwordValue = passwordInput.val();

        if (isNewMoniteur) {
             isValid &= validateField(passwordInput, passwordRegex, 'Le mot de passe doit faire 8 caractères min, avec majuscule, minuscule et chiffre.', 'error-password', true);
        } else if (passwordValue) {
             isValid &= validateField(passwordInput, passwordRegex, 'Le mot de passe doit faire 8 caractères min, avec majuscule, minuscule et chiffre.', 'error-password', false);
        } else {
             passwordInput.removeClass('border-red-500');
             $('#error-password').text('');
        }

        isValid &= validateFile($('#moniteurPhotoProfile'), isNewMoniteur, 'La photo de profil est requise.', 'error-photo_profile');
        isValid &= validateFile($('#moniteurPhotoIdentite'), isNewMoniteur, 'La pièce d\'identité est requise.', 'error-photo_identite');
        isValid &= validateFile($('#moniteurCertifications'), isNewMoniteur, 'Les certifications sont requises.', 'error-certifications');
        isValid &= validateFile($('#moniteurQualifications'), isNewMoniteur, 'Les qualifications sont requises.', 'error-qualifications');

        if (isValid) {
            $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...');
             this.submit();
        } else {
             $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Enregistrer');
             const firstError = $('.error-message').filter(function() { return $(this).text() !== ''; }).first();
             if (firstError.length) {
                 firstError.closest('div').find('input, select')[0].focus();
             }
        }
    });

    $('input[name="search"]').on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $(this).closest('form').submit();
        }
    });
});
</script>
@endsection