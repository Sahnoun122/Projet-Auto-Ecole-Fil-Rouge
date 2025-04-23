@extends('layouts.moniteur')
@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold">Véhicules Disponibles</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtres</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex flex-col">
                        <label for="filterMarque" class="text-sm font-medium text-gray-700 mb-1">Marque</label>
                        <select id="filterMarque" class="max-w-xs p-2 border rounded-md text-sm focus:ring-[#4D44B5] focus:border-[#4D44B5]">
                            <option value="">Toutes les marques</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="flex flex-col">
                        <label for="filterStatus" class="text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="filterStatus" class="max-w-xs p-2 border rounded-md text-sm focus:ring-[#4D44B5] focus:border-[#4D44B5]">
                            <option value="all">Tous les statuts</option>
                            <option value="disponible">Disponible</option>
                            <option value="en maintenance">En maintenance</option>
                        </select>
                    </div>
                </div>
            </div>
        
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Véhicules</h2>
                <div class="text-sm text-gray-500">
                    <span id="vehicleCount">{{ $vehicles->count() }}</span> véhicule(s)
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kilométrage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prochaine Maintenance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="vehicleTableBody">
                        @forelse ($vehicles as $vehicle)
                        <tr class="vehicle-row" 
                            data-id="{{ $vehicle->id }}"
                            data-marque="{{ $vehicle->marque }}"
                            data-statut="{{ $vehicle->statut }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-[#4D44B5]">{{ $vehicle->marque }} {{ $vehicle->modele }}</div>
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
                                <button onclick="showVehicleDetails({{ $vehicle->id }})" 
                                    class="text-[#4D44B5] hover:text-[#3a32a1] flex items-center">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucun véhicule disponible
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="vehicleDetailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-lg overflow-hidden shadow-xl transform transition-all">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="detailVehicleTitle" class="text-xl font-bold"></h2>
                <button onclick="closeVehicleDetails()" class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Marque</p>
                            <p id="detailMarque" class="font-medium text-gray-800"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Modèle</p>
                            <p id="detailModele" class="font-medium text-gray-800"></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Immatriculation</p>
                            <p id="detailImmatriculation" class="font-medium text-gray-800"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kilométrage</p>
                            <p id="detailKilometrage" class="font-medium text-gray-800"></p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Date d'achat</p>
                        <p id="detailDateAchat" class="font-medium text-gray-800"></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Prochaine maintenance</p>
                        <p id="detailMaintenance" class="font-medium text-gray-800"></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Statut</p>
                        <p id="detailStatut" class="inline-block px-3 py-1 rounded-full text-sm font-medium mt-1"></p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button onclick="closeVehicleDetails()" 
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition focus:outline-none">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const vehiclesData = {
    @foreach($vehicles as $vehicle)
    {{ $vehicle->id }}: {
        marque: "{{ $vehicle->marque }}",
        modele: "{{ $vehicle->modele }}",
        immatriculation: "{{ $vehicle->immatriculation }}",
        date_achat: "{{ $vehicle->date_achat->format('Y-m-d') }}",
        kilometrage: {{ $vehicle->kilometrage }},
        prochaine_maintenance: "{{ $vehicle->prochaine_maintenance->format('Y-m-d') }}",
        statut: "{{ $vehicle->statut }}"
    },
    @endforeach
};

function filterVehicles() {
    const marque = $('#filterMarque').val();
    const status = $('#filterStatus').val();
    
    let visibleCount = 0;
    
    $('.vehicle-row').each(function() {
        const vehicleMarque = $(this).data('marque');
        const vehicleStatus = $(this).data('statut');
        
        const marqueMatch = !marque || marque === '' || vehicleMarque === marque;
        const statusMatch = status === 'all' || vehicleStatus === status;
        
        const shouldShow = marqueMatch && statusMatch;
        $(this).toggle(shouldShow);
        
        if (shouldShow) visibleCount++;
    });
    
    $('#vehicleCount').text(visibleCount);
    
    if (visibleCount === 0) {
        if ($('#noResultsRow').length === 0) {
            $('#vehicleTableBody').append(`
                <tr id="noResultsRow">
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Aucun véhicule ne correspond aux critères
                    </td>
                </tr>
            `);
        }
    } else {
        $('#noResultsRow').remove();
    }
}

function showVehicleDetails(vehicleId) {
    const vehicle = vehiclesData[vehicleId];
    if (!vehicle) return;
    
    const formatDate = (dateStr) => {
        const date = new Date(dateStr);
        return date.toLocaleDateString('fr-FR', { 
            day: '2-digit', 
            month: '2-digit', 
            year: 'numeric' 
        });
    };
    
    $('#detailVehicleTitle').text(`${vehicle.marque} ${vehicle.modele}`);
    $('#detailMarque').text(vehicle.marque);
    $('#detailModele').text(vehicle.modele);
    $('#detailImmatriculation').text(vehicle.immatriculation);
    $('#detailDateAchat').text(formatDate(vehicle.date_achat));
    $('#detailKilometrage').text(vehicle.kilometrage.toLocaleString('fr-FR') + ' km');
    $('#detailMaintenance').text(formatDate(vehicle.prochaine_maintenance));
    
    const statusElement = $('#detailStatut');
    statusElement.text(vehicle.statut.charAt(0).toUpperCase() + vehicle.statut.slice(1));
    statusElement.removeClass().addClass('inline-block px-3 py-1 rounded-full text-sm font-medium mt-1');
    
    if(vehicle.statut === 'disponible') {
        statusElement.addClass('bg-green-100 text-green-800');
    } else if(vehicle.statut === 'en maintenance') {
        statusElement.addClass('bg-yellow-100 text-yellow-800');
    } else {
        statusElement.addClass('bg-red-100 text-red-800');
    }

    $('#vehicleDetailsModal').removeClass('hidden');
}

function closeVehicleDetails() {
    $('#vehicleDetailsModal').addClass('hidden');
}

$(document).ready(function() {
    $('#filterMarque, #filterStatus').change(filterVehicles);

    $('#resetFilters').click(function() {
        $('#filterMarque').val('');
        $('#filterStatus').val('all');
        filterVehicles();
    });
    
    $(document).on('click', function(e) {
        if ($(e.target).is('#vehicleDetailsModal')) {
            closeVehicleDetails();
        }
    });
    
    $(document).keyup(function(e) {
        if (e.key === "Escape" && $('#vehicleDetailsModal').is(':visible')) {
            closeVehicleDetails();
        }
    });
});
</script>
@endsection