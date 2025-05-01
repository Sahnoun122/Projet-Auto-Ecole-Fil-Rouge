@extends('layouts.admin')
@section('title', 'Gestion des Paiements')

@php
    $paiements = $paiements ?? collect();
    $candidats = $candidats ?? collect();
@endphp

@section('content')
<div class="flex-1 overflow-auto bg-gray-50 p-4 md:p-6 lg:p-8">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-2xl font-bold mb-2 md:mb-0">Gestion des Paiements</h1>
                <button id="newPaiementBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center w-full md:w-auto justify-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter un Paiement
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 flex items-center">
                    <div class="mr-4 p-3 rounded-full bg-white/20">
                        <i class="fas fa-money-bill-wave text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-light">Total des paiements</p>
                        <h3 class="text-xl font-bold">{{ number_format($paiements->sum('montant'), 2) }} DH</h3>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 flex items-center">
                    <div class="mr-4 p-3 rounded-full bg-white/20">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-light">Candidats Ayant Payé</p>
                        <h3 class="text-xl font-bold">{{ $paiements->where('montant', '>', 0)->pluck('user_id')->unique()->count() }}</h3>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 flex items-center">
                    <div class="mr-4 p-3 rounded-full bg-white/20">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-light">Montant total restant</p>
                        <h3 class="text-xl font-bold">{{ number_format($paiements->sum(function($p) { return max(0, $p->montant_total - $p->montant); }), 2) }} DH</h3>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('admin.paiements') }}" class="mb-6 bg-white p-4 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <div class="relative">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" placeholder="Nom, email..."
                               value="{{ request('search') }}"
                               class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] w-full">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div class="relative">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                     <div class="relative">
                        <select id="status" name="status" class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] w-full">
                            <option value="">Tous</option>
                            <option value="complete" {{ request('status') == 'complete' ? 'selected' : '' }}>Complets</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partiels</option>
                        </select>
                        <i class="fas fa-filter absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div class="relative">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                     <div class="relative">
                        <input type="date" id="date" name="date" value="{{ request('date') }}" class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] w-full">
                        <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div class="sm:col-start-2 lg:col-start-4 flex justify-end">
                    <button type="submit" class="bg-[#4D44B5] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition flex items-center w-full sm:w-auto justify-center">
                        <i class="fas fa-filter mr-2"></i> Filtrer
                    </button>
                </div>
            </div>
        </form>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-2">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Paiements</h2>
                <div class="flex gap-2">
                    <button class="text-gray-500 hover:text-[#4D44B5] p-2 rounded-md hover:bg-gray-100" title="Imprimer">
                        <i class="fas fa-print"></i>
                    </button>
                    <button class="text-gray-500 hover:text-[#4D44B5] p-2 rounded-md hover:bg-gray-100" title="Télécharger">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Montant Payé</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Montant Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($paiements as $paiement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $paiement->candidat->getProfilePhotoUrlAttribute() }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $paiement->candidat->nom }} {{ $paiement->candidat->prenom }}</div>
                                        <div class="text-sm text-gray-500 hidden sm:block">{{ $paiement->candidat->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($paiement->montant, 2) }} DH</div>
                                <div class="text-xs text-gray-500">
                                    @php
                                        $percentage = $paiement->montant_total > 0 ? ($paiement->montant / $paiement->montant_total) * 100 : ($paiement->montant > 0 ? 100 : 0);
                                    @endphp
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                        <div class="bg-[#4D44B5] h-1.5 rounded-full" style="width: {{ min(100, $percentage) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                {{ number_format($paiement->montant_total, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $reste = max(0, $paiement->montant_total - $paiement->montant);
                                    $isComplete = $paiement->montant_total > 0 && $reste == 0;
                                @endphp

                                @if($isComplete)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Complet
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paiement->montant > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $paiement->montant > 0 ? 'Partiel' : 'Non Payé' }} @if($paiement->montant_total > 0) ({{ number_format($reste, 2) }} DH) @endif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-1 sm:space-x-2 justify-end">
                                    <button onclick="showPaiementDetails('{{ $paiement->id }}')" class="text-gray-500 hover:text-blue-600 p-1 rounded hover:bg-gray-100" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="editPaiement('{{ $paiement->id }}')" class="text-[#4D44B5] hover:text-[#3a32a1] p-1 rounded hover:bg-gray-100" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deletePaiement('{{ $paiement->id }}')" class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-gray-100" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-search text-gray-300 text-5xl mb-4"></i>
                                    <span class="text-gray-500 text-lg">Aucun paiement trouvé</span>
                                     @if(request()->has('search') || request()->has('status') || request()->has('date'))
                                        <p class="text-gray-400 mt-1">Essayez d'ajuster vos filtres.</p>
                                        <a href="{{ route('admin.paiements') }}" class="mt-2 text-sm text-[#4D44B5] hover:underline">Réinitialiser les filtres</a>
                                    @else
                                        <p class="text-gray-400 mt-1">Ajoutez un nouveau paiement pour commencer.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($paiements, 'hasPages') && $paiements->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                {{ $paiements->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </main>

    <div id="paiementModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6 pb-4 border-b">
                <h2 id="modalPaiementTitle" class="text-xl font-bold text-gray-800">Nouveau Paiement</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="paiementForm" method="POST" novalidate>
                @csrf
                <input type="hidden" id="paiementId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="paiementCandidat" class="block text-sm font-medium text-gray-700 mb-1">Candidat *</label>
                        <div class="relative">
                            <select id="paiementCandidat" name="candidat_id" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                <option value="">Sélectionnez un candidat</option>
                                @foreach($candidats as $candidat)
                                    <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                         <span class="text-red-500 text-xs mt-1 hidden error-message">Veuillez sélectionner un candidat.</span>
                    </div>
                    <div>
                        <label for="paiementDate" class="block text-sm font-medium text-gray-700 mb-1">Date de paiement *</label>
                        <div class="relative">
                            <input type="date" id="paiementDate" name="date_paiement" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                         <span class="text-red-500 text-xs mt-1 hidden error-message">Veuillez entrer une date valide.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="paiementMontant" class="block text-sm font-medium text-gray-700 mb-1">Montant Payé (DH) *</label>
                        <div class="relative">
                            <input type="text" inputmode="decimal" pattern="^\d+(\.\d{1,2})?$" id="paiementMontant" name="montant" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <i class="fas fa-money-bill-wave absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                         <span class="text-red-500 text-xs mt-1 hidden error-message">Montant invalide (ex: 150.50).</span>
                    </div>
                    <div>
                        <label for="paiementTotal" class="block text-sm font-medium text-gray-700 mb-1">Montant Total (DH) *</label>
                        <div class="relative">
                            <input type="text" inputmode="decimal" pattern="^\d+(\.\d{1,2})?$" id="paiementTotal" name="montant_total" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                         <span class="text-red-500 text-xs mt-1 hidden error-message">Montant total invalide ou inférieur au montant payé.</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Méthode de paiement</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label for="methodeEspeces" class="border rounded-lg p-3 cursor-pointer hover:border-[#4D44B5] text-center flex flex-col items-center justify-center transition payment-method-label">
                            <input type="radio" name="methode_paiement" id="methodeEspeces" value="especes" class="hidden payment-method-input">
                            <i class="fas fa-money-bill text-2xl mb-2 text-gray-600"></i>
                            <span class="text-sm">Espèces</span>
                        </label>
                         <label for="methodeCheque" class="border rounded-lg p-3 cursor-pointer hover:border-[#4D44B5] text-center flex flex-col items-center justify-center transition payment-method-label">
                            <input type="radio" name="methode_paiement" id="methodeCheque" value="cheque" class="hidden payment-method-input">
                            <i class="fas fa-money-check text-2xl mb-2 text-gray-600"></i>
                            <span class="text-sm">Chèque</span>
                        </label>
                         <label for="methodeVirement" class="border rounded-lg p-3 cursor-pointer hover:border-[#4D44B5] text-center flex flex-col items-center justify-center transition payment-method-label">
                            <input type="radio" name="methode_paiement" id="methodeVirement" value="virement" class="hidden payment-method-input">
                            <i class="fas fa-university text-2xl mb-2 text-gray-600"></i>
                            <span class="text-sm">Virement</span>
                        </label>
                    </div>
                     <span class="text-red-500 text-xs mt-1 hidden error-message">Veuillez sélectionner une méthode.</span>
                </div>

                <div class="mb-6">
                    <label for="paiementDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <div class="relative">
                        <textarea id="paiementDescription" name="description" rows="3" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
                        <i class="fas fa-comment-alt absolute left-3 top-3 text-gray-400"></i>
                    </div>
                     <span class="text-red-500 text-xs mt-1 hidden error-message">Description trop longue.</span>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="cancelPaiementBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </button>
                    <button type="submit" id="submitPaiementBtn" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center">
                        <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="detailPaiementModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6 pb-4 border-b">
                <h2 class="text-xl font-bold text-gray-800">Détails du Paiement</h2>
                <button id="closeDetailModalBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div id="detailPaiementContent" class="space-y-4">
                Chargement des détails...
            </div>

            <div class="flex justify-end mt-6 pt-4 border-t">
                <button id="closeDetailBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const modal = $('#paiementModal');
    const detailModal = $('#detailPaiementModal');
    const form = $('#paiementForm');
    const modalTitle = $('#modalPaiementTitle');
    const paiementIdInput = $('#paiementId');
    const methodInput = $('#_method');

    function showModal(title, actionUrl, method = 'POST', paiementData = null) {
        modalTitle.text(title);
        form.attr('action', actionUrl);
        methodInput.val(method);
        paiementIdInput.val(paiementData ? paiementData.id : '');
        form.trigger('reset');
        clearValidationErrors();
        $('.payment-method-label').removeClass('border-[#4D44B5] bg-blue-50');

        if (paiementData) {
            $('#paiementCandidat').val(paiementData.user_id || paiementData.candidat_id);
            $('#paiementMontant').val(paiementData.montant);
            $('#paiementTotal').val(paiementData.montant_total);
            $('#paiementDate').val(paiementData.date_paiement ? paiementData.date_paiement.split('T')[0] : '');
            $('#paiementDescription').val(paiementData.description || '');
            if (paiementData.methode_paiement) {
                const methodRadio = $(`#methode${paiementData.methode_paiement.charAt(0).toUpperCase() + paiementData.methode_paiement.slice(1)}`);
                methodRadio.prop('checked', true);
                methodRadio.closest('.payment-method-label').addClass('border-[#4D44B5] bg-blue-50');
            }
        }
        modal.removeClass('hidden').addClass('flex');
    }

    function hideModal(modalElement) {
        modalElement.addClass('hidden').removeClass('flex');
    }

    function clearValidationErrors() {
        $('.error-message').addClass('hidden');
        form.find('.border-red-500').removeClass('border-red-500 focus:ring-red-500').addClass('focus:ring-[#4D44B5]');
    }

    function showValidationError(inputElement, message) {
        const errorSpan = $(inputElement).closest('div').find('.error-message');
        errorSpan.text(message).removeClass('hidden');
        $(inputElement).addClass('border-red-500 focus:ring-red-500').removeClass('focus:ring-[#4D44B5]');
    }

    function validateField(element, regex, errorMessage, required = true) {
        const value = $(element).val().trim();
        if (required && !value) {
            showValidationError(element, "Ce champ est requis.");
            return false;
        }
        if (value && regex && !regex.test(value)) {
            showValidationError(element, errorMessage);
            return false;
        }
        return true;
    }

    $('#newPaiementBtn').click(function() {
        showModal('Nouveau Paiement', "{{ route('admin.paiements.store') }}", 'POST');
    });

    $('#cancelPaiementBtn, #closeModalBtn').click(function() {
        hideModal(modal);
    });

    $('#closeDetailBtn, #closeDetailModalBtn').click(function() {
        hideModal(detailModal);
    });

    $('.payment-method-label').click(function() {
        $('.payment-method-label').removeClass('border-[#4D44B5] bg-blue-50');
        $(this).addClass('border-[#4D44B5] bg-blue-50');
        $(this).find('input[type="radio"]').prop('checked', true);
         $(this).closest('.mb-6').find('.error-message').addClass('hidden');
    });

    window.editPaiement = function(id) {
        $.ajax({
            url: `/admin/paiements/${id}/edit`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    showModal('Modifier Paiement', `/admin/paiements/${id}`, 'PUT', response.paiement);
                } else {
                    alert('Erreur: ' + response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Erreur lors du chargement des données. Voir la console.');
            }
        });
    };

    window.showPaiementDetails = function(id) {
        $('#detailPaiementContent').html('Chargement des détails...');
        detailModal.removeClass('hidden').addClass('flex');
        $.ajax({
            url: `/admin/paiements/${id}/details`,
            method: 'GET',
            success: function(data) {
                $('#detailPaiementContent').html(data);
            },
            error: function(xhr) {
                 $('#detailPaiementContent').html('<p class="text-red-500">Erreur lors du chargement des détails.</p>');
                console.error(xhr);
            }
        });
    };

    window.deletePaiement = function(id) {
        if (!confirm('Voulez-vous vraiment supprimer ce paiement ?')) return;

        $.ajax({
            url: `/admin/paiements/${id}`,
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

    form.on('submit', function(e) {
        clearValidationErrors();
        let isValid = true;
        const numericRegex = /^\d+(\.\d{1,2})?$/;

        if (!$('#paiementCandidat').val()) {
            showValidationError('#paiementCandidat', 'Veuillez sélectionner un candidat.');
            isValid = false;
        }

        if (!$('#paiementDate').val()) {
            showValidationError('#paiementDate', 'Veuillez entrer une date.');
            isValid = false;
        }

        const montantInput = $('#paiementMontant');
        if (!validateField(montantInput, numericRegex, 'Montant invalide (ex: 150.50).', true)) {
            isValid = false;
        }

        const totalInput = $('#paiementTotal');
         if (!validateField(totalInput, numericRegex, 'Montant total invalide (ex: 2500.00).', true)) {
            isValid = false;
        }

        const montant = parseFloat(montantInput.val());
        const total = parseFloat(totalInput.val());
        if (!isNaN(montant) && !isNaN(total) && total > 0 && montant > total) {
             showValidationError(montantInput, 'Le montant payé ne peut pas dépasser le montant total.');
             showValidationError(totalInput, 'Le montant total doit être supérieur ou égal au montant payé.');
             isValid = false;
        }


        const description = $('#paiementDescription').val();
        if (description && description.length > 500) {
             showValidationError('#paiementDescription', 'La description ne doit pas dépasser 500 caractères.');
             isValid = false;
        }


        if (!isValid) {
            e.preventDefault();
             const firstError = $('.error-message:not(.hidden)').first();
             if (firstError.length) {
                 firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
             }
        }
    });

     form.find('input, select, textarea').on('input change', function() {
         const fieldContainer = $(this).closest('div');
         fieldContainer.find('.error-message').addClass('hidden');
         $(this).removeClass('border-red-500 focus:ring-red-500').addClass('focus:ring-[#4D44B5]');

         if ($(this).is('input[type="radio"]')) {
             $(this).closest('.mb-6').find('.error-message').addClass('hidden');
         }
     });

});
</script>
@endsection