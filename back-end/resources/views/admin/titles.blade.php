@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gestion des Titres de Cours</h1>
            <button id="newTitleBtn"
                class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                <i class="fas fa-plus mr-2"></i> Nouveau Titre
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 bg-white p-4 rounded-lg shadow gap-4 md:gap-0">
            <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg w-full md:w-auto">
                <a href="{{ route('admin.titles', ['tab' => 'titles']) }}" 
                   class="px-4 py-2 rounded-md font-medium text-sm transition-all duration-200
                          {{ request('tab', 'titles') === 'titles' ? 'bg-[#4D44B5] text-white' : 'text-gray-600 hover:text-[#4D44B5]' }}">
                    <i class="fas fa-list mr-1"></i> Mes Titres
                </a>
                <a href="{{ route('admin.titles', ['tab' => 'progress']) }}" 
                   class="px-4 py-2 rounded-md font-medium text-sm transition-all duration-200
                          {{ request('tab') === 'progress' ? 'bg-[#4D44B5] text-white' : 'text-gray-600 hover:text-[#4D44B5]' }}">
                    <i class="fas fa-chart-line mr-1"></i> Progression
                </a>
            </nav>
            
            <form action="{{ route('admin.titles') }}" method="GET" class="flex items-center w-full md:w-auto">
                <input type="hidden" name="tab" value="{{ request('tab', 'titles') }}">
                <div class="relative w-full">
                    <input type="text" name="search" placeholder="Rechercher..." 
                           value="{{ request('search') }}"
                           class="w-full md:w-64 pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </form>
        </div>

        @if(request('tab', 'titles') === 'titles')
            @if($titles->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($titles as $title)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 bg-purple-100 text-[#4D44B5] text-xs font-medium rounded-full mb-3">
                                    Permis {{ $title->type_permis }}
                                </span>
                                <a href="{{ route('admin.courses' , $title->id)}}"><h3 class="text-xl font-bold text-gray-800">{{ $title->name }}</h3>                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.courses', $title->id) }}" 
                                   class="text-[#4D44B5] hover:text-[#3a32a1] text-sm">
                                    <i class="fas fa-book-open mr-1"></i> {{ $title->courses_count }} cours
                                </a>
                                <a href="{{ route('admin.progress', $title) }}" 
                                   class="text-purple-600 hover:text-purple-800 text-sm">
                                    <i class="fas fa-chart-line mr-1"></i> Progression
                                </a>
                            </div>
                            
                            <div class="flex space-x-2">
                                <button onclick="openEditModal('{{ $title->id }}', '{{ $title->type_permis }}', '{{ addslashes($title->name) }}')"
                                    class="text-[#4D44B5] hover:text-[#3a32a1] p-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.titles.destroy', $title) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this.form)" 
                                            class="text-red-500 hover:text-red-700 p-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700">
                    Aucun titre disponible
                </h3>
            </div>
            @endif
        @else
            @if($titles->count() > 0)
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Progression des Candidats</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidats Inscrits</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression Globale</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($titles as $title)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $title->name }}</div>
                                            <div class="text-sm text-gray-500">Permis {{ $title->type_permis }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @php
                                            $candidateCount = App\Models\User::where('role', 'candidat')
                                                                            ->where('type_permis', $title->type_permis)
                                                                            ->count();
                                        @endphp
                                        {{ $candidateCount }} candidat{{ $candidateCount > 1 ? 's' : '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        @php
                                            $totalCourses = $title->courses()->count();
                                            $totalViews = $title->views()->count();
                                            $totalPossibleViews = $totalCourses * $candidateCount;
                                            $percentage = $totalPossibleViews ? round(($totalViews / $totalPossibleViews) * 100) : 0;
                                        @endphp
                                        <div class="bg-[#4D44B5] h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $percentage }}% complété</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.progress', $title) }}" 
                                       class="text-[#4D44B5] hover:text-[#3a32a1]">
                                        <i class="fas fa-eye mr-1"></i> Voir détails
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">
                    Aucune progression disponible
                </h3>
                <p class="text-gray-500">
                    Les candidats n'ont pas encore commencé les cours.
                </p>
            </div>
            @endif
        @endif
    </main>
</div>

<!-- Modal pour nouveau/modifier titre -->
<div id="titleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Nouveau Titre</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="titleForm" method="POST" action="{{ route('admin.titles.store') }}">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">
                <input type="hidden" id="titleId" name="id">
                
                <div class="mb-4">
                    <label for="titleName" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                    <input type="text" id="titleName" name="name" maxlength="255"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]">
                    <p id="nameError" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>
                
                <div class="mb-4">
                    <label for="titlePermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                    <select id="titlePermisType" name="type_permis" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5]">
                        <option value="">Sélectionnez un type</option>
                        <option value="A">Permis A (Moto)</option>
                        <option value="B">Permis B (Voiture)</option>
                        <option value="C">Permis C (Poids lourd)</option>
                        <option value="D">Permis D (Bus)</option>
                        <option value="EB">Permis EB (Remorque)</option>
                        <option value="A1">Permis A1 (Moto légère)</option>
                        <option value="A2">Permis A2 (Moto intermédiaire)</option>
                        <option value="B1">Permis B1 (Quadricycle lourd)</option>
                        <option value="C1">Permis C1 (Poids lourd moyen)</option>
                        <option value="D1">Permis D1 (Bus moyen)</option>
                        <option value="BE">Permis BE (Remorque lourde)</option>
                        <option value="C1E">Permis C1E (PL + remorque)</option>
                        <option value="D1E">Permis D1E (Bus + remorque)</option>
                    </select>
                    <p id="type_permisError" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openModal() {
        $('#titleModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    }
    
    function closeModal() {
        $('#titleModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        resetForm();
    }
    
    function resetForm() {
        $('#titleForm')[0].reset();
        $('#formMethod').val('POST');
        $('#titleId').val('');
        $('#modalTitle').text('Nouveau Titre');
        $('#titleForm').attr('action', "{{ route('admin.titles.store') }}");
        $('.text-red-500').addClass('hidden');
    }
    
    $('#newTitleBtn').click(function() {
        resetForm();
        openModal();
    });
    
    window.openEditModal = function(id, permisType, name) {
        resetForm();
        $('#modalTitle').text('Modifier Titre');
        $('#formMethod').val('PUT');
        $('#titleId').val(id);
        $('#titleName').val(name);
        $('#titlePermisType').val(permisType);
        $('#titleForm').attr('action', "{{ route('admin.titles.update', '') }}/" + id);
        openModal();
    };
    
    function confirmDelete(form) {
        if (confirm('Voulez-vous vraiment supprimer ce titre ?')) {
            form.submit();
        }
    }
    
    $('#titleForm').on('submit', function(e) {
        e.preventDefault();
        
        $('.text-red-500').addClass('hidden');
        
        const formData = $(this).serialize();
        const url = $(this).attr('action');
        const method = $('#formMethod').val() === 'PUT' ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        const errorElement = $(`#${field}Error`);
                        if (errorElement.length) {
                            errorElement.text(errors[field][0]);
                            errorElement.removeClass('hidden');
                        }
                    }
                } else {
                    alert('Une erreur est survenue: ' + xhr.responseJSON?.message);
                }
            }
        });
    });
    
    $(document).mouseup(function(e) {
        const modal = $('#titleModal');
        if (!modal.is(e.target) && modal.has(e.target).length === 0) {
            closeModal();
        }
    });
    
    $(document).keyup(function(e) {
        if (e.key === "Escape") {
            closeModal();
        }
    });
</script>
@endsection