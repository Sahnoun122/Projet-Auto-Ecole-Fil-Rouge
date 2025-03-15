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
                <a href="{{ route('/') }}" class="text-gray-600 hover:text-blue-600">Accueil</a>
                <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600">Services</a>
                <a href="{{ route('propos') }}" class="text-gray-600 hover:text-blue-600">À propos</a>
                <a href="#" class="text-gray-600 hover:text-blue-600">Contact</a>
            </nav>
            
            <div class="hidden md:flex space-x-4">
                <a href="" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Connexion</a>
                <a href="{{route('register')}}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Register</a>
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

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <p class="text-sm">Copyright © 2025 Nom de l'Auto-École. Tous droits réservés.</p>
                </div>
                
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-sm font-semibold mb-4">Services</h4>
                        <ul class="text-sm">
                            <li class="mb-2"><a href="#" class="text-gray-300 hover:text-white">À propos</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-semibold mb-4">Accueil</h4>
                        <ul class="text-sm">
                            <li class="mb-2"><a href="#" class="text-gray-300 hover:text-white">Contact</a></li>
                            <li class="mb-2"><a href="#" class="text-gray-300 hover:text-white">Politique de confidentialité</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="pt-8 mt-8 border-t border-gray-700 flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-white">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const burgerBtn = document.getElementById('burger-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            burgerBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                
                const icon = burgerBtn.querySelector('i');
                if (mobileMenu.classList.contains('hidden')) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                }
            });
        });
    </script>
</body>
</html>