<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun - Ajouter Moniteur</title>
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

        <div class="bg-white w-full md:w-3/5 p-8 flex flex-col ml-32 justify-center">
            <div class="max-w-lg mx-auto w-full">
              @if ($errors->any())
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                  {{-- <ul class="list-disc pl-5">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul> --}}
              </div>
          @endif
        
          <form id="registerForm" method="POST" action="/api/register" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <input type="hidden" name="role"  value="moniteur">
              <input type="hidden" name="_token" value="votre_token_csrf_ici">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="fade-in-up" style="animation-delay: 0.1s;">
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input 
                      type="text" 
                      id="nom" 
                      value="{{ old('nom') }}"
                      name="nom"
                      placeholder="Nom"
                      class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                    >
                  </div>
                  <div class="fade-in-up" style="animation-delay: 0.2s;">
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                    <input 
                      type="text" 
                      id="prenom" 
                      value="{{ old('prenom') }}"
                      name="prenom"
                      placeholder="Prenom"
                      class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                    >
                  </div>
                </div>
        
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="fade-in-up" style="animation-delay: 0.1s;">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input 
                      type="email" 
                      id="email" 
                      value="{{ old('email') }}"
                      name="email"
                      placeholder="Email"
                      class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                    >
                  </div>
                  <div class="fade-in-up" style="animation-delay: 0.2s;">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input 
                      type="password" 
                      id="password" 
                      value=""
                      name="password"
                      placeholder="Mot de passe"
                      class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                    >
                  </div>
                  <input type="hidden" name="role"  value="candidat">
                </div>
        
        
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="fade-in-up" style="animation-delay: 0.1s;">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input 
                      type="text" 
                      id="address" 
                      name="adresse"
                      value=""
                      value="{{ old('adresse') }}"
                      placeholder="Adresse"
                      class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                    >
                  </div>
                  <div class="fade-in-up" style="animation-delay: 0.2s;">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input 
                      type="tel" 
                      id="telephone" 
                      value="{{ old('telephone') }}"
                      name="telephone"
                      placeholder="Téléphone"
                      class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
                    >
                  </div>
                  <input type="hidden" name="role"  value="candidat">
                </div>

             <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="fade-in-up" style="animation-delay: 0.2s;">
        <label for="certifications" class="block text-sm font-medium text-gray-700 mb-1">Certifications</label>
        <input 
            type="text" 
            id="certifications" 
            name="certifications"
            value="{{ old('certifications') }}"
            placeholder="Certifications (facultatif)"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
        >
    </div>

    <div class="fade-in-up" style="animation-delay: 0.3s;">
        <label for="qualifications" class="block text-sm font-medium text-gray-700 mb-1">Qualifications</label>
        <input 
            type="text" 
            id="qualifications" 
            name="qualifications"
            value="{{ old('qualifications') }}"
            placeholder="Qualifications (facultatif)"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
        >
    </div>
