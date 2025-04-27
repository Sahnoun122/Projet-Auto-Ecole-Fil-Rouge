@extends('layouts.candidats')
@section('title', 'Mes Paiements')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold">Mes Paiements</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Historique des Paiements</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 border-b">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-800">Total Payé</h3>
                    <p class="text-2xl font-bold">{{ number_format($totalPaye, 2) }} DH</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-green-800">Montant Total</h3>
                    <p class="text-2xl font-bold">{{ number_format($montantTotal, 2) }} DH</p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-amber-800">Reste à Payer</h3>
                    <p class="text-2xl font-bold">{{ number_format($montantRestant, 2) }} DH</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($paiements as $paiement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($paiement->montant, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $paiement->description ?? 'Aucune description' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                               
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun paiement enregistré
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($paiements->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $paiements->links() }}
            </div>
            @endif
        </div>
    </main>

   
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


</script>
@endsection