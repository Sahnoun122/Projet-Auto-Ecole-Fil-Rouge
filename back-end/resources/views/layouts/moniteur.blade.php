<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun - Moniteur</title> <!-- Changed title -->
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

<body class="bg-gray-100" x-data="{ sidebarOpen: window.innerWidth > 768 }" @resize.window="sidebarOpen = window.innerWidth > 768">
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
                'translate-x-0 w-64': sidebarOpen, 
                '-translate-x-full w-64 md:translate-x-0 md:w-20': !sidebarOpen 
            }"
            class="fixed md:static inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 flex flex-col overflow-hidden"
        >
            
            
            <div class="p-4 flex justify-end md:hidden" x-show="sidebarOpen">
                <button @click="sidebarOpen = false" class="text-gray-500 hover:text-[#4D44B5] focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div x-show="sidebarOpen || window.innerWidth >= 768" x-transition class="p-4 border-b flex justify-center">
                <div class="relative group">
                    <div class="absolute inset-0 bg-[#4D44B5] rounded-full opacity-10 group-hover:opacity-20 transition-opacity"></div>
                    <a href="{{ route('profile.show') }}" class="block">
                        <img 
                            src="{{ Auth::user()->profile_photo_url }}" 
                            alt="Photo de profil" 
                            :class="sidebarOpen ? 'h-20 w-20' : 'h-10 w-10'" 
                            class="object-cover rounded-full shadow-lg transition-all duration-300 group-hover:scale-105">
                    </a>
                </div>
            </div>
            
            <div x-show="sidebarOpen" x-transition class="text-center py-2 text-sm font-medium text-gray-700">
                <a href="{{ route('profile.show') }}" class="hover:text-[#4D44B5] transition">
                    {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </a>
            </div>

            
            <nav class="flex-1 py-4 overflow-hidden hover:overflow-y-auto">
                <a href="{{ route('moniteur.dashboard') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('moniteur.dashboard') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Tableau de bord</span>
                </a>

                <a href="{{ route('moniteur.candidats')}}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('moniteur.candidats') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Candidats</span>
                </a>

                <a href="{{ route('moniteur.conduite') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('moniteur.conduite') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 4a6 6 0 016 6h-2a4 4 0 00-8 0H6a6 6 0 016-6zm0 16a8 8 0 01-6.93-4h13.86A8 8 0 0112 22z" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Séances de Conduite</span>
                </a>

                <a href="{{ route('moniteur.vehicles') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('moniteur.vehicles') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /> 
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Véhicules</span>
                </a>

                <a href="{{ route('moniteur.exams') }}"
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600 {{ request()->routeIs('moniteur.exams') ? 'active-sidebar-item' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Examens</span>
                </a>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-moniteur').submit();" 
                   class="sidebar-item flex items-center px-4 py-3 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                    </svg>
                    <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Déconnexion</span>
                </a>
                <form id="logout-form-moniteur" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </div>

        <div class="flex-1 flex flex-col min-w-0">
            <div class="bg-white shadow-md flex justify-between items-center p-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-[#4D44B5] focus:outline-none md:hidden"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="hidden md:block">
                </div>

                <div class="relative" x-data="{ notificationsOpen: false }">
                    <button @click="notificationsOpen = !notificationsOpen" class="relative text-gray-500 hover:text-gray-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @auth
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        @endif
                        @endauth
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
                            @auth
                            @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" 
                               class="block px-4 py-3 hover:bg-gray-50"
                               onclick="markAsRead('{{ $notification->id }}')">
                                <p class="text-sm text-gray-900">{{ $notification->data['message'] }}</p>
                                <p class="text-xs text-gray-500">
                                    
                                    @if(isset($notification->data['type']) && $notification->data['type'] === 'nouveau_cours')
                                    Cours le {{ \Carbon\Carbon::parse($notification->data['date_heure'])->format('d/m/Y H:i') }}
                                    @elseif(isset($notification->data['exam_id']))
                                    <span class="text-[#4D44B5]">Examen</span> - 
                                    @endif
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </a>
                            @empty
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-500">Aucune nouvelle notification</p>
                            </div>
                            @endforelse
                            @else
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-500">Connectez-vous pour voir les notifications</p>
                            </div>
                            @endauth
                        </div>
                   
                    </div>
                </div>
            </div>
            
            @push('scripts')
            <script>
            function markAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        const notificationElement = document.querySelector(`a[onclick="markAsRead('${notificationId}')"]`);
                        if (notificationElement) {
                            notificationElement.remove();
                        }
                        
                        const unreadCount = document.querySelectorAll('.max-h-64 a[onclick^="markAsRead"]').length;
                        const badge = document.querySelector('.relative button svg + span');
                        if (unreadCount === 0 && badge) {
                            badge.remove();
                        }
                    }
                }).catch(error => {
                    console.error('Erreur:', error);
                });
            }
            </script>
            @endpush
            
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6"> 
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
    @stack('scripts') 
</body>
</html>