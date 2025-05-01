@extends('layouts.admin')
@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-xl md:text-2xl font-bold">Gestion des Véhicules</h1>
                <button id="newVehicleBtn"
                    class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 hover:shadow-sm transition-all duration-300 flex items-center w-max">
                    <i class="fas fa-plus mr-2"></i> Nouveau Véhicule
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="mb-6" id="maintenanceAlertsSection">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-exclamation-triangle text-[#FF4550] mr-2"></i> 
                        Alertes de Maintenance
                    </h2>
                    <button id="toggleAlertsBtn" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                        <i class="fas fa-chevron-down"></i> Afficher les alertes
                    </button>
                </div>
                
                <div id="alertsContent" class="hidden p-4 divide-y divide-gray-100">
                    @php
                        $maintenanceAlerts = $vehicles->filter(function($vehicle) {
                            return $vehicle->prochaine_maintenance <= now()->addDays(7);
                        })->sortBy('prochaine_maintenance');
                    @endphp
                    
                    @forelse ($maintenanceAlerts as $vehicle)
                    <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded my-2">
                        <h4 class="font-medium text-red-800">{{ $vehicle->marque }} {{ $vehicle->modele }}</h4>
                        <p class="text-sm text-red-600">{{ $vehicle->immatriculation }}</p>
                        <p class="text-sm text-red-600">Maintenance prévue: {{ $vehicle->prochaine_maintenance->format('d/m/Y') }}</p>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-4">Aucune alerte de maintenance</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Liste des Véhicules</h2>
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marque/Modèle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Immatriculation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Achat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kilométrage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prochaine Maintenance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($vehicles as $vehicle)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-[#4D44B5]">{{ $vehicle->marque }} {{ $vehicle->modele }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $vehicle->immatriculation }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $vehicle->date_achat->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ number_format($vehicle->kilometrage, 0, ',', ' ') }} km
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap @if($vehicle->prochaine_maintenance <= now()->addDays(7)) text-red-500 font-medium @endif">
                                {{ $vehicle->prochaine_maintenance->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($vehicle->statut === 'disponible') bg-green-100 text-green-800
                                    @elseif($vehicle->statut === 'en maintenance') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($vehicle->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="openEditModal(
                                    '{{ $vehicle->id }}',
                                    '{{ $vehicle->marque }}',
                                    '{{ $vehicle->modele }}',
                                    '{{ $vehicle->immatriculation }}',
                                    '{{ $vehicle->date_achat->format('Y-m-d') }}',
                                    '{{ $vehicle->kilometrage }}',
                                    '{{ $vehicle->prochaine_maintenance->format('Y-m-d') }}',
                                    '{{ $vehicle->statut }}'
                                )" class="text-[#4D44B5] hover:text-[#3a32a1] mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')"
                                        class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Aucun véhicule disponible
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-gray-200">
                @forelse ($vehicles as $vehicle)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-[#4D44B5]">{{ $vehicle->marque }} {{ $vehicle->modele }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $vehicle->immatriculation }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($vehicle->statut === 'disponible') bg-green-100 text-green-800
                            @elseif($vehicle->statut === 'en maintenance') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($vehicle->statut) }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <div>
                            <p class="text-xs text-gray-500">Date achat</p>
                            <p class="text-sm">{{ $vehicle->date_achat->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kilométrage</p>
                            <p class="text-sm">{{ number_format($vehicle->kilometrage, 0, ',', ' ') }} km</p>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <p class="text-xs text-gray-500">Prochaine maintenance</p>
                        <p class="text-sm @if($vehicle->prochaine_maintenance <= now()->addDays(7)) text-red-500 font-medium @endif">
                            {{ $vehicle->prochaine_maintenance->format('d/m/Y') }}
                        </p>
                    </div>
                    
                    <div class="mt-3 flex justify-end space-x-3">
                        <button onclick="openEditModal(
                            '{{ $vehicle->id }}',
                            '{{ $vehicle->marque }}',
                            '{{ $vehicle->modele }}',
                            '{{ $vehicle->immatriculation }}',
                            '{{ $vehicle->date_achat->format('Y-m-d') }}',
                            '{{ $vehicle->kilometrage }}',
                            '{{ $vehicle->prochaine_maintenance->format('Y-m-d') }}',
                            '{{ $vehicle->statut }}'
                        )" class="text-[#4D44B5] hover:text-[#3a32a1]">
                            <i class="fas fa-edit"></i> Modifier
                        </button>
                        <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')"
                                class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="px-4 py-6 text-center text-gray-500">
                    Aucun véhicule disponible
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <div id="vehicleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-xl p-6 rounded-lg">
            <h2 id="modalVehicleTitle" class="text-xl font-bold mb-5">Nouveau Véhicule</h2>
            <form id="vehicleForm" method="POST">
                @csrf
                <input type="hidden" id="vehicleId" name="id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="vehicleMarque" class="block text-sm font-medium text-gray-700 mb-1">Marque *</label>
                        <input type="text" id="vehicleMarque" name="marque" maxlength="50"
                            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                    </div>

                    <div class="mb-4">
                        <label for="vehicleModele" class="block text-sm font-medium text-gray-700 mb-1">Modèle *</label>
                        <input type="text" id="vehicleModele" name="modele" maxlength="50"
                            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="vehicleImmatriculation" class="block text-sm font-medium text-gray-700 mb-1">Immatriculation *</label>
                    <input type="text" id="vehicleImmatriculation" name="immatriculation" maxlength="20"
                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="vehicleDateAchat" class="block text-sm font-medium text-gray-700 mb-1">Date d'achat *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" id="vehicleDateAchat" name="date_achat"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="vehicleKilometrage" class="block text-sm font-medium text-gray-700 mb-1">Kilométrage *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tachometer-alt text-gray-400"></i>
                            </div>
                            <input type="number" id="vehicleKilometrage" name="kilometrage" min="0"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">km</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="vehicleProchaineMaintenance" class="block text-sm font-medium text-gray-700 mb-1">Prochaine maintenance *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tools text-gray-400"></i>
                            </div>
                            <input type="date" id="vehicleProchaineMaintenance" name="prochaine_maintenance"
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="vehicleStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-info-circle text-gray-400"></i>
                            </div>
                            <select id="vehicleStatut" name="statut" 
                                class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] outline-none appearance-none" required>
                                <option value="disponible">Disponible</option>
                                <option value="en maintenance">En maintenance</option>
                                <option value="hors service">Hors service</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelBtn"
                        class="px-5 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-5 py-2.5 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
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
    $('#newVehicleBtn').click(function() {
        $('#modalVehicleTitle').text('Nouveau Véhicule');
        $('#vehicleForm').attr('action', "{{ route('admin.vehicles.store') }}");
        $('#_method').val('POST');
        $('#vehicleId').val('');
        $('#vehicleForm')[0].reset();
        $('#vehicleProchaineMaintenance').attr('min', new Date().toISOString().split('T')[0]);
        $('#vehicleModal').removeClass('hidden');
    });

    window.openEditModal = function(id, marque, modele, immatriculation, dateAchat, kilometrage, prochaineMaintenance, statut) {
        $('#modalVehicleTitle').text('Modifier Véhicule');
        $('#vehicleForm').attr('action', "{{ route('admin.vehicles.update', '') }}/" + id);
        $('#_method').val('PUT');
        $('#vehicleId').val(id);
        $('#vehicleMarque').val(marque);
        $('#vehicleModele').val(modele);
        $('#vehicleImmatriculation').val(immatriculation);
        $('#vehicleDateAchat').val(dateAchat);
        $('#vehicleKilometrage').val(kilometrage);
        $('#vehicleProchaineMaintenance').val(prochaineMaintenance);
        $('#vehicleStatut').val(statut);
        $('#vehicleModal').removeClass('hidden');
    };

    $('#cancelBtn').click(function() {
        $('#vehicleModal').addClass('hidden');
    });

    $('#toggleAlertsBtn').click(function() {
        $('#alertsContent').toggleClass('hidden');
        
        if($('#alertsContent').hasClass('hidden')) {
            $(this).html('<i class="fas fa-chevron-down"></i> Afficher les alertes');
        } else {
            $(this).html('<i class="fas fa-chevron-up"></i> Masquer les alertes');
        }
    });

    $('#vehicleForm').submit(function(e) {
        const today = new Date().toISOString().split('T')[0];
        const maintenanceDate = $('#vehicleProchaineMaintenance').val();
        
        if (maintenanceDate < today) {
            alert('La date de maintenance doit être aujourd\'hui ou ultérieure');
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>
@endsection