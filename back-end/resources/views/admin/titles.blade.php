@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-auto bg-gray-50 p-4 md:p-6">
    <header class="bg-[#4D44B5] text-white shadow-md rounded-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
            <h1 class="text-xl sm:text-2xl font-bold text-center sm:text-left">Gestion des Titres de Cours</h1>
            <button id="newTitleBtn"
                class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition w-full sm:w-auto">
                <i class="fas fa-plus mr-2"></i> Nouveau Titre
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 bg-white p-4 rounded-lg shadow-sm gap-4">
            <nav class="flex flex-wrap gap-2 bg-gray-100 p-1.5 rounded-lg w-full lg:w-auto">
                <a href="{{ route('admin.titles', ['tab' => 'titles']) }}"
                   class="px-3 py-1.5 rounded-md font-medium text-sm transition-all duration-200 flex items-center justify-center flex-grow sm:flex-grow-0
                          {{ request('tab', 'titles') === 'titles' ? 'bg-[#4D44B5] text-white shadow-sm' : 'text-gray-600 hover:text-[#4D44B5] hover:bg-gray-200' }}">
                    <i class="fas fa-list mr-1.5"></i> Mes Titres
                </a>
                <a href="{{ route('admin.titles', ['tab' => 'progress']) }}"
                   class="px-3 py-1.5 rounded-md font-medium text-sm transition-all duration-200 flex items-center justify-center flex-grow sm:flex-grow-0
                          {{ request('tab') === 'progress' ? 'bg-[#4D44B5] text-white shadow-sm' : 'text-gray-600 hover:text-[#4D44B5] hover:bg-gray-200' }}">
                    <i class="fas fa-chart-line mr-1.5"></i> Progression
                </a>
            </nav>

            <form action="{{ route('admin.titles') }}" method="GET" class="relative w-full lg:w-auto lg:max-w-[280px]">
                <input type="hidden" name="tab" value="{{ request('tab', 'titles') }}">
                <div class="relative w-full">
                    <input type="text" name="search" placeholder="Rechercher un titre..."
                           value="{{ request('search') }}"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition duration-150 ease-in-out">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </form>
        </div>

        @if(request('tab', 'titles') === 'titles')
            @if($titles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($titles as $title)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                    <div class="p-5 sm:p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 bg-purple-100 text-[#4D44B5] text-xs font-semibold rounded-full mb-2">
                                    Permis {{ $title->type_permis }}
                                </span>
                                <a href="{{ route('admin.courses' , $title->id)}}" class="block hover:text-[#4D44B5] transition">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 leading-tight">{{ $title->name }}</h3>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-5">
                            <span class="flex items-center">
                                <i class="fas fa-book-open mr-1.5 text-gray-400"></i> {{ $title->courses_count }} cours
                            </span>
                        </div>
                    </div>

                    <div class="px-5 sm:px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-wrap justify-between items-center gap-2">
                        <a href="{{ route('admin.progress', $title) }}"
                           class="text-purple-600 hover:text-purple-800 text-sm font-medium flex items-center">
                            <i class="fas fa-chart-line mr-1.5"></i> Progression
                        </a>
                        <div class="flex space-x-1">
                            <button onclick="openEditModal('{{ $title->id }}', '{{ $title->type_permis }}', '{{ addslashes($title->name) }}')"
                                    title="Modifier"
                                    class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-100 transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.titles.destroy', $title) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this.form)"
                                        title="Supprimer"
                                        class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-100 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center border border-gray-100">
                <i class="fas fa-book-open text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-700 mb-2">
                    Aucun titre de cours trouvé
                </h3>
                <p class="text-gray-500 mb-4">Commencez par ajouter un nouveau titre.</p>
                <button id="newTitleBtnEmpty"
                    class="bg-[#4D44B5] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition">
                    <i class="fas fa-plus mr-2"></i> Ajouter un Titre
                </button>
            </div>
            @endif
        @else
            @if($titles->count() > 0)
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Progression des Candidats par Titre</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidats Inscrits</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression Globale</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($titles as $title)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-0">
                                            <div class="text-sm font-medium text-gray-900">{{ $title->name }}</div>
                                            <div class="text-xs text-gray-500">Permis {{ $title->type_permis }}</div>
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
                                        {{ $candidateCount }} candidat{{ $candidateCount !== 1 ? 's' : '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $totalCourses = $title->courses()->count();
                                        $totalViews = $title->views()->count();
                                        $totalPossibleViews = $totalCourses * $candidateCount;
                                        $percentage = $totalPossibleViews > 0 ? round(($totalViews / $totalPossibleViews) * 100) : 0;
                                    @endphp
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-[#4D44B5] h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600 font-medium">{{ $percentage }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.progress', $title) }}"
                                       class="text-[#4D44B5] hover:text-[#3a32a1] flex items-center">
                                        <i class="fas fa-eye mr-1.5"></i> Voir détails
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center border border-gray-100">
                <i class="fas fa-chart-line text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-700 mb-2">
                    Aucune donnée de progression disponible
                </h3>
                <p class="text-gray-500">
                    Soit il n'y a pas de titres, soit les candidats n'ont pas encore commencé les cours associés.
                </p>
            </div>
            @endif
        @endif

    
    </main>
</div>

<div id="titleModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4 hidden transition-opacity duration-300 ease-out" style="opacity: 0;">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg transform transition-transform duration-300 ease-out scale-95" style="transform: scale(0.95);">
        <form id="titleForm" method="POST" action="{{ route('admin.titles.store') }}" class="flex flex-col">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">
            <input type="hidden" id="titleId" name="id">

            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 id="modalTitle" class="text-lg font-semibold text-gray-800">Nouveau Titre</h2>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition rounded-full p-1 -mr-2">
                        <i class="fas fa-times fa-lg"></i>
                    </button>
                </div>
            </div>

            <div class="p-6 space-y-4 flex-grow overflow-y-auto">
                <div>
                    <label for="titleName" class="block text-sm font-medium text-gray-700 mb-1">Nom du Titre <span class="text-red-500">*</span></label>
                    <input type="text" id="titleName" name="name" maxlength="255" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition duration-150 ease-in-out"
                           placeholder="Ex: Code de la route général">
                    <p id="nameError" class="text-red-600 text-xs mt-1 hidden h-4"></p>
                </div>

                <div>
                    <label for="titlePermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis associé <span class="text-red-500">*</span></label>
                    <select id="titlePermisType" name="type_permis" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition duration-150 ease-in-out bg-white appearance-none">
                        <option value="" disabled selected>-- Sélectionnez un type --</option>
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
                    <p id="type_permisError" class="text-red-600 text-xs mt-1 hidden h-4"></p>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Annuler
                </button>
                <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition font-medium flex items-center justify-center">
                    <span id="submitBtnText">Enregistrer</span>
                    <i id="submitSpinner" class="fas fa-spinner fa-spin ml-2 hidden"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const titleModal = document.getElementById('titleModal');
    const titleModalDialog = titleModal.querySelector('.bg-white');
    const titleForm = document.getElementById('titleForm');
    const modalTitle = document.getElementById('modalTitle');
    const formMethodInput = document.getElementById('formMethod');
    const titleIdInput = document.getElementById('titleId');
    const titleNameInput = document.getElementById('titleName');
    const titlePermisTypeInput = document.getElementById('titlePermisType');
    const nameError = document.getElementById('nameError');
    const typePermisError = document.getElementById('type_permisError');
    const newTitleButtons = document.querySelectorAll('#newTitleBtn, #newTitleBtnEmpty');
    const submitBtn = document.getElementById('submitBtn');
    const submitBtnText = document.getElementById('submitBtnText');
    const submitSpinner = document.getElementById('submitSpinner');

    function openModal() {
        titleModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        requestAnimationFrame(() => {
            titleModal.style.opacity = '1';
            titleModalDialog.style.transform = 'scale(1)';
        });
    }

    function closeModal() {
        document.body.classList.remove('overflow-hidden');
        titleModal.style.opacity = '0';
        titleModalDialog.style.transform = 'scale(0.95)';
        setTimeout(() => {
            titleModal.classList.add('hidden');
            resetForm();
        }, 300);
    }

    function resetForm() {
        titleForm.reset();
        formMethodInput.value = 'POST';
        titleIdInput.value = '';
        modalTitle.textContent = 'Nouveau Titre';
        titleForm.action = "{{ route('admin.titles.store') }}";
        nameError.textContent = '';
        nameError.classList.add('hidden');
        titleNameInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        typePermisError.textContent = '';
        typePermisError.classList.add('hidden');
        titlePermisTypeInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        submitBtn.disabled = false;
        submitBtnText.textContent = 'Enregistrer';
        submitSpinner.classList.add('hidden');
    }

    newTitleButtons.forEach(button => {
        button.addEventListener('click', () => {
            resetForm();
            openModal();
        });
    });


    window.openEditModal = function(id, permisType, name) {
        resetForm();
        modalTitle.textContent = 'Modifier Titre';
        formMethodInput.value = 'PUT';
        titleIdInput.value = id;
        titleNameInput.value = name;
        titlePermisTypeInput.value = permisType;
        titleForm.action = "{{ url('admin/titles') }}/" + id;
        openModal();
    };

    function confirmDelete(form) {
        if (confirm('Voulez-vous vraiment supprimer ce titre ? Cette action supprimera également tous les cours associés.')) {
            form.submit();
        }
    }

    function validateForm() {
        let isValid = true;
        nameError.textContent = '';
        nameError.classList.add('hidden');
        titleNameInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        typePermisError.textContent = '';
        typePermisError.classList.add('hidden');
        titlePermisTypeInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');

        if (!titleNameInput.value || titleNameInput.value.trim() === '') {
            nameError.textContent = 'Le nom du titre est requis.';
            nameError.classList.remove('hidden');
            titleNameInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            isValid = false;
        } else if (titleNameInput.value.length > 255) {
             nameError.textContent = 'Le nom ne doit pas dépasser 255 caractères.';
             nameError.classList.remove('hidden');
             titleNameInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
             isValid = false;
        }

        if (!titlePermisTypeInput.value) {
            typePermisError.textContent = 'Veuillez sélectionner un type de permis.';
            typePermisError.classList.remove('hidden');
            titlePermisTypeInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            isValid = false;
        }

        return isValid;
    }

    titleForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        submitBtn.disabled = true;
        submitBtnText.textContent = 'Enregistrement...';
        submitSpinner.classList.remove('hidden');

        const formData = new FormData(this);
        const url = this.action;
        const method = formMethodInput.value === 'PUT' ? 'PUT' : 'POST';

        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200 || status === 201) {
                if (body.success) {
                    window.location.reload();
                } else {
                    alert(body.message || 'Une erreur inattendue est survenue.');
                    resetSubmitButton();
                }
            } else if (status === 422) {
                const errors = body.errors;
                for (const field in errors) {
                    const errorElement = document.getElementById(`${field}Error`);
                    const inputElement = document.getElementById(field === 'name' ? 'titleName' : 'titlePermisType');
                    if (errorElement && inputElement) {
                        errorElement.textContent = errors[field][0];
                        errorElement.classList.remove('hidden');
                        inputElement.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                    }
                }
                resetSubmitButton();
            } else {
                alert(body.message || `Une erreur est survenue (Status: ${status})`);
                resetSubmitButton();
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            alert('Une erreur de communication est survenue.');
            resetSubmitButton();
        });
    });

    function resetSubmitButton() {
        submitBtn.disabled = false;
        submitBtnText.textContent = 'Enregistrer';
        submitSpinner.classList.add('hidden');
    }

    titleModal.addEventListener('click', function(e) {
        if (e.target === titleModal) {
            closeModal();
        }
    });

    document.addEventListener('keyup', function(e) {
        if (e.key === "Escape" && !titleModal.classList.contains('hidden')) {
            closeModal();
        }
    });

</script>
@endsection