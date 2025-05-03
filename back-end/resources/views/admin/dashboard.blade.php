@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-semibold text-center md:text-left">Tableau de Bord Administrateur</h1>
        </div>
    </header>



    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8"> {{-- Changed to lg:grid-cols-4 --}}
        <!-- Total Candidats -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Candidats</h3>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($totalCandidats) }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                {{-- Optional: Add comparison --}}
                {{-- <div class="mt-4">
                    <span class="text-green-600 text-sm font-semibold">+{{ rand(5, 15) }}%</span>
                    <span class="text-gray-500 text-sm ml-2">vs mois dernier</span>
                </div> --}}
            </div>
        </div>

        <!-- Total Moniteurs -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Moniteurs Actifs</h3>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($totalMoniteurs) }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                 {{-- Optional: Add comparison --}}
            </div>
        </div>

        <!-- Total Véhicules -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Véhicules</h3>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($totalVehicles) }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
                 {{-- Optional: Add comparison --}}
            </div>
        </div>

      
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Column - Charts & Tables -->
        <div class="lg:col-span-2 space-y-6">


            <!-- Exam Results Distribution Chart - Redesigned -->
            <div class="max-w-full w-full bg-white rounded-xl shadow-sm dark:bg-gray-800 p-4 md:p-6 border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-2">Performance aux Examens</h5>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Répartition des résultats</p>
                    </div>
                    <div class="text-right">
                        <div class="leading-none text-3xl font-bold text-[#4D44B5] pb-2">{{ number_format($tauxReussite, 1) }}%</div>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Taux de réussite global</p>
                    </div>
                </div>
                {{-- Chart Canvas --}}
                <div class="py-6" id="exam-distribution-chart-container">
                    {{-- Use a canvas for Chart.js --}}
                    <canvas id="examResultsDistributionChart" height="250"></canvas>
                </div>
                {{-- Footer with Dropdown and Link --}}
                <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button
                            id="examResultsdDropdownButton" {{-- Changed ID --}}
                            data-dropdown-toggle="examResultsDropdown" {{-- Changed ID --}}
                            data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button">
                            Ce Mois
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="examResultsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="examResultsdDropdownButton">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">7 derniers jours</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ce Mois</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">3 derniers mois</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cette Année</a>
                                </li>
                            </ul>
                        </div>
                        <a
                            href="{{ route('admin.exams') }}" {{-- Link to exams index or report page --}}
                            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2">
                            Rapport d'Examens {{-- Changed text --}}
                            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Examens Table -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">Derniers Résultats d'Examens</h2>
                    <a href="{{ route('admin.exams') }}" class="text-sm text-indigo-600 hover:underline">Voir tout</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Résultat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($derniersExamens as $examen)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                                            {{ substr($examen->candidat->name ?? 'N/A', 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $examen->candidat->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $examen->candidat->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ucfirst($examen->type) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $examen->date_examen }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $resultat = $examen->result->resultat ?? 'indéfini';
                                        $badgeColor = [
                                            'excellent' => 'bg-green-100 text-green-800',
                                            'reussi' => 'bg-green-100 text-green-800',
                                            'bien' => 'bg-green-100 text-green-800',
                                            'echec' => 'bg-red-100 text-red-800',
                                            'insuffisant' => 'bg-red-100 text-red-800',
                                        ][strtolower($resultat)] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                        {{ ucfirst($resultat) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucun examen récent trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column - Alerts & Lists -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Paiements en Retard -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-red-50">
                    <h2 class="font-semibold text-red-800">Alertes Paiements en Retard</h2>
                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">{{ $paiementsEnRetard->count() }}</span>
                </div>
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto"> {{-- Added max-height and scroll --}}
                    @forelse($paiementsEnRetard as $paiement)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $paiement->candidat->name ?? 'Candidat inconnu' }}</p>
                                    <p class="text-sm text-red-600 font-medium">{{ number_format($paiement->montant_total - $paiement->montant, 2) }} DH</p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Échéance: {{ $paiement->date_paiement }}</p>
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-red-600 h-1.5 rounded-full" style="width: {{ ($paiement->montant / $paiement->montant_total) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucun paiement en retard
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Maintenances à Venir -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-yellow-50">
                    <h2 class="font-semibold text-yellow-800">Alertes Maintenances à Venir</h2>
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">{{ $maintenancesAVenir->count() }}</span>
                </div>
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto"> {{-- Added max-height and scroll --}}
                    @forelse($maintenancesAVenir as $vehicule)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $vehicule->marque }} {{ $vehicule->modele }}</p>
                                    <p class="text-xs font-medium {{ $vehicule->prochaine_maintenance->isToday() ? 'text-red-600' : 'text-yellow-600' }}">
                                        {{ $vehicule->prochaine_maintenance->isToday() ? 'Aujourd\'hui' : $vehicule->prochaine_maintenance->diffForHumans() }}
                                    </p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $vehicule->immatriculation }}</p>
                                <p class="text-xs text-gray-400 mt-1">Dernière maintenance: {{ $vehicule->derniere_maintenance }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucune maintenance prévue dans les 7 prochains jours
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Nouveaux Candidats -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">Nouveaux Candidats</h2>
                    <a href="{{ route('admin.candidats') }}" class="text-sm text-indigo-600 hover:underline">Voir tout</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($candidats as $candidat)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                                {{ substr($candidat->name, 0, 1) }}
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $candidat->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $candidat->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $candidat->email }}</p>
                                <p class="text-xs text-gray-400 mt-1">Inscrit le: {{ $candidat->created_at }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center text-gray-500">
                        Aucun nouveau candidat récemment
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- Monthly Registrations Chart (Line) ---
        const monthlyCtx = document.getElementById('monthlyRegistrationsChart');
        if (monthlyCtx) {
            const monthlyLabels = @json($labelsMonthlyRegistrations ?? []);
            const monthlyData = @json($monthlyRegistrationsData ?? []);

            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Inscriptions',
                        data: monthlyData,
                        borderColor: '#4D44B5',
                        backgroundColor: 'rgba(77, 68, 181, 0.1)',
                        fill: true,
                        tension: 0.3, // Makes the line slightly curved
                        pointBackgroundColor: '#4D44B5',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#4D44B5'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide legend for single dataset
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#4D44B5',
                            titleFont: { size: 14 },
                            bodyFont: { size: 12 },
                            padding: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb', // Light grid lines
                                drawBorder: false
                            },
                            ticks: {
                                // Ensure only integers are shown on the y-axis
                                callback: function(value) { if (Number.isInteger(value)) { return value; } },
                                stepSize: 1 // Adjust step size if needed based on data range
                            }
                        }
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            });
        }

        // --- Exam Results Distribution Chart (Pie) ---
        const examsCtx = document.getElementById('examResultsDistributionChart');
        if (examsCtx) {
            const examLabels = @json($labelsExamResults ?? []);
            const examData = @json($dataExamResults ?? []);

            // Define colors - add more if you have more result types
            const backgroundColors = [
                '#34D399', // Green (e.g., Réussi, Excellent)
                '#F87171', // Red (e.g., Échec)
                '#FBBF24', // Amber/Yellow
                '#60A5FA', // Blue
                '#A78BFA'  // Purple
            ];
            const hoverBackgroundColors = [
                '#10B981',
                '#EF4444',
                '#F59E0B',
                '#3B82F6',
                '#8B5CF6'
            ];

            new Chart(examsCtx, {
                type: 'pie', // Or 'doughnut'
                data: {
                    labels: examLabels.map(label => label.charAt(0).toUpperCase() + label.slice(1)), // Capitalize labels
                    datasets: [{
                        label: 'Nombre de Candidats',
                        data: examData,
                        backgroundColor: backgroundColors.slice(0, examData.length),
                        hoverBackgroundColor: hoverBackgroundColors.slice(0, examData.length),
                        borderColor: '#fff', // White border between segments
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom', // Position legend below chart
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                boxWidth: 15
                            }
                        },
                        tooltip: {
                            backgroundColor: '#4A5568', // Darker tooltip
                            titleFont: { size: 14 },
                            bodyFont: { size: 12 },
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

@endsection