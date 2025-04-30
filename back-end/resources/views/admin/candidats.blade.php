@extends('layouts.admin')
@section('title', 'Candidats')
@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold mb-2 md:mb-0">Gestion des Candidats</h1>
            <button id="newCandidatBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Ajouter un Candidat
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Candidats</h2>
                <form method="GET" action="{{ route('admin.candidats') }}" class="relative w-full md:w-auto">
                    <input type="text" name="search" placeholder="Rechercher..."
                           value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] w-full">
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permis</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($candidats as $candidat)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $candidat->photo_profile ? asset('storage/'.$candidat->photo_profile) : asset('images/') }}" alt="Photo profil">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $candidat->nom }} {{ $candidat->prenom }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-500">{{ $candidat->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-sm text-gray-500">{{ $candidat->telephone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#4D44B5] bg-opacity-80 text-white">
                                    {{ $candidat->type_permis }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button onclick="handleViewCandidat('{{ $candidat->id }}')" class="text-blue-500 hover:text-blue-700" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="handleEditCandidat('{{ $candidat->id }}')" 
                                        class="text-[#4D44B5] hover:text-[#3a32a1]" 
                                        title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                    <button onclick="handleDeleteCandidat('{{ $candidat->id }}')" class="text-red-500 hover:text-red-700" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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

            <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                {{ $candidats->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </main>

    <div id="candidatModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                 <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Nouveau Candidat</h2>
                 <button type="button" id="cancelBtnTop" class="text-gray-400 hover:text-gray-600">
                     <i class="fas fa-times fa-lg"></i>
                 </button>
            </div>
            <form id="candidatForm" method="POST"   enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="candidatId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="candidatNom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                        <input type="text" id="candidatNom" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-nom"></span>
                    </div>
                    <div>
                        <label for="candidatPrenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                        <input type="text" id="candidatPrenom" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-prenom"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="candidatEmail" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="candidatEmail" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-email"></span>
                    </div>
                    <div>
                        <label for="candidatTelephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                        <input type="text" id="candidatTelephone" name="telephone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-telephone"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="candidatAdresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                    <input type="text" id="candidatAdresse" name="adresse" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                    <span class="text-red-500 text-xs mt-1 error-message" id="error-adresse"></span>
                </div>

                <div class="mb-4">
                    <label for="candidatPermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                    <select id="candidatPermisType" name="type_permis" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent bg-white">
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
                        <label for="candidatPhotoProfile" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                        <input type="file" id="candidatPhotoProfile" name="photo_profile" accept="image/jpeg,image/png,image/jpg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#e0dff7] file:text-[#4D44B5] hover:file:bg-[#c8c5f0]">
                        <p class="text-xs text-gray-500 mt-1">Formats: JPG, PNG. Max: 2MB. <span class="text-red-500">(Requis pour nouveau candidat)</span></p>
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-photo_profile"></span>
                        <div id="currentPhotoProfile" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Photo actuelle:</span>
                            <img id="photoProfilePreview" class="h-16 w-16 rounded-full object-cover mt-1 border">
                        </div>
                    </div>
                    <div>
                        <label for="candidatPhotoIdentite" class="block text-sm font-medium text-gray-700 mb-1">Pièce d'identité</label>
                        <input type="file" id="candidatPhotoIdentite" name="photo_identite" accept="application/pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#e0dff7] file:text-[#4D44B5] hover:file:bg-[#c8c5f0]">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF. Max: 2MB. <span class="text-red-500">(Requis pour nouveau candidat)</span></p>
                        <span class="text-red-500 text-xs mt-1 error-message" id="error-photo_identite"></span>
                        <div id="currentPhotoIdentite" class="mt-2 hidden">
                            <span class="text-xs text-gray-500">Fichier actuel:</span>
                            <a id="photoIdentiteLink" href="#" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm block mt-1">
                                <i class="fas fa-file-pdf mr-1"></i> Voir le document
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-4" id="passwordField">
                    <label for="candidatPassword" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                    <input type="password" id="candidatPassword" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères, avec majuscule, minuscule et chiffre.</p>
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

    <div id="detailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6 pb-3 border-b">
                <h2 class="text-xl font-bold text-gray-800">Détails du Candidat</h2>
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
                        <h3 class="text-sm font-medium text-gray-500">Type de permis</h3>
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
    const modal = $('#candidatModal');
    const detailModal = $('#detailModal');
    const form = $('#candidatForm');
    const passwordField = $('#passwordField');
    const defaultProfilePic = "{{ asset('images/') }}";

    function closeModal() {
        modal.addClass('hidden');
        $('.error-message').text('');
        $('input, select').removeClass('border-red-500');
    }

    $('#newCandidatBtn').click(function() {
        $('#modalTitle').text('Nouveau Candidat');
        form.attr('action', "{{ route('admin.candidats.store') }}");
        $('#_method').val('POST');
        $('#candidatId').val('');
        form.trigger('reset');
        passwordField.show();

        $('#currentPhotoProfile').addClass('hidden');
        $('#photoProfilePreview').attr('src', '#');
        $('#currentPhotoIdentite').addClass('hidden');
        $('#photoIdentiteLink').attr('href', '#');

        modal.removeClass('hidden');
    });

    window.handleViewCandidat = function(id) {
        $.ajax({
            url: "{{ url('admin/candidats') }}/" + id,
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

                const identiteLink = $('#detailPhotoIdentiteLink');
                const noIdentiteDoc = $('#noIdentiteDoc');
                if(data.photo_identite) {
                    identiteLink.attr('href', "{{ asset('storage') }}/" + data.photo_identite).show();
                    noIdentiteDoc.addClass('hidden');
                } else {
                    identiteLink.hide();
                    noIdentiteDoc.removeClass('hidden');
                }

                detailModal.removeClass('hidden');
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Erreur lors du chargement des détails du candidat.');
            }
        });
    };

    window.handleEditCandidat = function(id) {
        $('#modalTitle').text('Modifier Candidat');
        
        form.attr('action', "{{ url('admin/candidats') }}/" + id + "/update");
        $('#_method').val('PUT');
        $('#candidatId').val(id);
        passwordField.hide();

        $.ajax({
            url: '/admin/candidats/' + id + '/edit',

            method: 'GET',
            success: function(data) {
                $('#candidatNom').val(data.nom);
                $('#candidatPrenom').val(data.prenom);
                $('#candidatEmail').val(data.email);
                $('#candidatTelephone').val(data.telephone);
                $('#candidatAdresse').val(data.adresse);
                $('#candidatPermisType').val(data.type_permis);

                if(data.photo_profile) {
                    $('#currentPhotoProfile').removeClass('hidden');
                    $('#photoProfilePreview').attr('src', "{{ asset('storage') }}/" + data.photo_profile);
                } else {
                    $('#currentPhotoProfile').addClass('hidden');
                    $('#photoProfilePreview').attr('src', '#');
                }

                if(data.photo_identite) {
                    $('#currentPhotoIdentite').removeClass('hidden');
                    $('#photoIdentiteLink').attr('href', "{{ asset('storage') }}/" + data.photo_identite);
                } else {
                    $('#currentPhotoIdentite').addClass('hidden');
                    $('#photoIdentiteLink').attr('href', '#');
                }

                 modal.removeClass('hidden');
            },
            error: function(xhr) {
                 console.error(xhr);
                 alert('Erreur lors du chargement des données pour modification.');
            }
        });
    };

    window.handleDeleteCandidat = function(id) {
        if (!confirm('Voulez-vous vraiment supprimer ce candidat ? Cette action est irréversible.')) return;

        $.ajax({
            url: "{{ url('admin/candidats') }}/" + id,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                 alert(response.success || 'Candidat supprimé avec succès.');
                 window.location.reload();
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

    function validateField(field, regex, errorMessage, errorElementId) {
        const value = field.val().trim();
        const errorElement = $('#' + errorElementId);
        if (!value || (regex && !regex.test(value))) {
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
            field.addClass('border-red-500');
            errorElement.text(errorMessage);
            return false;
        } else {
            field.removeClass('border-red-500');
            errorElement.text('');
            return true;
        }
    }

    const nameRegex = /^[a-zA-ZÀ-ÿ\s\-']+$/;
    const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    const phoneRegex = /^0[1-9](?:[\s.-]?\d{2}){4}$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

    form.submit(function(event) {
        event.preventDefault();
        let isValid = true;

        $('.error-message').text('');
        $('input, select').removeClass('border-red-500');

        isValid &= validateField($('#candidatNom'), nameRegex, 'Le nom est requis et ne doit contenir que des lettres, espaces, tirets ou apostrophes.', 'error-nom');
        isValid &= validateField($('#candidatPrenom'), nameRegex, 'Le prénom est requis et ne doit contenir que des lettres, espaces, tirets ou apostrophes.', 'error-prenom');
        isValid &= validateField($('#candidatEmail'), emailRegex, 'Veuillez entrer une adresse email valide.', 'error-email');
        isValid &= validateField($('#candidatTelephone'), phoneRegex, 'Veuillez entrer un numéro de téléphone valide (ex: 06 12 34 56 78).', 'error-telephone');
        isValid &= validateField($('#candidatAdresse'), null, 'L\'adresse est requise.', 'error-adresse');
        isValid &= validateSelect($('#candidatPermisType'), 'Veuillez sélectionner un type de permis.', 'error-type_permis');

        const isNewCandidat = !$('#candidatId').val();

        if (isNewCandidat) {
            isValid &= validateField($('#candidatPassword'), passwordRegex, 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.', 'error-password');
        }

        isValid &= validateFile($('#candidatPhotoProfile'), isNewCandidat, 'La photo de profil est requise.', 'error-photo_profile');
        isValid &= validateFile($('#candidatPhotoIdentite'), isNewCandidat, 'La pièce d\'identité est requise.', 'error-photo_identite');

        if (isValid) {
            $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...');
            this.submit();
        } else {
            $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Enregistrer');
        }
    });

});
</script>
@endsection