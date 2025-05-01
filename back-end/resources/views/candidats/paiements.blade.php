@extends('layouts.candidats')
@section('title', 'Mes Paiements')

@section('content')
<div class="flex-1 overflow-auto bg-gray-50 p-4 md:p-6 lg:p-8">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold">Mes Paiements</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="mr-4 p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-file-invoice-dollar text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Montant Total</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($montantTotal, 2) }} DH</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="mr-4 p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Payé</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPaye, 2) }} DH</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center shadow-sm hover:shadow-md transition-shadow duration-300">
                 <div class="mr-4 p-3 rounded-full {{ $montantRestant > 0 ? 'bg-amber-100 text-amber-600' : 'bg-green-100 text-green-600' }}">
                    <i class="fas {{ $montantRestant > 0 ? 'fa-hourglass-half' : 'fa-check-double' }} text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Reste à Payer</h3>
                    <p class="text-2xl font-bold {{ $montantRestant > 0 ? 'text-amber-700' : 'text-green-700' }}">{{ number_format($montantRestant, 2) }} DH</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Historique des Paiements</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($paiements as $paiement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($paiement->montant, 2) }} DH</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($paiement->date_paiement)->isoFormat('LL') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $paiement->description }}">
                                {{ $paiement->description ?? '-' }}
                            </td>
                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                 <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Effectué
                                </span>
                             </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-receipt text-gray-300 text-5xl mb-4"></i>
                                    <span class="text-gray-500 text-lg">Aucun paiement enregistré pour le moment.</span>
                                    <p class="text-gray-400 mt-1">Vos paiements apparaîtront ici dès qu'ils seront ajoutés.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($paiements->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $paiements->links() }}
            </div>
            @endif
        </div>
    </main>
</div>
@endsection