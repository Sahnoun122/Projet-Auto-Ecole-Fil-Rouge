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

<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen">
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white shadow-lg transition-all duration-300 flex flex-col">
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
            <div class="flex-1 overflow-y-auto py-4">
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
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
                        <h1 class="text-2xl font-bold">Gestion des Examens</h1>
                        <button id="newExamBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                            <i class="fas fa-plus mr-2"></i> Nouvel Examen
                        </button>
                    </div>
                </header>
            
                <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div id="alertMessage" class="hidden mb-4 p-4 rounded-lg"></div>
            
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                            <h2 class="text-xl font-semibold text-gray-800">Liste des Examens</h2>
                            <div class="flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
                                <div class="relative w-full md:w-48">
                                    <select id="statusFilter" class="w-full pl-3 pr-8 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                        <option value="">Tous les statuts</option>
                                        <option value="planifie">Planifié</option>
                                        <option value="en_cours">En cours</option>
                                        <option value="termine">Terminé</option>
                                        <option value="annule">Annulé</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                                </div>
                                <div class="relative w-full md:w-48">
                                    <select id="typeFilter" class="w-full pl-3 pr-8 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                        <option value="">Tous les types</option>
                                        <option value="theorique">Théorique</option>
                                        <option value="pratique">Pratique</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                                </div>
                                <div class="relative w-full">
                                    <input type="text" id="searchInput" placeholder="Rechercher..." 
                                           class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
            
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Lieu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moniteur</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidats</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="examsTableBody">
                                    <!-- Les examens seront chargés via AJAX -->
                                </tbody>
                            </table>
                            <div class="px-6 py-4 border-t border-gray-200 flex justify-center" id="paginationContainer">
                                <!-- La pagination sera chargée via AJAX -->
                            </div>
                        </div>
                    </div>
                </main>
            
                <!-- Modal pour ajouter/modifier un examen -->
                <div id="examModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
                    <div class="bg-white w-full max-w-2xl rounded-lg overflow-y-auto max-h-[90vh]">
                        <div class="p-6">
                            <h2 id="modalExamTitle" class="text-lg font-bold mb-4 text-[#4D44B5]">Nouvel Examen</h2>
                            <form id="examForm" class="space-y-6">
                                @csrf
                                <input type="hidden" id="examId" name="id">
                                <input type="hidden" id="_method" name="_method" value="POST">
            
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="examType" class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                                        <select id="examType" name="type" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                            <option value="">Sélectionnez un type</option>
                                            <option value="theorique">Théorique</option>
                                            <option value="pratique">Pratique</option>
                                        </select>
                                    </div>
            
                                    <div>
                                        <label for="examDate" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                                        <input type="datetime-local" id="examDate" name="date_exam" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    </div>
            
                                    <div class="md:col-span-2">
                                        <label for="examLieu" class="block text-sm font-medium text-gray-700 mb-1">Lieu *</label>
                                        <input type="text" id="examLieu" name="lieu" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    </div>
            
                                    <div>
                                        <label for="examPlaces" class="block text-sm font-medium text-gray-700 mb-1">Places max *</label>
                                        <input type="number" id="examPlaces" name="places_max" min="1" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                    </div>
            
                                    <div>
                                        <label for="examMoniteur" class="block text-sm font-medium text-gray-700 mb-1">Moniteur</label>
                                        <select id="examMoniteur" name="moniteur_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                            <option value="">Non assigné</option>
                                            @foreach($moniteurs as $moniteur)
                                            <option value="{{ $moniteur->id }}">{{ $moniteur->nom }} {{ $moniteur->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
            
                                    <div class="md:col-span-2">
                                        <label for="examInstructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                                        <textarea id="examInstructions" name="instructions" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]"></textarea>
                                    </div>
                                </div>
            
                                <div class="flex justify-end space-x-2 pt-4 border-t">
                                    <button type="button" id="cancelExamBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                        Annuler
                                    </button>
                                    <button type="submit" id="submitExamBtn" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition flex items-center">
                                        <i class="fas fa-save mr-2"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
                <!-- Modal pour gérer les candidats -->
                <div id="candidatesModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-4">
                    <div class="bg-white w-full max-w-4xl rounded-lg overflow-y-auto max-h-[90vh]">
                        <div class="p-6">
                            <h2 id="modalCandidatesTitle" class="text-lg font-bold mb-4 text-[#4D44B5]">Gérer les candidats</h2>
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="w-full md:w-1/2">
                                    <h3 class="font-medium mb-2">Candidats disponibles</h3>
                                    <div class="relative mb-4">
                                        <input type="text" id="searchAvailableCandidates" placeholder="Rechercher..." 
                                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                    <div class="border rounded-lg p-2 h-64 overflow-y-auto" id="availableCandidatesList">
                                        <!-- Liste des candidats disponibles -->
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2">
                                    <h3 class="font-medium mb-2">Candidats inscrits</h3>
                                    <div class="relative mb-4">
                                        <input type="text" id="searchRegisteredCandidates" placeholder="Rechercher..." 
                                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]">
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                    <div class="border rounded-lg p-2 h-64 overflow-y-auto" id="registeredCandidatesList">
                                        <!-- Liste des candidats inscrits -->
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2 pt-4 border-t mt-4">
                                <button type="button" id="cancelCandidatesBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                    Fermer
                                </button>
                                <button type="button" id="saveCandidatesBtn" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Éléments du DOM
                const examModal = document.getElementById('examModal');
                const examForm = document.getElementById('examForm');
                const candidatesModal = document.getElementById('candidatesModal');
                const alertMessage = document.getElementById('alertMessage');
                
                // Variables d'état
                let currentExamId = null;
                let currentPage = 1;
            
                // Initialisation
                loadExams();
            
                // Ouvrir modal pour nouveau examen
                document.getElementById('newExamBtn').addEventListener('click', () => {
                    examForm.reset();
                    examForm.action = '/admin/exams';
                    examForm.querySelector('input[name="_method"]').value = 'POST';
                    document.getElementById('modalExamTitle').textContent = 'Nouvel Examen';
                    examModal.classList.remove('hidden');
                });
            
                // Fermer modal examen
                document.getElementById('cancelExamBtn').addEventListener('click', () => {
                    examModal.classList.add('hidden');
                });
            
                // Fermer modal candidats
                document.getElementById('cancelCandidatesBtn').addEventListener('click', () => {
                    candidatesModal.classList.add('hidden');
                });
            
                // Sauvegarder les modifications des candidats
                document.getElementById('saveCandidatesBtn').addEventListener('click', () => {
                    candidatesModal.classList.add('hidden');
                    loadExams();
                });
            
                // Soumission du formulaire examen
                examForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    
                    const formData = new FormData(examForm);
                    const method = formData.get('_method') || 'POST';
                    const url = method === 'POST' ? '/admin/exams' : `/admin/exams/${formData.get('id')}`;
                    
                    try {
                        const response = await fetch(url, {
                            method: method,
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            showAlert('success', data.message);
                            examModal.classList.add('hidden');
                            loadExams();
                        }
                    } catch (error) {
                        showAlert('error', 'Une erreur est survenue');
                        console.error('Error:', error);
                    }
                });
            
                // Fonction pour charger les examens
                async function loadExams(page = 1) {
                    currentPage = page;
                    const status = document.getElementById('statusFilter').value;
                    const type = document.getElementById('typeFilter').value;
                    const search = document.getElementById('searchInput').value;
                    
                    try {
                        const response = await fetch(`/admin/exams?page=${page}&status=${status}&type=${type}&search=${search}`);
                        const data = await response.json();
                        
                        // Mettre à jour le tableau
                        const tableBody = document.getElementById('examsTableBody');
                        tableBody.innerHTML = data.exams.data.map(exam => `
                            <tr class="hover:bg-gray-50 exam-row" 
                                data-type="${exam.type}"
                                data-status="${exam.statut}"
                                data-search="${exam.lieu.toLowerCase()} ${exam.moniteur ? exam.moniteur.nom.toLowerCase() + ' ' + exam.moniteur.prenom.toLowerCase() : ''}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        ${exam.type === 'theorique' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'}">
                                        ${exam.type.charAt(0).toUpperCase() + exam.type.slice(1)}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${new Date(exam.date_exam).toLocaleString('fr-FR')}</div>
                                    <div class="text-sm text-gray-500">${exam.lieu}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${exam.moniteur ? `
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="/storage/${exam.moniteur.photo_profile}" alt="${exam.moniteur.nom}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">${exam.moniteur.nom} ${exam.moniteur.prenom}</div>
                                            <div class="text-sm text-gray-500">${exam.moniteur.email}</div>
                                        </div>
                                    </div>
                                    ` : '<span class="text-sm text-gray-500">Non assigné</span>'}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${exam.candidats_count} / ${exam.places_max}</div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                                        <div class="bg-[#4D44B5] h-2.5 rounded-full" 
                                             style="width: ${(exam.candidats_count / exam.places_max) * 100}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(exam.statut)}">
                                        ${formatStatus(exam.statut)}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="handleEditExam(${exam.id})" class="text-[#4D44B5] hover:text-[#3a32a1] p-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="handleDeleteExam(${exam.id})" class="text-red-500 hover:text-red-700 p-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="/admin/exams/${exam.id}" class="text-gray-600 hover:text-gray-900 p-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="handleManageCandidates(${exam.id})" class="text-green-600 hover:text-green-800 p-1">
                                            <i class="fas fa-users"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `).join('');
                        
                        // Mettre à jour la pagination
                        const paginationContainer = document.getElementById('paginationContainer');
                        paginationContainer.innerHTML = data.exams.links ? `
                            <nav class="flex items-center space-x-2">
                                ${data.exams.links.map(link => `
                                    <button onclick="loadExams(${link.url ? new URL(link.url).searchParams.get('page') || 1 : 1})" 
                                            class="px-3 py-1 rounded-md ${link.active ? 'bg-[#4D44B5] text-white' : 'bg-gray-200 text-gray-700'} 
                                            ${!link.url ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300'}">
                                        ${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}
                                    </button>
                                `).join('')}
                            </nav>
                        ` : '';
                        
                    } catch (error) {
                        console.error('Error:', error);
                        showAlert('error', 'Erreur lors du chargement des examens');
                    }
                }
            
                // Fonctions globales
                window.handleEditExam = async (id) => {
                    try {
                        const response = await fetch(`/admin/exams/${id}/edit`);
                        const exam = await response.json();
                        
                        document.getElementById('examId').value = exam.id;
                        document.getElementById('_method').value = 'PUT';
                        document.getElementById('modalExamTitle').textContent = 'Modifier Examen';
                        
                        // Remplir les champs
                        document.getElementById('examType').value = exam.type;
                        document.getElementById('examDate').value = exam.date_exam.replace(' ', 'T');
                        document.getElementById('examLieu').value = exam.lieu;
                        document.getElementById('examPlaces').value = exam.places_max;
                        document.getElementById('examMoniteur').value = exam.moniteur_id;
                        document.getElementById('examInstructions').value = exam.instructions;
                        
                        examModal.classList.remove('hidden');
                    } catch (error) {
                        console.error('Error:', error);
                        showAlert('error', 'Erreur lors du chargement de l\'examen');
                    }
                };
            
                window.handleDeleteExam = async (id) => {
                    if (confirm('Voulez-vous vraiment supprimer cet examen ?')) {
                        try {
                            const response = await fetch(`/admin/exams/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                }
                            });
                            
                            const data = await response.json();
                            
                            if (data.success) {
                                showAlert('success', data.message);
                                loadExams(currentPage);
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            showAlert('error', 'Erreur lors de la suppression');
                        }
                    }
                };
            
                window.handleManageCandidates = async (examId) => {
                    currentExamId = examId;
                    try {
                        const response = await fetch(`/admin/exams/${examId}/candidates`);
                        const data = await response.json();
                        
                        document.getElementById('modalCandidatesTitle').textContent = `Gérer les candidats - Examen #${examId}`;
                        
                        // Remplir les listes
                        populateCandidateList('availableCandidatesList', data.available, examId, true);
                        populateCandidateList('registeredCandidatesList', data.registered, examId, false);
                        
                        candidatesModal.classList.remove('hidden');
                    } catch (error) {
                        console.error('Error:', error);
                        showAlert('error', 'Erreur lors du chargement des candidats');
                    }
                };
            
                window.addCandidateToExam = async (examId, candidateId) => {
                    try {
                        const response = await fetch(`/admin/exams/${examId}/add-candidate`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ candidat_id: candidateId })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            handleManageCandidates(examId);
                        } else {
                            showAlert('error', data.message || 'Erreur lors de l\'ajout du candidat');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showAlert('error', 'Erreur lors de l\'ajout du candidat');
                    }
                };
            
                window.removeCandidateFromExam = async (examId, candidateId) => {
                    try {
                        const response = await fetch(`/admin/exams/${examId}/remove-candidate`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ candidat_id: candidateId })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            handleManageCandidates(examId);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showAlert('error', 'Erreur lors de la suppression du candidat');
                    }
                };
            
                // Fonctions utilitaires
                function populateCandidateList(listId, candidates, examId, isAvailable) {
                    const list = document.getElementById(listId);
                    list.innerHTML = '';
                    
                    candidates.forEach(candidate => {
                        const item = document.createElement('div');
                        item.className = 'flex items-center justify-between p-2 hover:bg-gray-50 rounded candidate-item';
                        item.dataset.id = candidate.id;
                        
                        item.innerHTML = `
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full mr-3" src="/storage/${candidate.photo_profile}" alt="${candidate.nom}">
                                <div>
                                    <div class="text-sm font-medium">${candidate.nom} ${candidate.prenom}</div>
                                    <div class="text-xs text-gray-500">${candidate.email}</div>
                                </div>
                            </div>
                            <button class="${isAvailable ? 'text-green-500 hover:text-green-700' : 'text-red-500 hover:text-red-700'}">
                                <i class="fas ${isAvailable ? 'fa-plus' : 'fa-times'}"></i>
                            </button>
                        `;
                        
                        const btn = item.querySelector('button');
                        btn.onclick = isAvailable 
                            ? () => addCandidateToExam(examId, candidate.id)
                            : () => removeCandidateFromExam(examId, candidate.id);
                            
                        list.appendChild(item);
                    });
                }
            
                function formatStatus(status) {
                    const statusMap = {
                        'planifie': 'Planifié',
                        'en_cours': 'En cours',
                        'termine': 'Terminé',
                        'annule': 'Annulé'
                    };
                    return statusMap[status] || status;
                }
            
                function getStatusClass(status) {
                    const statusClasses = {
                        'planifie': 'bg-blue-100 text-blue-800',
                        'en_cours': 'bg-yellow-100 text-yellow-800',
                        'termine': 'bg-green-100 text-green-800',
                        'annule': 'bg-red-100 text-red-800'
                    };
                    return statusClasses[status] || 'bg-gray-100 text-gray-800';
                }
            
                function showAlert(type, message) {
                    alertMessage.className = `${type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} p-4 rounded-lg`;
                    alertMessage.innerHTML = message;
                    alertMessage.classList.remove('hidden');
                    
                    setTimeout(() => {
                        alertMessage.classList.add('hidden');
                    }, 5000);
                }
            
                // Filtres et recherche
                document.getElementById('statusFilter').addEventListener('change', () => loadExams());
                document.getElementById('typeFilter').addEventListener('change', () => loadExams());
                document.getElementById('searchInput').addEventListener('input', debounce(() => loadExams(), 300));
            
                // Fonction debounce pour limiter les appels API lors de la saisie
                function debounce(func, wait) {
                    let timeout;
                    return function() {
                        const context = this, args = arguments;
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func.apply(context, args), wait);
                    };
                }
            
                // Recherche dans les listes de candidats
                document.getElementById('searchAvailableCandidates').addEventListener('input', function() {
                    searchInList('availableCandidatesList', this.value.toLowerCase());
                });
            
                document.getElementById('searchRegisteredCandidates').addEventListener('input', function() {
                    searchInList('registeredCandidatesList', this.value.toLowerCase());
                });
            
                function searchInList(listId, term) {
                    const items = document.querySelectorAll(`#${listId} .candidate-item`);
                    items.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        item.style.display = text.includes(term) ? 'flex' : 'none';
                    });
                }
            });
            </script>
</script>
</body>

</html>
