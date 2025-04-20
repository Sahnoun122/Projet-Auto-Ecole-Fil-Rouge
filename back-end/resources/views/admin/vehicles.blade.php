@extends('layouts.admin')
@section('content')
            <div class="flex-1 overflow-auto">
                <header class="bg-[#4D44B5] text-white shadow-md">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                        <h1 class="text-2xl font-bold">Gestion des Véhicules</h1>
                        <button id="newVehicleBtn"
                            class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                            <i class="fas fa-plus mr-2"></i> Nouveau Véhicule
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
                            <h2 class="text-xl font-semibold text-gray-800">Liste des Véhicules</h2>
                            <button id="maintenanceAlertsBtn"
                                class="bg-[#FF4550] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#E03E48] transition">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Alertes Maintenance
                            </button>
                        </div>
            
                        <div class="overflow-x-auto">
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
                                    <tr>
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
                    </div>
                </main>
            
                <div id="vehicleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white w-full max-w-md p-6 rounded-lg">
                        <h2 id="modalVehicleTitle" class="text-lg font-bold mb-4">Nouveau Véhicule</h2>
                        <form id="vehicleForm" method="POST">
                            @csrf
                            <input type="hidden" id="vehicleId" name="id">
                            <input type="hidden" id="_method" name="_method" value="POST">
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label for="vehicleMarque" class="block text-sm font-medium text-gray-700 mb-1">Marque *</label>
                                    <input type="text" id="vehicleMarque" name="marque" maxlength="50"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="vehicleModele" class="block text-sm font-medium text-gray-700 mb-1">Modèle *</label>
                                    <input type="text" id="vehicleModele" name="modele" maxlength="50"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
                            </div>
            
                            <div class="mb-4">
                                <label for="vehicleImmatriculation" class="block text-sm font-medium text-gray-700 mb-1">Immatriculation *</label>
                                <input type="text" id="vehicleImmatriculation" name="immatriculation" maxlength="20"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            </div>
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label for="vehicleDateAchat" class="block text-sm font-medium text-gray-700 mb-1">Date d'achat *</label>
                                    <input type="date" id="vehicleDateAchat" name="date_achat"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="vehicleKilometrage" class="block text-sm font-medium text-gray-700 mb-1">Kilométrage *</label>
                                    <input type="number" id="vehicleKilometrage" name="kilometrage" min="0"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
                            </div>
            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label for="vehicleProchaineMaintenance" class="block text-sm font-medium text-gray-700 mb-1">Prochaine maintenance *</label>
                                    <input type="date" id="vehicleProchaineMaintenance" name="prochaine_maintenance"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="vehicleStatut" class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                                    <select id="vehicleStatut" name="statut" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                        <option value="disponible">Disponible</option>
                                        <option value="en maintenance">En maintenance</option>
                                        <option value="hors service">Hors service</option>
                                    </select>
                                </div>
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
            
                <!-- Maintenance Alerts Modal -->
                <div id="maintenanceAlertsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    {{-- <div class="bg-white w-full max-w-md p-6 rounded-lg">
                        <h2 class="text-lg font-bold mb-4">Alertes de Maintenance</h2>
                        <div id="alertsContent">
                            @forelse ($alerts as $alert)
                            <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded mb-3">
                                <h4 class="font-medium text-red-800">{{ $alert->marque }} {{ $alert->modele }}</h4>
                                <p class="text-sm text-red-600">{{ $alert->immatriculation }}</p>
                                <p class="text-sm text-red-600">Maintenance prévue: {{ $alert->prochaine_maintenance->format('d/m/Y') }}</p>
                            </div>
                            @empty
                            <p class="text-center text-gray-500 py-4">Aucune alerte de maintenance</p>
                            @endforelse
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" id="closeAlertsBtn"
                                class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div> --}}
            </div>
            
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            $(document).ready(function() {
                // Gestion de la modale de création
                $('#newVehicleBtn').click(function() {
                    $('#modalVehicleTitle').text('Nouveau Véhicule');
                    $('#vehicleForm').attr('action', "{{ route('admin.vehicles.store') }}");
                    $('#_method').val('POST');
                    $('#vehicleId').val('');
                    $('#vehicleForm')[0].reset();
                    $('#vehicleProchaineMaintenance').attr('min', new Date().toISOString().split('T')[0]);
                    $('#vehicleModal').removeClass('hidden');
                });
            
                // Gestion de la modale d'édition
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
            
                // Fermer les modales
                $('#cancelBtn, #closeAlertsBtn').click(function() {
                    $('#vehicleModal, #maintenanceAlertsModal').addClass('hidden');
                });
            
                // Ouvrir la modale des alertes
                $('#maintenanceAlertsBtn').click(function() {
                    $('#maintenanceAlertsModal').removeClass('hidden');
                });
            
                // Validation avant soumission
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