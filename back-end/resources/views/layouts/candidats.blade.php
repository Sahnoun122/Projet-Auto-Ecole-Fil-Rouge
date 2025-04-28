<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .sidebar-item {
            transition: all 0.3s ease;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.7);
            color: #4D44B5;
        }
        .sidebar-item:hover svg {
            color: #4D44B5;
        }
        .active-sidebar-item {
            background-color: rgba(255, 255, 255, 0.7);
            color: #4D44B5;
        }
        .active-sidebar-item svg {
            color: #4D44B5;
        }
    </style>
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: false }" @resize.window="sidebarOpen = window.innerWidth > 768">
    <div class="flex h-screen">
        <div 
            x-show="sidebarOpen && window.innerWidth < 768"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <div 
            :class="{
                'w-64': sidebarOpen,
                'w-0 -translate-x-full md:translate-x-0 md:w-20': !sidebarOpen
            }"
            class="fixed md:static inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 flex flex-col overflow-hidden"
        >
            <div class="p-4 flex justify-between items-center border-b">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-[#4D44B5] focus:outline-none">
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div x-show="sidebarOpen" x-transition class="p-4 border-b flex justify-center">
                <div class="relative group">
                    <div class="absolute inset-0 bg-[#4D44B5] rounded-full opacity-10 group-hover:opacity-20 transition-opacity"></div>
                    <a href="{{ route('profile.show') }}" class="block">
                        <img 
                            src="{{ Auth::user()->profile_photo_url }}" 
                            alt="Photo de profil" 
                            class="h-20 w-20 object-cover rounded-full shadow-lg transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>
            </div>
            
            <div x-show="sidebarOpen" x-transition class="text-center py-2 text-sm font-medium text-gray-700">
                <a href="{{ route('profile.show') }}" class="hover:text-[#4D44B5] transition">
                    {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </a>
            </div>

=            <nav class="flex-1 py-4 overflow-hidden hover:overflow-y-auto">
                <a href="{{ route('candidats.dashboard') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('candidats.dashboard') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Tableau de bord</span>
                </a>

                <a href="{{ route('candidats.titres') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('candidats.titres') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Théorique</span>
                </a>

                <a href="{{ route('candidats.quizzes') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('candidats.quizzes') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Pratique</span>
                </a>

                <a href="{{ route('candidats.conduite') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('candidats.conduite') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 4a6 6 0 016 6h-2a4 4 0 00-8 0H6a6 6 0 016-6zm0 16a8 8 0 01-6.93-4h13.86A8 8 0 0112 22z" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours de Conduite</span>
                </a>

                <a href="{{ route('candidats.exams') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('candidats.exams') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Examen</span>
                </a>

                <a href="{{ route('candidats.paiements')}}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Caisse</span>
                </a>

                <a href="{{ route('logout') }}"
                class="sidebar-item flex items-center px-4 py-3 text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                </svg>
                 <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Caisse</span>
             </a> 
             
            </nav>
        </div>

        <div class="flex-1 flex flex-col min-w-0">
            <div class="bg-white shadow">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none md:hidden">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="ml-3 text-lg font-semibold text-gray-800 md:hidden">Auto-école Sahnoun</h1>
                    </div>
                    
                    <div class="relative" x-data="{ notificationsOpen: false }">
                        <button @click="notificationsOpen = !notificationsOpen" class="relative text-gray-500 hover:text-gray-600 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </button>
                        
                        <div x-show="notificationsOpen" 
                             @click.away="notificationsOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                    <p class="text-sm text-gray-900">Nouveau cours disponible</p>
                                    <p class="text-xs text-gray-500">Il y a 5 minutes</p>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                    <p class="text-sm text-gray-900">Examen programmé</p>
                                    <p class="text-xs text-gray-500">Il y a 1 heure</p>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                    <p class="text-sm text-gray-900">Résultat disponible</p>
                                    <p class="text-xs text-gray-500">Il y a 3 heures</p>
                                </a>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-100">
                                <a href="#" class="text-sm text-[#4D44B5] hover:text-[#6058b8] font-medium">Voir toutes les notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('layout', () => ({
                init() {
                    this.sidebarOpen = window.innerWidth > 768;
                }
            }));
        });
    </script>
</body>
</html>