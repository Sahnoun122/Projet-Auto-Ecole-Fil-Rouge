<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-École</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <header class="bg-white py-4 shadow-sm">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ url('resources/photoss/logo.png') }}" alt="Logo" class="h-10">
            </div>
            
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-blue-600">Accueil</a>
                <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600">Services</a>
                <a href="#" class="text-gray-600 hover:text-blue-600">À propos</a>
                <a href="#" class="text-gray-600 hover:text-blue-600">Contact</a>
            </nav>
            
            <div class="hidden md:flex space-x-4">
                <a href="#" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Connexion</a>
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Register</a>
            </div>
            
            <button id="burger-btn" class="md:hidden text-gray-600 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t mt-4">
            <div class="container mx-auto px-6 py-4">
                <nav class="flex flex-col space-y-4">
                    <a href="#" class="text-gray-600 hover:text-blue-600 py-2 border-b border-gray-100">Accueil</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 py-2 border-b border-gray-100">Services</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 py-2 border-b border-gray-100">À propos</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 py-2">Contact</a>
                </nav>
                
                <div class="mt-6 flex flex-col space-y-4">
                    <a href="#" class="px-4 py-2 border border-gray-300 rounded text-center text-gray-700 hover:bg-gray-100">Connexion</a>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-center text-white rounded hover:bg-indigo-700">Register</a>
                </div>
            </div>
        </div>
    </header>

    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 md:pr-12">
                <h1 class="text-4xl font-bold text-indigo-700 mb-2">Apprenez à</h1>
                <h1 class="text-4xl font-bold text-gray-800 mb-4">conduire en<br/>toute confiance !</h1>
                
                <p class="text-gray-700 mb-6">Des moniteurs qualifiés et des véhicules<br/>modernes pour vous accompagner.</p>
                
                <a href="#" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Register</a>
            </div>
            
            <div class="md:w-1/2 mt-10 md:mt-0">
                <img src="{{url('resources/photoss/logo.png')}}" alt="Voiture " class="w-full rounded-lg shadow-lg">
            </div>
        </div>
    </section>

     <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Nos Services</h2>

            <div class="flex flex-col md:flex-row mb-16 items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <img src="{{ url('resources/photoss/service1.png')}}" alt="Cours de conduite" class="rounded-lg shadow-md w-full">
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h3 class="text-2xl font-bold mb-4">Cours de Conduite.</h3>
                    <p class="text-gray-700 mb-6">
                        Nos cours de conduite sont adaptés à tous les niveaux, des débutants aux conducteurs expérimentés. 
                        Nous proposons des leçons individuelles et personnalisées pour vous aider à maîtriser la conduite en toute sécurité.
                    </p>
                    <div>
                        <h4 class="font-bold mb-2">Points Forts</h4>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Moniteurs diplômés et expérimentés.</li>
                            <li>Véhicules modernes et sécurisés.</li>
                            <li>Horaires flexibles.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row-reverse mb-16 items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <img src="{{ url('resources/photoss/service2.png')}}" alt="Code de la route" class="rounded-lg shadow-md w-full">
                </div>
                <div class="md:w-1/2 md:pr-12">
                    <h3 class="text-2xl font-bold mb-4">Code de la Route</h3>
                    <p class="text-gray-700 mb-6">
                        Préparez-vous à l'examen théorique avec nos cours interactifs et nos supports pédagogiques. 
                        Nous vous accompagnons jusqu'à l'obtention de votre code.
                    </p>
                    <div>
                        <h4 class="font-bold mb-2">Points Forts</h4>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Cours en salle et en ligne.</li>
                            <li>Tests blancs pour vous entraîner.</li>
                            <li>Suivi personnalisé.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Examens Pratiques -->
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <img src="{{ url('resources/photoss/service3.png')}}" alt="Examen pratique" class="rounded-lg shadow-md w-full">
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h3 class="text-2xl font-bold mb-4">Examens Pratiques</h3>
                    <p class="text-gray-700 mb-6">
                        Passez votre examen pratique dans les meilleures conditions avec nos véhicules et nos moniteurs. 
                        Nous vous préparons à affronter toutes les situations de conduite.
                    </p>
                    <div>
                        <h4 class="font-bold mb-2">Points Forts</h4>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Véhicules identiques à ceux de l'examen.</li>
                            <li>Moniteurs expérimentés.</li>
                            <li>Simulation d'examen.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>