@extends('layouts.admin')
@section('title', 'Gestion des Paiements')

@php
    $paiements = $paiements ?? collect();
    $candidats = $candidats ?? collect();
@endphp

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gestion des Paiements</h1>
            <button id="newPaiementBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-plus mr-2"></i> Ajouter un Paiement
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
                <h2 class="text-xl font-semibold text-gray-800">Liste des Paiements</h2>
                <form method="GET" action="{{ route('admin.paiements') }}" class="relative">
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant Payé</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reste</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($paiements as $paiement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $paiement->candidat->getProfilePhotoUrlAttribute() }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $paiement->candidat->nom }} {{ $paiement->candidat->prenom }}</div>
                                        <div class="text-sm text-gray-500">{{ $paiement->candidat->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($paiement->montant, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($paiement->montant_total, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format(max(0, $paiement->montant_total - $paiement->montant), 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                              
                                <button onclick="editPaiement('{{ $paiement->id }}')" class="text-[#4D44B5] hover:text-[#3a32a1] mr-3" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deletePaiement('{{ $paiement->id }}')" class="text-red-500 hover:text-red-700" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun paiement disponible
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($paiements, 'hasPages') && $paiements->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $paiements->appends(['search' => request('search')])->links() }}
            </div>
            @endif
        </div>
    </main>

    <div id="paiementModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white w-full max-w-2xl p-6 rounded-lg">
            <h2 id="modalPaiementTitle" class="text-lg font-bold mb-4">Nouveau Paiement</h2>
            <form id="paiementForm" method="POST">
                @csrf
                <input type="hidden" id="paiementId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="paiementCandidat" class="block text-sm font-medium text-gray-700 mb-1">Candidat *</label>
                        <select id="paiementCandidat" name="candidat_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <option value="">Sélectionnez un candidat</option>
                            @foreach($candidats as $candidat)
                                <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="paiementDate" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                        <input type="date" id="paiementDate" name="date_paiement" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="paiementMontant" class="block text-sm font-medium text-gray-700 mb-1">Montant Payé (DH) *</label>
                        <input type="number" step="0.01" id="paiementMontant" name="montant" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                    <div>
                        <label for="paiementTotal" class="block text-sm font-medium text-gray-700 mb-1">Montant Total (DH) *</label>
                        <input type="number" step="0.01" id="paiementTotal" name="montant_total" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="paiementDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="paiementDescription" name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelPaiementBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitPaiementBtn" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

  
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const modal = $('#paiementModal');
    const form = $('#paiementForm');

    $('#newPaiementBtn').click(function() {
        $('#modalPaiementTitle').text('Nouveau Paiement');
        form.attr('action', "{{ route('admin.paiements.store') }}");
        $('#_method').val('POST');
        $('#paiementId').val('');
        form.trigger('reset');
        modal.removeClass('hidden');
    });

    window.editPaiement = function(id) {
        $.ajax({
            url: `/admin/paiements/${id}/edit`,
            method: 'GET',
            success: function(response) {
                if(response.success) {
                    const paiement = response.paiement;
                    
                    $('#modalPaiementTitle').text('Modifier Paiement');
                    form.attr('action', `/admin/paiements/${id}`);
                    $('#_method').val('PUT');
                    $('#paiementId').val(paiement.id);
                    $('#paiementCandidat').val(paiement.user_id);
                    $('#paiementMontant').val(paiement.montant);
                    $('#paiementTotal').val(paiement.montant_total);
                    
                    let datePaiement = '';
                    if(paiement.date_paiement) {
                        datePaiement = paiement.date_paiement.includes('T') 
                            ? paiement.date_paiement.split('T')[0] 
                            : paiement.date_paiement;
                    }
                    $('#paiementDate').val(datePaiement);
                    
                    $('#paiementDescription').val(paiement.description || '');
                    modal.removeClass('hidden');
                } else {
                    alert('Erreur: ' + response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Erreur lors du chargement des données. Voir la console pour plus de détails.');
            }
        });
    };

    window.showPaiementDetails = function(id) {
        $.ajax({
            url: `/admin/paiements/${id}/details`,
            method: 'GET',
            success: function(data) {
                $('#detailPaiementContent').html(data);
                $('#detailPaiementModal').removeClass('hidden');
            },
            error: function(xhr) {
                alert('Erreur lors du chargement des détails: ' + xhr.responseJSON?.message);
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

    $('#cancelPaiementBtn').click(function() {
        modal.addClass('hidden');
    });

    form.on('submit', function(e) {
        const montant = parseFloat($('#paiementMontant').val());
        const total = parseFloat($('#paiementTotal').val());
        
        if (montant > total) {
            alert('Le montant payé ne peut pas être supérieur au montant total');
            e.preventDefault();
        }
    });
});
</script>
@endsection