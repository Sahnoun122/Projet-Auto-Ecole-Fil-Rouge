<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>

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
                        <div id="candidats-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Candidats</span>
                            <svg id="candidats-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div id="candidats-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Candidats</span>
                            </a>
                            <a href=" {{ route('admin.gestionCandidats') }} "
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Candidats</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div id="cours-theorique-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>

                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Théorique</span>
                            <svg id="cours-theorique-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>                            </div>
                        <div id="cours-theorique-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Cours Théorique</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Cours Théorique</span>
                            </a>
                        </div>
                    </div>

                    <div>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>
                        <div id="cours-pratique-list"
                            class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="{{ route('admin.quizzes') }} "
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Cours Pratique</span>
                            </a>
                            <a href="{{ route('admin.quizzes')}}"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Cours Pratique</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div id="vehicule-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>

                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Véhicule</span>
                            <svg id="vehicule-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>
                        <div id="vehicule-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Véhicule</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Véhicules</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div id="examen-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>

                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Examen</span>
                            <svg id="examen-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>
                        <div id="examen-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Examen</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Examens</span>
                            </a>
                        </div>


                    </div>

                    <div>
                        <div id="moniteurs-header"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Moniteurs</span>
                            <svg id="moniteurs-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>

                        </div>
                        <div id="moniteurs-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Moniteurs</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Moniteurs</span>
                            </a>
                        </div>

                    </div>

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                              </svg>
                        </div>

                        <div id="caisse-list" class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Caisse</span>
                            </a>
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Liste des Caisses</span>
                            </a>
                        </div>
                        <div id="logout-button" class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer" id="logoutButton">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Déconnexion</span>
                        </div>
                        
                    </div>
                </nav>
            </div>

        </div>
        
        <div class="flex-1 overflow-auto">
            <div id="examModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white w-full max-w-2xl p-6 rounded-lg overflow-y-auto" style="max-height: 90vh;">
                    <h2 id="modalExamTitle" class="text-lg font-bold mb-4 text-[#4D44B5]">Nouvel Examen</h2>
                    <form id="examForm" method="POST" action="{{ route('admin.exams.store') }}" class="space-y-6">
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
        
            <div id="candidatesModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white w-full max-w-4xl p-6 rounded-lg overflow-y-auto" style="max-height: 90vh;">
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
        
            <div> 
    </div>


    <script>
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

    function toggleSection(headerId, listId, arrowId) {
        const header = document.getElementById(headerId);
        const list = document.getElementById(listId);
        const arrow = document.getElementById(arrowId);

        let isOpen = list.style.maxHeight !== "0px";

        header.addEventListener("click", function() {
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

    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            })
            .catch(error => {
                console.error('Erreur lors de la déconnexion:', error);
            });
        });
    }
});
</script>
</body>

</html>
