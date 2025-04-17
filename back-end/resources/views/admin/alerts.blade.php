@forelse ($alerts as $vehicle)
    <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded mb-3">
        <h4 class="font-medium text-red-800">{{ $vehicle->marque }} {{ $vehicle->modele }}</h4>
        <p class="text-sm text-red-600">{{ $vehicle->immatriculation }}</p>
        <p class="text-sm text-red-600">Maintenance prévue: {{ $vehicle->prochaine_maintenance->format('d/m/Y') }}</p>
    </div>
@empty
    <p class="text-center text-gray-500 py-4">Aucune alerte de maintenance</p>
@endforelse