</div>
    <div class="fade-in-up" style="animation-delay: 0.2s;">
          <label for="type_permis" class="block text-sm font-medium text-gray-700 mb-2">Type de permis</label>
          <select 
            id="type_permis" 
            name="type_permis"
            class="w-full px-4 py-3 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            required
          >
            <option value="">Sélectionnez votre type de permis</option>
            <option value="A">Permis A (Moto)</option>
            <option value="B">Permis B (Voiture)</option>
            <option value="C">Permis C (Poids lourd)</option>
            <option value="D">Permis D (Bus)</option>
            <option value="EB">Permis EB (Remorque)</option>
          </select>
    
        </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          
                  <div class="fade-in-up" style="animation-delay: 0.8s;">
                    <label for="photo-profile" class="block text-sm font-medium text-gray-700 mb-2">Photo de Profil</label>
                    <div class="relative border-2 border-dashed border-blue-500 rounded-lg p-6 hover:bg-blue-50 transition ease-in-out">
                      <input 
                        type="file" 
                        id="photo-profile" 
                        name="photo_profile"
                        accept="image/*"
                        class="hidden"
                        onchange="previewProfilePhoto(event)"
                      >
                      <label for="photo-profile" class="block text-center cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="mt-2 block text-sm font-medium text-gray-700">Glissez-déposez votre photo ou cliquez pour sélectionner</span>
                        <span class="mt-1 block text-xs text-gray-500">Format JPG, PNG (max. 2MB)</span>
                      </label>
                    </div>
                    
                    <!-- Preview -->
                    <div id="previewProfileContainer" class="mt-4 hidden">
                      <img id="profileImagePreview" class="mx-auto rounded-lg shadow-lg w-32 h-32 object-cover" alt="Aperçu de la photo de profil">
                      <button id="removeProfileImage" class="mt-2 text-red-500 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="block text-sm">Supprimer l'image</span>
                      </button>
                    </div>
                  </div>
                  
                  <div class="fade-in-up">
                    <label for="photo_identite" class="block text-sm font-medium text-gray-700 mb-2">Photo d'identité</label>
                    <div class="relative border-2 border-dashed border-blue-500 rounded-lg p-6 hover:bg-blue-50 transition ease-in-out">
                      <input type="file" id="photo_identite" name="photo_identite" accept="image/*" class="hidden" onchange="previewIdentityPhoto(event)">
                      <label for="photo_identite" class="block text-center cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="mt-2 block text-sm font-medium text-gray-700">Glissez-déposez votre photo ou cliquez pour sélectionner</span>
                        <span class="mt-1 block text-xs text-gray-500">Format JPG, PNG (max. 2MB)</span>
                      </label>
                    </div>
                    
                    <!-- Preview -->
                    <div id="previewIdentityContainer" class="mt-4 hidden">
                      <img id="identityImagePreview" class="mx-auto rounded-lg shadow-lg w-32 h-32 object-cover" alt="Aperçu de la photo d'identité">
                      <button id="removeIdentityImage" class="mt-2 text-red-500 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="block text-sm">Supprimer l'image</span>
                      </button>
                    </div>
                  </div>
                  
                  </div>
                
                
                <button 
                type="submit" 
                id="submitBtn"
                class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-all duration-300 transform hover:scale-102 pulse"
              >
                inscrire Moniteur
              </button>
                </div>
              </form>
              
              <div class="text-center mt-6 animate__animated animate__fadeIn" style="animation-delay: 1s;">
             
              </div>
            </div>
          </div>
        
        
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

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

  function previewProfilePhoto(event) {
              const file = event.target.files[0];
              if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                  const preview = document.getElementById('profileImagePreview');
                  preview.src = reader.result;
                  document.getElementById('previewProfileContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
              }
            }
          
            function previewIdentityPhoto(event) {
              const file = event.target.files[0];
              if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                  const preview = document.getElementById('identityImagePreview');
                  preview.src = reader.result;
                  document.getElementById('previewIdentityContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
              }
            }
          
            document.getElementById('removeProfileImage').addEventListener('click', function() {
              document.getElementById('photo-profile').value = '';
              document.getElementById('previewProfileContainer').classList.add('hidden');
            });
          
            document.getElementById('removeIdentityImage').addEventListener('click', function() {
              document.getElementById('photo_identite').value = '';
              document.getElementById('previewIdentityContainer').classList.add('hidden');
            });
          
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init();
            const animateForm = () => {
        const inputs = document.querySelectorAll('input');
        inputs.forEach((input, index) => {
          setTimeout(() => {
            input.classList.add('focus-within:ring-2');
          }, 100 * index);
        });
      };
      
      setTimeout(animateForm, 500);
      
      const inputs = document.querySelectorAll('input');
      inputs.forEach(input => {
        input.addEventListener('focus', () => {
          input.style.transition = 'all 0.3s ease';
        });
      });
      
      const logo = document.querySelector('.logo-spin');
      if (logo) {
        logo.addEventListener('mouseover', () => {
          logo.style.animation = 'logoRotate 1.5s ease';
        });
        
        logo.addEventListener('animationend', () => {
          logo.style.animation = '';
        });
      }
    });

    //fetch 
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Inscription en cours...';

    const formData = new FormData(this);

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            body: formData,
            credentials: 'include'
        });

        const data = await response.json();

        if (!response.ok) {
            throw data;
        }

        window.location.href = '/connecter'; 
    } catch (error) {
        console.error('Erreur:', error);
        alert(error.error || 'Une erreur est survenue');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'S\'inscrire';
    }
});


    </script>
</body>

</html>
