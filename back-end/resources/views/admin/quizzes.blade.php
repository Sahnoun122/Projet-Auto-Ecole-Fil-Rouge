<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 50;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .transition-max-height {
        transition: max-height 0.3s ease-in-out;
    }
</style>

<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen">
        <div :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-white shadow-lg transition-all duration-300 flex flex-col">
            <div class="p-4 flex justify-between items-center border-b">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
            </div>

            <div class="p-4 border-b flex justify-center">
                <div class="relative group">
                    <div
                        class="absolute inset-0 bg-primary rounded-full opacity-10 group-hover:opacity-20 transition-opacity">
                    </div>
                    <img src="/api/placeholder/60/60" alt="Auto-école"
                        class="h-16 w-16 object-contain rounded-full border-2 border-gray-200" />
                    <div class="absolute bottom-0 right-0 h-4 w-4 bg-green-500 rounded-full border-2 border-white">
                    </div>
                </div>
            </div>

            <div :class="sidebarOpen ? 'block' : 'hidden'" class="text-center py-2 text-sm font-medium text-gray-600">
                Auto-école S A H N O U N
            </div>

            <div class="flex flex-col h-screen">
                <nav>
                    <a href=" {{ route('admin.dashboard') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-primary bg-indigo-50 border-l-4 border-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Tableau de bord</span>
                    </a>
                       
                        <div>
                            <a href=" {{route('admin.candidats')}}">
                              <div id="cours-theorique-header"
                              class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                          </svg>
      
                              <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Candidats</span>
                              <svg id="cours-theorique-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                </svg>                            
                              
                              </div>
                            </a>
                            
                          </div>
                    <div>
                      <a href=" {{route('admin.titles.index')}}">
                        <div id="cours-theorique-header"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>

                        <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Théorique</span>
                        <svg id="cours-theorique-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          </svg>                            
                        
                        </div>
                      </a>
                      
                    </div>

                    <div>
                      <a href="{{ route ('admin.quizzes')}}">
                        <div id="cours-pratique-header"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Pratique</span>
                        <svg id="cours-pratique-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          </svg>
                    </div>
                      </a>
                    
                    </div>

                    <div>
                    <a href=" {{ route('admin.vehicles')}}">
                        <div id="vehicule-header"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>

                        <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Véhicule</span>
                        <svg id="vehicule-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          </svg>
                    </div>
                    </a>
                    
                    </div>

                    <div>
                    <a href=" {{ route('admin.exams')}}">
                        <div id="examen-header"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>

                        <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Examen</span>
                        <svg id="examen-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          </svg>
                    </div>
                    </a>
                


                    </div>

                    <div>
                    <a href=" {{ route('admin.monitors.index') }}">
                        <div id="moniteurs-header"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Moniteurs</span>
                        <svg id="moniteurs-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          </svg>

                    </div>
                    </a>
                   

                    </div>

                   <a href="">
                    <div>
                        <div id="caisse-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Caisse</span>
                            <svg id="caisse-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             
                        </div>
                   </a>

                       
                        <a href="{{ route('logout') }} "
                        <div id="logout-button" class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer" id="logoutButton">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Déconnexion</span>
                        </div>
                     </a>
                        
                    </div>
                </nav>
            </div>

        <div class="flex-1 overflow-auto">

                    <header class="bg-[#4D44B5] text-white shadow-md">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                            <h1 class="text-2xl font-bold">QuizMaster Pro</h1>
                            <button id="newQuizBtn"
                                class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                                <i class="fas fa-plus mr-2"></i> Nouveau Quiz
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
                                <h2 class="text-xl font-semibold text-gray-800">Mes Quiz</h2>
                            </div>
            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                                @forelse ($quizzes as $quiz)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="inline-block px-2 py-1 bg-[#4D44B5] text-white text-xs rounded-full mb-2">
                                                Permis {{ $quiz->type_permis }}
                                            </span>
                                            <h3 class="text-lg font-semibold text-[#4D44B5]">
                                                <a href="{{ route('admin.questions.index', $quiz->id) }}">{{ $quiz->title }}</a>                                            </h3>
                                            @if($quiz->description)
                                                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($quiz->description, 100) }}</p>
                                            @endif
                                            <p class="text-sm text-gray-500 mt-2">{{ $quiz->questions_count }} questions</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="handleEditQuiz('{{ $quiz->id }}', '{{ $quiz->type_permis }}', '{{ $quiz->title }}', `{{ $quiz->description }}`)"
                                                class="text-[#4D44B5] hover:text-[#3a32a1] p-2">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="handleDeleteQuiz('{{ $quiz->id }}')"
                                                class="text-red-500 hover:text-red-700 p-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-3 text-center py-8">
                                    <p class="text-gray-500">Aucun quiz disponible</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </main>
            
                    <div id="quizModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                        <div class="bg-white w-full max-w-md p-6 rounded-lg">
                            <h2 id="modalTitle" class="text-lg font-bold mb-4">Nouveau Quiz</h2>
                            <form id="quizForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="quizId" name="id">
                                <input type="hidden" id="_method" name="_method" value="POST">
            
                                <div class="mb-4">
                                    <label for="quizPermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                                    <select id="quizPermisType" name="type_permis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
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
                                    <p id="permisError" class="text-red-500 text-xs mt-1 hidden">Veuillez sélectionner un type de permis</p>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="quizTitle" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                                    <input type="text" id="quizTitle" name="title" maxlength="255"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    <p id="titleError" class="text-red-500 text-xs mt-1 hidden">Le titre est requis (max 255 caractères)</p>
                                </div>
            
                                <div class="mb-4">
                                    <label for="quizDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea id="quizDescription" name="description" rows="3"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
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
    const modal = $('#quizModal');
    const form = $('#quizForm');
    const submitBtn = $('#submitBtn');

    $('#newQuizBtn').click(function() {
        $('#modalTitle').text('Nouveau Quiz');
        form.attr('action', "{{ route('admin.quizzes.store') }}");
        $('#_method').val('POST');
        $('#quizId').val('');
        $('#quizPermisType').val('');
        $('#quizTitle').val('');
        $('#quizDescription').val('');
        modal.removeClass('hidden');
    });

    window.handleEditQuiz = function(id, permisType, title, description) {
        $('#modalTitle').text('Modifier Quiz');
        form.attr('action', "{{ route('admin.quizzes.update', '') }}/" + id);
        $('#_method').val('PUT');
        $('#quizId').val(id);
        $('#quizPermisType').val(permisType);
        $('#quizTitle').val(title);
        $('#quizDescription').val(description);
        modal.removeClass('hidden');
    };

    window.handleDeleteQuiz = function(id) {
        if (!confirm('Voulez-vous vraiment supprimer ce quiz ?')) return;
        
        $.ajax({
            url: "{{ route('admin.quizzes.destroy', '') }}/" + id,
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

 
async function logout() {
    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`, 
            },
        });
 
        const data = await response.json();

        if (response.ok) {
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            alert(data.message);
            window.location.href = '/connecter'; 
        } else {
            alert('Échec de la déconnexion : ' + data.message); 
        }
    } catch (error) {
        console.error('Erreur lors de la déconnexion:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
    }
}

document.getElementById('logoutButton').addEventListener('click', logout);
      </script>
            </body>
            </html>