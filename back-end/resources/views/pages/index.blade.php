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
                <a href="{{ route ('connecter')}}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100">Connexion</a>
                <a href="{{route ('register')}}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Register</a>
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
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Nos Services</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-car text-3xl text-gray-700"></i>

                    </div>
                    <h3 class="text-xl font-semibold mb-4">Cours de Conduite</h3>
                    <p class="text-gray-600 mb-6">Apprenez à conduire avec des moniteurs expérimentés.</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">En savoir plus</a>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-book text-3xl text-gray-700"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Code de la Route</h3>
                    <p class="text-gray-600 mb-6">Préparez-vous à l'examen théorique avec nos cours interactifs.</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">En savoir plus</a>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md text-center">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-tasks text-3xl text-gray-700"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Examens Pratiques</h3>
                    <p class="text-gray-600 mb-6">Passez votre examen de conduite dans les meilleures conditions.</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>


    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">À Propos de Nous</h2>
            
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 md:pr-12 mb-8 md:mb-0">
                    <img src="{{ url('photoss/about.png')}}" alt="Leçon de conduite" class="w-full rounded-lg shadow-lg">
                </div>
                
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-semibold mb-4">Pourquoi choisir notre auto-école ?</h3>
                    <p class="text-gray-600 mb-6">Une brève description de l'auto-école ici. "Fondée en 2010, notre auto-école a formé plus de 1000 candidats avec un taux de réussite de 95%."</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Avis des Candidats</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="flex justify-center text-yellow-400 mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-center mb-2">Alice Dupont</h4>
                    <p class="text-gray-600 text-center">Très professionnel, j'ai obtenu mon permis du premier coup !</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="flex justify-center text-yellow-400 mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-center mb-2">Jean Martin</h4>
                    <p class="text-gray-600 text-center">Les moniteurs sont très patients et pédagogues.</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="flex justify-center text-yellow-400 mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-center mb-2">Sophie Leroy</h4>
                    <p class="text-gray-600 text-center">Je recommande cette auto-école à tous mes amis !</p>
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