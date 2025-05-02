@extends('layouts.moniteur')
@section('title', 'Véhicules Disponibles')
@section('content')
<div class="flex-1 overflow-auto p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Véhicules Disponibles</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-semibold text-gray-800 whitespace-nowrap">Liste des Véhicules (<span id="vehicleCount">{{ $vehicles->count() }}</span>)</h2>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <div class="flex flex-col w-full sm:w-auto">
                        <label for="filterMarque" class="text-sm font-medium text-gray-700 mb-1 sr-only">Marque</label>
                        <select id="filterMarque" class="p-2 border rounded-md text-sm focus:ring-[#4D44B5] focus:border-[#4D44B5] w-full" aria-label="Filtrer par marque">
                            <option value="">Toutes les marques</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="flex flex-col w-full sm:w-auto">
                        <label for="filterStatus" class="text-sm font-medium text-gray-700 mb-1 sr-only">Statut</label>
                        <select id="filterStatus" class="p-2 border rounded-md text-sm focus:ring-[#4D44B5] focus:border-[#4D44B5] w-full" aria-label="Filtrer par statut">
                            <option value="all">Tous les statuts</option>
                            <option value="disponible">Disponible</option>
                            <option value="en maintenance">En maintenance</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marque & Modèle</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Kilométrage</th> 
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Prochaine Maintenance</th> 
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="vehicleTableBody">
                        @forelse ($vehicles as $vehicle)
                        <tr class="vehicle-row hover:bg-gray-50 transition duration-150 ease-in-out"
                            data-id="{{ $vehicle->id }}"
                            data-marque="{{ $vehicle->marque }}"
                            data-statut="{{ $vehicle->statut }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $vehicle->marque }}</div>
                                <div class="text-sm text-gray-500">{{ $vehicle->modele }}</div>
                            </td>
                          
                            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell"> 
                                <div class="text-sm text-gray-900">{{ number_format($vehicle->kilometrage, 0, ',', ' ') }} km</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell @if($vehicle->prochaine_maintenance <= now()->addDays(7)) text-red-600 font-medium @else text-sm text-gray-900 @endif"> 
                                {{ $vehicle->prochaine_maintenance->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($vehicle->statut === 'disponible') bg-green-100 text-green-800
                                    @elseif($vehicle->statut === 'en maintenance') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($vehicle->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="showVehicleDetails({{ $vehicle->id }})" 
                                    class="text-[#4D44B5] hover:text-[#3a32a1] flex items-center text-sm p-1 rounded hover:bg-indigo-50 transition duration-150 ease-in-out"
                                    title="Voir les détails">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500"> 
                                Aucun véhicule disponible ou correspondant aux filtres
                            </td>
                        </tr>
                        @endforelse
                        <tr id="noResultsRow" class="hidden">
                             <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun véhicule ne correspond aux critères
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="vehicleDetailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center z-50 p-4 transition-opacity duration-300 ease-in-out">
        <div class="bg-white w-full max-w-lg rounded-lg overflow-hidden shadow-xl transform transition-all duration-300 ease-in-out scale-95 opacity-0" 
             id="modalContent">
            <div class="bg-[#4D44B5] text-white px-6 py-4 flex justify-between items-center">
                <h2 id="detailVehicleTitle" class="text-xl font-semibold"></h2>
                <button onclick="closeVehicleDetails()" class="text-white hover:text-gray-200 focus:outline-none text-xl" aria-label="Fermer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Marque</p>
                            <p id="detailMarque" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Modèle</p>
                            <p id="detailModele" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Immatriculation</p>
                            <p id="detailImmatriculation" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kilométrage</p>
                            <p id="detailKilometrage" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-500">Date d'achat</p>
                            <p id="detailDateAchat" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Prochaine maintenance</p>
                            <p id="detailMaintenance" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm font-medium text-gray-500">Statut</p>
                            <p id="detailStatut" class="inline-block px-3 py-1 rounded-full text-xs font-semibold mt-1"></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end border-t pt-4">
                    <button onclick="closeVehicleDetails()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-sm">
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
        marque: "{{ $vehicle->marque ?? 'N/A' }}",
        modele: "{{ $vehicle->modele ?? 'N/A' }}",
        immatriculation: "{{ $vehicle->immatriculation ?? 'N/A' }}",
        date_achat: "{{ $vehicle->date_achat ? $vehicle->date_achat->format('Y-m-d') : null }}", 
        kilometrage: {{ $vehicle->kilometrage ?? 0 }},
        prochaine_maintenance: "{{ $vehicle->prochaine_maintenance ? $vehicle->prochaine_maintenance->format('Y-m-d') : null }}",
        statut: "{{ $vehicle->statut ?? 'Inconnu' }}"
    },
    @endforeach
};

function filterVehicles() {
    const marque = $('#filterMarque').val();
    const status = $('#filterStatus').val();
    
    let visibleCount = 0;
    let hasVisibleRows = false;
    
    $('#vehicleTableBody .vehicle-row').each(function() {
        const vehicleMarque = $(this).data('marque');
        const vehicleStatus = $(this).data('statut');
        
        const marqueMatch = !marque || marque === '' || vehicleMarque === marque;
        const statusMatch = status === 'all' || vehicleStatus === status;
        
        const shouldShow = marqueMatch && statusMatch;
        if (shouldShow) {
            $(this).fadeIn(200);
            visibleCount++;
            hasVisibleRows = true;
        } else {
            $(this).fadeOut(200);
        }
    });
    
    $('#vehicleCount').text(visibleCount);
    
    setTimeout(() => {
        hasVisibleRows = $('#vehicleTableBody .vehicle-row:visible').length > 0;
        if (!hasVisibleRows) {
            $('#noResultsRow').removeClass('hidden');
        } else {
            $('#noResultsRow').addClass('hidden');
        }
    }, 250);
}

function showVehicleDetails(vehicleId) {
    const vehicle = vehiclesData[vehicleId];
    
    if (!vehicle) { 
        return; 
    }
    
    const formatDate = (dateStr) => {
        if (!dateStr) return 'N/A';
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return 'Date invalide'; 
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
    $('#detailKilometrage').text(vehicle.kilometrage ? vehicle.kilometrage.toLocaleString('fr-FR') + ' km' : 'N/A');
    $('#detailMaintenance').text(formatDate(vehicle.prochaine_maintenance));
    
    const statusElement = $('#detailStatut');
    const statusText = vehicle.statut.charAt(0).toUpperCase() + vehicle.statut.slice(1);
    statusElement.text(statusText);
    statusElement.removeClass().addClass('inline-block px-3 py-1 rounded-full text-xs font-semibold mt-1'); 
    
    if(vehicle.statut === 'disponible') {
        statusElement.addClass('bg-green-100 text-green-800');
    } else if(vehicle.statut === 'en maintenance') {
        statusElement.addClass('bg-yellow-100 text-yellow-800');
    } else {
        statusElement.addClass('bg-gray-100 text-gray-800');
    }

    const modal = $('#vehicleDetailsModal');
    const modalContent = $('#modalContent');
    
    modal.removeClass('hidden').css('opacity', 0);
    modalContent.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');

    requestAnimationFrame(() => {
        modal.css('opacity', '1');
        modalContent.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
    });
}

function closeVehicleDetails() {
    const modal = $('#vehicleDetailsModal');
    const modalContent = $('#modalContent');
    
    modalContent.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
    modal.css('opacity', '0');
    
    setTimeout(() => {
        modal.addClass('hidden');
    }, 300);
}


$(document).ready(function() {
    $('#filterMarque, #filterStatus').change(filterVehicles);

    filterVehicles(); 

    $('#vehicleDetailsModal').on('click', function(e) {
        if ($(e.target).is('#vehicleDetailsModal')) { 
            closeVehicleDetails();
        }
    });
    
    $(document).keyup(function(e) {
        if (e.key === "Escape" && !$('#vehicleDetailsModal').hasClass('hidden')) {
            closeVehicleDetails();
        }
    });
});
</script>
@endsection