@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gestion des Examens</h1>
            <button id="newExamBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-plus mr-2"></i> Nouvel Examen
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any()))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Examens</h2>
                <div class="relative">
                    <input type="text" id="examSearch" placeholder="Rechercher..." 
                        class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($exams as $exam)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($exam->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $exam->date_exam->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $exam->lieu }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($exam->candidat)
                                    <div class="font-medium text-[#4D44B5]">{{ $exam->candidat->prenom }} {{ $exam->candidat->nom }}</div>
                                @else
                                    <span class="text-gray-500">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $exam->statut === 'planifie' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($exam->statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : 
                                       ($exam->statut === 'termine' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $exam->statut)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="openEditModal(
                                    '{{ $exam->id }}',
                                    '{{ $exam->type }}',
                                    '{{ $exam->date_exam->format('Y-m-d\TH:i') }}',
                                    '{{ $exam->lieu }}',
                                    '{{ $exam->places_max }}',
                                    '{{ $exam->candidat_id }}',
                                    '{{ $exam->instructions }}',
                                    '{{ $exam->statut }}'
                                )" class="text-[#4D44B5] hover:text-[#3a32a1] mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                @if($exam->candidat)
                                <button onclick="openResultModal(
                                    '{{ $exam->id }}',
                                    '{{ $exam->candidat_id }}',
                                    '{{ $exam->candidat->prenom }} {{ $exam->candidat->nom }}',
                                    '{{ $exam->type }}',
                                    '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                    '{{ $exam->lieu }}'
                                )" class="text-green-500 hover:text-green-700 mr-3">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                @endif
                                
                                <button onclick="openDetailsModal(
                                    '{{ $exam->id }}',
                                    '{{ $exam->type }}',
                                    '{{ $exam->date_exam->format('d/m/Y H:i') }}',
                                    '{{ $exam->lieu }}',
                                    '{{ $exam->places_max }}',
                                    '{{ $exam->statut }}',
                                    '{{ $exam->candidat ? $exam->candidat->prenom . ' ' . $exam->candidat->nom : 'Non assigné' }}',
                                    '{{ $exam->instructions }}',
                                    '{{ optional($exam->participants->first()->pivot)->score ?? '' }}',
                                    '{{ optional($exam->participants->first()->pivot)->resultat ?? '' }}',
                                    '{{ optional($exam->participants->first()->pivot)->feedbacks ?? '' }}',
                                    '{{ optional($exam->participants->first()->pivot)->present ?? '' }}'
                                )" class="text-purple-500 hover:text-purple-700 mr-3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?')"
                                        class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucun examen programmé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $exams->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

   
    </div>

    <!-- Modal pour saisir les résultats -->
  
    </div>

    <!-- Modal optimisé pour afficher les détails et résultats -->
 
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

</script>
@endsection