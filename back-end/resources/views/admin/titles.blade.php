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
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
            
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800">Mes Titres</h2>
                        </div>
            
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                            @forelse ($titles as $title)
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="inline-block px-2 py-1 bg-[#4D44B5] text-white text-xs rounded-full mb-2">
                                            Permis {{ $title->type_permis }}
                                        </span>
                                        <h3 class="text-lg font-semibold text-[#4D44B5]">
                                            <a href="{{ route('admin.courses', $title->id) }}">{{ $title->name }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-2">{{ $title->courses_count }} cours</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="handleEditTitle('{{ $title->id }}', '{{ $title->type_permis }}', '{{ $title->name }}')"
                                            class="text-[#4D44B5] hover:text-[#3a32a1] p-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="handleDeleteTitle('{{ $title->id }}')"
                                            class="text-red-500 hover:text-red-700 p-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">Aucun titre disponible</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </main>
            
                <!-- Modal -->
                <div id="titleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white w-full max-w-md p-6 rounded-lg">
                        <h2 id="modalTitle" class="text-lg font-bold mb-4">Nouveau Titre</h2>
                        <form id="titleForm" method="POST">
                            @csrf
                            <input type="hidden" id="titleId" name="id">
                            <input type="hidden" id="_method" name="_method" value="POST">
            
                            <div class="mb-4">
                                <label for="titleName" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                                <input type="text" id="titleName" name="name" maxlength="255"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                <p id="nameError" class="text-red-500 text-xs mt-1 hidden">Le nom est requis (max 255 caractères)</p>
                            </div>
            
                            <div class="mb-4">
                                <label for="titlePermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                                <select id="titlePermisType" name="type_permis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
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
                                <p id="type_permisError" class="text-red-500 text-xs mt-1 hidden">Veuillez sélectionner un type de permis</p>
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
            </div>
            
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            $(document).ready(function() {
                const modal = $('#titleModal');
                const form = $('#titleForm');
                const submitBtn = $('#submitBtn');
            
                // Nouveau titre
                $('#newTitleBtn').click(function() {
                    $('#modalTitle').text('Nouveau Titre');
                    form.attr('action', "{{ route('admin.titles.store') }}");
                    $('#_method').val('POST');
                    $('#titleId').val('');
                    $('#titlePermisType').val('');
                    $('#titleName').val('');
                    modal.removeClass('hidden');
                });
            
                // Édition d'un titre
                window.handleEditTitle = function(id, permisType, name) {
                    $('#modalTitle').text('Modifier Titre');
                    form.attr('action', "{{ route('admin.titles.update', '') }}/" + id);
                    $('#_method').val('PUT');
                    $('#titleId').val(id);
                    $('#titlePermisType').val(permisType);
                    $('#titleName').val(name);
                    modal.removeClass('hidden');
                };
            
                // Suppression d'un titre
                window.handleDeleteTitle = function(id) {
                    if (!confirm('Voulez-vous vraiment supprimer ce titre ?')) return;
                    
                    $.ajax({
                        url: "{{ route('admin.titles.destroy', '') }}/" + id,
                        method: 'POST',
                        data: { 
                            _method: 'DELETE', 
                            _token: "{{ csrf_token() }}" 
                        },
                        success: function() {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            alert('Erreur lors de la suppression: ' + xhr.responseJSON?.message);
                        }
                    });
                };
            
                // Annulation
                $('#cancelBtn').click(function() {
                    modal.addClass('hidden');
                });
            
                // Soumission du formulaire
                form.on('submit', function(e) {
                    e.preventDefault();
                    
                    // Réinitialiser les erreurs
                    $('.text-red-500').addClass('hidden');
                    
                    const formData = $(this).serialize();
                    const url = $(this).attr('action');
                    const method = $('#_method').val();
                    
                    submitBtn.prop('disabled', true);
                    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Enregistrement...');
            
                    $.ajax({
                        url: url,
                        method: method === 'PUT' ? 'POST' : 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                // Fermer le modal avant de recharger la page
                                modal.addClass('hidden');
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
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false);
                            submitBtn.html('Enregistrer');
                        }
                    });
                });
            });
            

            
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
      const progressBars = document.querySelectorAll('.progress-bar');
      progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
          bar.style.width = width;
        }, 300);
      });
    }, 500);
    
    const badge = document.querySelector('.pulse');
    if (badge) {
      setInterval(() => {
        badge.classList.add('animate-pulse');
        setTimeout(() => {
          badge.classList.remove('animate-pulse');
        }, 1000);
      }, 2000);
    }
  });
        
  document.addEventListener("DOMContentLoaded", function () {
    function toggleSection(headerId, listId, arrowId) {
      const header = document.getElementById(headerId);
      const list = document.getElementById(listId);
      const arrow = document.getElementById(arrowId);
  
      let isOpen = list.style.maxHeight !== "0px";
  
      header.addEventListener("click", function () {
        if (isOpen) {
          list.style.maxHeight = "0";
          arrow.style.transform = "rotate(0deg)";
        } else {
          list.style.maxHeight = `${list.scrollHeight}px`;
          arrow.style.transform = "rotate(90deg)";
        }
        isOpen = !isOpen;
      });
    }
  
    toggleSection("candidats-header", "candidats-list", "candidats-arrow");
    toggleSection("cours-theorique-header", "cours-theorique-list", "cours-theorique-arrow");
    toggleSection("cours-pratique-header", "cours-pratique-list", "cours-pratique-arrow");
    toggleSection("vehicule-header", "vehicule-list", "vehicule-arrow");
    toggleSection("examen-header", "examen-list", "examen-arrow");
    toggleSection("moniteurs-header", "moniteurs-list", "moniteurs-arrow");
    toggleSection("caisse-header", "caisse-list", "caisse-arrow");
  });

  


    </script>
@endsection