<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun - Ajouter Moniteur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    @vite([
      'resources/js/moniteurs.js'  ])
      
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
                    <a href="#"
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
                            <a href="#"
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
                            <a href="#"
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Cours Pratique</span>
                            </a>
                            <a href="#"
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
            <header class="bg-[#4D44B5] text-white shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Gestion des Moniteurs</h1>
                    <button id="newMonitorBtn" class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                        <i class="fas fa-plus mr-2"></i> Ajouter un Moniteur
                    </button>
                </div>
            </header>
       
        
            <div id="monitorModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white w-full max-w-2xl p-6 rounded-lg">
                    <h2 id="modalTitle" class="text-lg font-bold mb-4">Nouveau Moniteur</h2>
                    <form id="monitorForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="monitorId" name="id">
                        <input type="hidden" id="_method" name="_method" value="POST">
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="monitorNom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                                <input type="text" id="monitorNom" name="nom" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            </div>
                            <div>
                                <label for="monitorPrenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                                <input type="text" id="monitorPrenom" name="prenom" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            </div>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="monitorEmail" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" id="monitorEmail" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            </div>
                            <div>
                                <label for="monitorTelephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                                <input type="text" id="monitorTelephone" name="telephone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            </div>
                        </div>
        
                        <div class="mb-4">
                            <label for="monitorAdresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                            <input type="text" id="monitorAdresse" name="adresse" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                        </div>
        
                        <div class="mb-4">
                            <label for="monitorPermisType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
                            <select id="monitorPermisType" name="type_permis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="A">Permis A (Moto)</option>
                                <option value="B">Permis B (Voiture)</option>
                                <option value="C">Permis C (Poids lourd)</option>
                                <option value="D">Permis D (Bus)</option>
                                <option value="EB">Permis EB (Remorque)</option>
                            </select>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="monitorPhotoProfile" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil *</label>
                                <input type="file" id="monitorPhotoProfile" name="photo_profile" accept="image/jpeg,image/png,image/jpg" class="w-full">
                                <p class="text-xs text-gray-500 mt-1">Formats acceptés: jpeg, png, jpg. Max: 2MB</p>
                            </div>
                            <div>
                                <label for="monitorPhotoIdentite" class="block text-sm font-medium text-gray-700 mb-1">Photo d'identité *</label>
                                <input type="file" id="monitorPhotoIdentite" name="photo_identite" accept="image/jpeg,image/png,image/jpg" class="w-full">
                                <p class="text-xs text-gray-500 mt-1">Formats acceptés: jpeg, png, jpg. Max: 2MB</p>
                            </div>
                        </div>
        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="monitorCertifications" class="block text-sm font-medium text-gray-700 mb-1">Certifications *</label>
                                <input type="file" id="monitorCertifications" name="certifications" accept=".pdf,.doc,.docx" class="w-full">
                                <p class="text-xs text-gray-500 mt-1">Formats acceptés: pdf, doc, docx. Max: 2MB</p>
                            </div>
                            <div>
                                <label for="monitorQualifications" class="block text-sm font-medium text-gray-700 mb-1">Qualifications *</label>
                                <input type="file" id="monitorQualifications" name="qualifications" accept=".pdf,.doc,.docx" class="w-full">
                                <p class="text-xs text-gray-500 mt-1">Formats acceptés: pdf, doc, docx. Max: 2MB</p>
                            </div>
                        </div>
        
                        <div class="mb-4">
                            <label for="monitorPassword" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                            <input type="password" id="monitorPassword" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères, avec majuscule, minuscule et chiffre</p>
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

    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
  $(document).ready(function() {
            const modal = $('#monitorModal');
            const form = $('#monitorForm');
            const submitBtn = $('#submitBtn');
        
            // Nouveau moniteur
            $('#newMonitorBtn').click(function() {
                $('#modalTitle').text('Nouveau Moniteur');
                form.attr('action', "{{ route('admin.monitors.store') }}");
                $('#_method').val('POST');
                $('#monitorId').val('');
                form.trigger('reset');
                $('#monitorPassword').attr('required', true);
                modal.removeClass('hidden');
            });
        
            window.handleEditMonitor = function(id) {
                $('#modalTitle').text('Modifier Moniteur');
                form.attr('action', "{{ route('admin.monitors.update', '') }}/" + id);
                $('#_method').val('PUT');
                $('#monitorId').val(id);
                
                $.get("{{ route('admin.monitors.index') }}/" + id + "/edit", function(data) {
                    $('#monitorNom').val(data.nom);
                    $('#monitorPrenom').val(data.prenom);
                    $('#monitorEmail').val(data.email);
                    $('#monitorTelephone').val(data.telephone);
                    $('#monitorAdresse').val(data.adresse);
                    $('#monitorPermisType').val(data.type_permis);
                    $('#monitorPassword').val('').removeAttr('required');
                });
                
                modal.removeClass('hidden');
            };
        
            window.handleDeleteMonitor = function(id) {
                if (!confirm('Voulez-vous vraiment supprimer ce moniteur ?')) return;
                
                $.ajax({
                    url: "{{ route('admin.monitors.destroy', '') }}/" + id,
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
        
            $('#cancelBtn').click(function() {
                modal.addClass('hidden');
            });
        });

        
    </script>

</body>

</html>
