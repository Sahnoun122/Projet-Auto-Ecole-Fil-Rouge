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


    <style>
        .hidden {
            display: none;
        }

        .flex {
            display: flex;
        }

        .fixed {
            position: fixed;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        @media (max-width: 640px) {
            .question-card {
                width: 100%;
            }

            .modal-content {
                width: 95%;
                margin: 10px auto;
            }

            .choice-item {
                flex-direction: column;
                gap: 8px;
            }

            .choice-item input[type="text"] {
                width: 100%;
            }
        }
    </style>
</head>

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
                            <svg id="cours-theorique-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Cours Pratique</span>
                            <svg id="cours-pratique-arrow" class="ml-auto h-4 w-4 transition-transform"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div id="cours-pratique-list"
                            class="pl-8 overflow-hidden transition-all duration-300 max-h-0">
                            <a href="{{ route('admin.AjouterQuiz') }} "
                                class="sidebar-item flex items-center px-4 py-2 text-gray-600 hover:text-primary transition-colors">
                                <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Ajouter Cours Pratique</span>
                            </a>
                            <a href="{{ route('admin.AjouterQuiz') }}"
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
                            <svg id="vehicule-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
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
                            <svg id="examen-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
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
                            <svg id="moniteurs-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
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
                            <svg id="caisse-arrow" class="ml-auto h-4 w-4 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
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
                        <div id="logout-button"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-600 hover:text-primary transition-colors cursor-pointer"
                            id="logoutButton">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H3" />
                            </svg>
                            <span :class="sidebarOpen ? 'block ml-3' : 'hidden'">Déconnexion</span>
                        </div>

                    </div>
                </nav>
            </div>

        </div>

        <div class="bg-[#4D44B5] text-white shadow-md">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">Questions pour: {{ $quiz->title }}</h1>
                    <p class="text-white opacity-80 text-sm md:text-base">{{ $quiz->description }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                    <a href="{{ route('admin.AjouterQuiz') }}"
                        class="bg-white text-[#4D44B5] px-3 py-1 md:px-4 md:py-2 rounded-lg font-medium hover:bg-gray-100 transition text-center text-sm md:text-base">
                        <i class="fas fa-arrow-left mr-2"></i>Retour aux Quiz
                    </a>
                    <button onclick="openQuestionModal('{{ $quiz->id }}')"
                        class="bg-white text-[#4D44B5] px-3 py-1 md:px-4 md:py-2 rounded-lg font-medium hover:bg-gray-100 transition text-sm md:text-base">
                        <i class="fas fa-plus mr-2"></i>Nouvelle Question
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <div class="flex justify-between items-center">
                        <p class="text-sm md:text-base">{{ session('success') }}</p>
                        <button type="button" class="text-green-700"
                            onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                @if ($questions->isEmpty())
                    <div class="text-center p-6 md:p-12">
                        <div
                            class="mx-auto w-16 h-16 md:w-24 md:h-24 bg-gray-100 rounded-full flex items-center justify-center mb-3 md:mb-4">
                            <i class="fas fa-question text-gray-400 text-xl md:text-3xl"></i>
                        </div>
                        <h3 class="text-base md:text-lg font-medium text-gray-900 mb-1 md:mb-2">Aucune question
                            disponible</h3>
                        <p class="text-gray-500 text-sm md:text-base mb-4 md:mb-6">Commencez par créer votre première
                            question pour ce quiz.</p>
                        <button onclick="openQuestionModal('{{ $quiz->id }}')"
                            class="bg-[#4D44B5] text-white px-4 py-1 md:px-6 md:py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition text-sm md:text-base">
                            <i class="fas fa-plus mr-2"></i>Créer une question
                        </button>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 p-4 md:p-6">
                        @foreach ($questions as $question)
                            <div
                                class="question-card bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                                <div class="p-3 md:p-5">
                                    <div class="flex justify-between items-start mb-2 md:mb-3">
                                        <h3 class="text-base md:text-lg font-semibold text-[#4D44B5] line-clamp-2"
                                            title="{{ $question->question_text }}">
                                            {{ $loop->iteration }}. {{ Str::limit($question->question_text, 50) }}
                                        </h3>
                                        <button type="button" onclick="deleteQuestion('{{ $question->id }}')"
                                            class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    @if ($question->image_path)
                                        <div
                                            class="mb-2 md:mb-3 rounded-lg overflow-hidden h-32 md:h-40 flex items-center justify-center bg-gray-100">
                                            <img src="{{ asset('storage/' . $question->image_path) }}"
                                                class="max-h-full max-w-full object-contain cursor-pointer"
                                                alt="Image de question"
                                                onclick="showQuestionDetails('{{ $question->id }}')">
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between mb-2 md:mb-3">
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs px-2 py-0.5 rounded-full flex items-center">
                                            <i class="fas fa-clock mr-1"></i> {{ $question->duration }}s
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ count($question->choices) }} choix
                                        </span>
                                    </div>

                                    <button onclick="showQuestionDetails('{{ $question->id }}')"
                                        class="w-full mt-1 md:mt-2 bg-[#4D44B5] bg-opacity-10 text-[#4D44B5] hover:bg-opacity-20 px-2 py-1 md:px-3 md:py-1 rounded-lg text-xs md:text-sm font-medium transition">
                                        Voir détails
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>

        <div id="questionDetailsModal"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-2 md:p-4">
            <div
                class="bg-white w-full max-w-md md:max-w-2xl rounded-lg overflow-hidden max-h-[90vh] overflow-y-auto modal-content">
                <div class="bg-[#4D44B5] text-white px-4 py-3 md:px-6 md:py-4 flex justify-between items-center">
                    <h2 class="text-lg md:text-xl font-bold">Détails de la question</h2>
                    <button onclick="closeModal('questionDetailsModal')"
                        class="text-white hover:text-gray-200 text-lg">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 md:p-6" id="questionDetailsContent">
                    <div class="flex justify-center items-center py-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#4D44B5]"></div>
                        <span class="ml-3">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="questionModal"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-2 md:p-4">
            <div
                class="bg-white w-full max-w-md md:max-w-2xl rounded-lg overflow-hidden max-h-[90vh] overflow-y-auto modal-content">
                <div class="bg-[#4D44B5] text-white px-4 py-3 md:px-6 md:py-4">
                    <h2 class="text-lg md:text-xl font-bold" id="modalQuestionTitle">Nouvelle Question</h2>
                </div>
                <form id="questionForm" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
                    @csrf
                    <input type="hidden" id="quizId" name="quiz_id">
                    <input type="hidden" id="questionId" name="question_id">

                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <label for="questionText"
                                class="block text-sm md:text-base font-medium text-gray-700 mb-1">Texte de la question
                                *</label>
                            <textarea id="questionText" name="question_text" rows="3"
                                class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base"
                                required></textarea>
                        </div>

                        <div>
                            <label
                                class="block text-sm md:text-base font-medium text-gray-700 mb-1 md:mb-2">Image</label>
                            <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-4">
                                <div class="relative w-full">
                                    <input type="file" id="questionImage" name="image" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div id="imagePreviewContainer" class="hidden flex-shrink-0">
                                    <div
                                        class="relative w-20 h-20 md:w-24 md:h-24 rounded-lg overflow-hidden border border-gray-200">
                                        <img id="imagePreview" class="w-full h-full object-cover">
                                        <button type="button" onclick="removeImage()"
                                            class="absolute top-0.5 right-0.5 md:top-1 md:right-1 bg-red-500 text-white rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="removeImageFlag" name="remove_image" value="0">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div>
                                <label for="questionDuration"
                                    class="block text-sm md:text-base font-medium text-gray-700 mb-1">Durée (secondes)
                                    *</label>
                                <input type="number" id="questionDuration" name="duration" min="5"
                                    max="300" value="30"
                                    class="w-full px-3 py-2 md:px-4 md:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base"
                                    required>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-sm md:text-base font-medium text-gray-700">Choix de réponse *</h3>
                                <button type="button" id="addChoiceBtn"
                                    class="text-[#4D44B5] hover:text-[#3a32a1] text-xs md:text-sm font-medium flex items-center">
                                    <i class="fas fa-plus-circle mr-1"></i>Ajouter un choix
                                </button>
                            </div>

                            <div id="choicesContainer" class="space-y-2 md:space-y-3">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 md:mt-8 flex justify-end space-x-2 md:space-x-3">
                        <button type="button" id="cancelQuestionBtn"
                            class="px-4 py-1 md:px-6 md:py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium text-sm md:text-base">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-4 py-1 md:px-6 md:py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition font-medium text-sm md:text-base">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="successToast" class="hidden fixed top-4 right-4 z-50">
            <div
                class="bg-green-500 text-white px-4 py-3 md:px-6 md:py-4 rounded-lg shadow-lg flex items-center text-sm md:text-base">
                <i class="fas fa-check-circle mr-2"></i>
                <span id="successMessage"></span>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function toggleModal(modalId, show = true) {
                const modal = document.getElementById(modalId);
                if (show) {
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                } else {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            function closeModal(modalId) {
                toggleModal(modalId, false);
            }

            function showQuestionDetails(questionId) {
                const modalContent = $('#questionDetailsContent');

                modalContent.html(`
                            <div class="flex justify-center items-center py-4">
                                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#4D44B5]"></div>
                                <span class="ml-3">Chargement...</span>
                            </div>
                        `);

                toggleModal('questionDetailsModal');

                $.ajax({
                    url: `/admin/questions/${questionId}/details`,
                    method: 'GET',
                    success: function(response) {
                        const question = response.question;

                        const detailsHtml = `
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#4D44B5] mb-3">${question.question_text || 'Sans texte'}</h3>
                                        
                                        ${question.image_url ? `
                                                <div class="mb-4 flex justify-center">
                                                    <img src="${question.image_url}" 
                                                         onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'text-red-500\'>Image non disponible</div>';"
                                                         class="rounded-lg border border-gray-200 max-w-full h-auto max-h-48" 
                                                         alt="Image de question">
                                                </div>
                                                ` : `<p class="text-gray-400 mb-4">Aucune image</p>`}
                                        
                                        <div class="mb-4 flex items-center justify-between">
                                            <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full flex items-center">
                                                <i class="fas fa-clock mr-1"></i> ${question.duration || 0} secondes
                                            </span>
                                            <div class="flex space-x-3">
                                                <button onclick="openEditModal('${question.id}')" 
                                                        class="text-[#4D44B5] hover:text-[#3a32a1] text-sm flex items-center">
                                                    <i class="fas fa-edit mr-1"></i> Modifier
                                                </button>
                                                <button onclick="deleteQuestion('${question.id}')" 
                                                        class="text-red-500 hover:text-red-700 text-sm flex items-center">
                                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <h4 class="font-medium text-gray-700 mb-2">Choix de réponses:</h4>
                                        <div class="space-y-2">
                                            ${question.choices.map((choice, index) => `
                                                        <div class="flex items-center p-3 rounded-lg ${choice.is_correct ? 'bg-green-50 border border-green-200' : 'bg-gray-50'}">
                                                            <span class="font-medium mr-3">${String.fromCharCode(65 + index)}.</span>
                                                            <span class="${choice.is_correct ? 'font-medium text-green-600' : 'text-gray-700'}">
                                                                ${choice.choice_text || 'Choix sans texte'}
                                                            </span>
                                                            ${choice.is_correct ? `
                                                    <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">
                                                        Bonne réponse
                                                    </span>
                                                    ` : ''}
                                                        </div>
                                                    `).join('')}
                                        </div>
                                    </div>
                                `;

                        modalContent.html(detailsHtml);
                    },
                    error: function(xhr) {
                        let errorMsg = 'Erreur lors du chargement des détails';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        modalContent.html(`
                                    <div class="text-center py-4 text-red-500">
                                        <i class="fas fa-exclamation-circle text-xl mb-2"></i>
                                        <p>${errorMsg}</p>
                                        <button onclick="retryLoadDetails('${questionId}')" 
                                                class="mt-2 px-3 py-1 bg-[#4D44B5] text-white rounded hover:bg-[#3a32a1] text-sm">
                                            <i class="fas fa-redo mr-1"></i> Réessayer
                                        </button>
                                    </div>
                                `);
                    }
                });
            }

            function retryLoadDetails(questionId) {
                showQuestionDetails(questionId);
            }

            function openEditModal(questionId) {
                closeModal('questionDetailsModal');
                openQuestionModal($('#quizId').val(), questionId);
            }

            function openQuestionModal(quizId, questionId = null) {
                const $form = $('#questionForm');
                $form[0].reset();
                $('#imagePreviewContainer').addClass('hidden');
                $('#choicesContainer').empty();
                $('#quizId').val(quizId);

                if (questionId) {
                    $('#modalQuestionTitle').text('Modifier la question');
                    $form.attr('action', `/admin/questions/${questionId}`);
                    $form.find('input[name="_method"]').remove();
                    $form.append('<input type="hidden" name="_method" value="PUT">');
                    $('#questionId').val(questionId);

                    $.ajax({
                        url: `/admin/questions/${questionId}/edit`,
                        method: 'GET',
                        success: function(data) {
                            $('#questionText').val(data.question.question_text);
                            $('#questionDuration').val(data.question.duration);

                            if (data.question.image_path) {
                                $('#imagePreview').attr('src', `/storage/${data.question.image_path}`);
                                $('#imagePreviewContainer').removeClass('hidden');
                            }

                            data.choices.forEach((choice, index) => {
                                addChoiceToForm(choice.choice_text, choice.is_correct, choice.id, index);
                            });
                        },
                        error: function() {
                            showToast('Erreur lors du chargement de la question', false);
                            closeModal('questionModal');
                        }
                    });
                } else {
                    $('#modalQuestionTitle').text('Nouvelle Question');
                    $form.attr('action', `/admin/${quizId}/questions`);
                    $form.find('input[name="_method"]').remove();
                    $('#questionId').val('');
                    addChoiceToForm('', true);
                    addChoiceToForm('', false);
                }

                toggleModal('questionModal');
            }

            function addChoiceToForm(text = '', isCorrect = false, choiceId = null, index = null) {
                const $container = $('#choicesContainer');
                const newIndex = index !== null ? index : $container.children().length;

                if ($container.children().length >= 5) {
                    showToast('Maximum 5 choix par question', false);
                    return;
                }

                const choiceHtml = `
                            <div class="choice-item p-2 md:p-3 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3">
                                    <div class="flex items-center gap-2 md:gap-3">
                                        <input type="radio" name="correct_choice" value="${newIndex}" 
                                               class="h-4 w-4 text-[#4D44B5] border-gray-300 focus:ring-[#4D44B5]"
                                               ${isCorrect ? 'checked' : ''}>
                                        <input type="text" name="choices[${newIndex}][text]" 
                                               class="flex-1 px-2 py-1 md:px-3 md:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm md:text-base" 
                                               placeholder="Texte du choix" 
                                               value="${text}" required>
                                    </div>
                                    <div class="flex justify-end md:block">
                                        <button type="button" class="remove-choice-btn text-gray-400 hover:text-red-500 p-1 rounded-full text-sm"
                                                ${$container.children().length < 2 ? 'disabled' : ''}>
                                            <i class="fas fa-times"></i> Supprimer
                                        </button>
                                    </div>
                                    <input type="hidden" name="choices[${newIndex}][id]" value="${choiceId || ''}">
                                </div>
                            </div>
                        `;

                $container.append(choiceHtml);
                updateRemoveButtons();
            }

            function updateRemoveButtons() {
                const $container = $('#choicesContainer');
                $container.find('.remove-choice-btn').each(function() {
                    $(this).prop('disabled', $container.children().length <= 2);
                });
            }

            function deleteQuestion(questionId) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cette question?')) return;

                $.ajax({
                    url: `/admin/questions/${questionId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        window.location.reload();
                    },
                    error: function() {
                        showToast('Erreur lors de la suppression', false);
                    }
                });
            }

            function removeImage() {
                $('#imagePreviewContainer').addClass('hidden');
                $('#questionImage').val('');
                $('#removeImageFlag').val('1');
            }

            function showToast(message, isSuccess = true) {
                const toast = $('#successToast');
                const toastMessage = $('#successMessage');

                toastMessage.text(message);
                toast.removeClass('hidden bg-red-500').addClass(isSuccess ? 'bg-green-500' : 'bg-red-500');

                setTimeout(() => {
                    toast.addClass('hidden');
                }, 3000);
            }

            $(document).ready(function() {
                $('#questionImage').change(function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#imagePreviewContainer').removeClass('hidden');
                            $('#imagePreview').attr('src', e.target.result);
                            $('#removeImageFlag').val('0');
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                $('#addChoiceBtn').click(function() {
                    addChoiceToForm();
                });

                $('#choicesContainer').on('click', '.remove-choice-btn', function() {
                    if ($(this).prop('disabled')) return;

                    const $container = $('#choicesContainer');
                    if ($container.children().length <= 2) {
                        showToast('Minimum 2 choix requis', false);
                        return;
                    }

                    const $choiceItem = $(this).closest('.choice-item');
                    if ($choiceItem.find('input[type="radio"]').prop('checked')) {
                        $container.find('input[type="radio"]').first().prop('checked', true);
                    }

                    $choiceItem.remove();
                    updateRemoveButtons();
                });

                $('#cancelQuestionBtn').click(function() {
                    closeModal('questionModal');
                });

                $('#questionForm').submit(function(e) {
                    e.preventDefault();

                    const $form = $(this);
                    const formData = new FormData(this);
                    const $submitBtn = $form.find('button[type="submit"]');
                    const originalBtnText = $submitBtn.html();

                    if (!$form.find('input[name="correct_choice"]:checked').length) {
                        showToast('Veuillez sélectionner une réponse correcte', false);
                        return;
                    }

                    $submitBtn.prop('disabled', true);
                    $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...');

                    $.ajax({
                        url: $form.attr('action'),
                        method: $form.attr('method'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            showToast(xhr.responseJSON?.message ||
                                'Erreur lors de l\'enregistrement', false);
                        },
                        complete: function() {
                            $submitBtn.prop('disabled', false);
                            $submitBtn.html(originalBtnText);
                        }
                    });
                });
            });


            document.addEventListener("DOMContentLoaded", function() {
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
        </script>
</body>

</html>
