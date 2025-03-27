<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-École - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    
    <style>
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translatey(0px); }
            50% { transform: translatey(-10px); }
            100% { transform: translatey(0px); }
        }
        .nav-item {
            position: relative;
        }
        .nav-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #4f46e5;
            transition: width 0.3s ease;
        }
        .nav-item:hover::after {
            width: 100%;
        }
        
        /* Enhanced animations */
        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }
        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }
        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .rotate-in {
            animation: rotateIn 0.8s ease-out;
        }
        @keyframes rotateIn {
            0% { opacity: 0; transform: rotate(-20deg); }
            100% { opacity: 1; transform: rotate(0); }
        }
        
        .btn-hover {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-hover:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .btn-hover:hover:after {
            left: 100%;
        }
        
        .card-hover-effect {
            transition: all 0.4s ease;
        }
        .card-hover-effect:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white py-4 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="h-10 animate__animated animate__fadeIn">
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('/') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.1s;">Accueil</a>
                <a href="{{ route('services') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">Services</a>
                <a href="{{ route('propos') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.3s;">À propos</a>
                <a href="#" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.4s;">Contact</a>
            </nav>
            
            <div class="hidden md:flex space-x-4">
                {{-- <a href="{{ route ('connecter')}}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100 transition duration-300 animate__animated animate__fadeInRight" style="animation-delay: 0.3s;">Connexion</a> --}}
                {{-- <a href="{{route ('register')}}" class="px-4 py-2 gradient-bg text-white rounded hover:opacity-90 transition duration-300 transform hover:scale-105 btn-hover animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">Register</a> --}}
            </div>
            
            <button id="burger-btn" class="md:hidden text-gray-600 focus:outline-none animate__animated animate__fadeIn">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t mt-4">
            <div class="container mx-auto px-6 py-4">
                <nav class="flex flex-col space-y-4">
                    <a href="{{ route('/') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 slide-in-left">Accueil</a>
                    <a href="{{ route('services') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 slide-in-left" style="animation-delay: 0.1s;">Services</a>
                    <a href="{{ route('propos') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 slide-in-left" style="animation-delay: 0.2s;">À propos</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 py-2 transition duration-300 slide-in-left" style="animation-delay: 0.3s;">Contact</a>
                </nav>
                
                <div class="mt-6 flex flex-col space-y-4">
                    {{-- <a href="{{ route ('connecter')}}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100 transition duration-300 slide-in-left" style="animation-delay: 0.4s;">Connexion</a> --}}
                    {{-- <a href="{{route ('register')}}" class="px-4 py-2 gradient-bg text-white rounded hover:opacity-90 transition duration-300 transform hover:scale-105 btn-hover slide-in-left" style="animation-delay: 0.5s;">Register</a> --}}
                </div>
            </div>
        </div>
    </header>

    <section class="bg-gradient-to-r from-indigo-50 to-blue-50 py-20">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 md:pr-12" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="text-4xl font-bold text-indigo-700 mb-2">Apprenez à</h1>
                <h1 class="text-4xl font-bold text-gray-800 mb-4">conduire en<br/>toute confiance !</h1>
                
                <p class="text-gray-700 mb-6">Des moniteurs qualifiés et des véhicules<br/>modernes pour vous accompagner.</p>
                
                {{-- <a href="{{route ('register')}}" class="px-4 py-2 gradient-bg text-white rounded hover:opacity-90 transition duration-300 transform hover:scale-105 btn-hover animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">Register</a> --}}
            </div>
            
            <div class="md:w-1/2 mt-10 md:mt-0" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                <img src="{{url('storage/images/accueil.png')}}" alt="Voiture" class="w-full rounded-lg shadow-lg animate-float">
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12" data-aos="fade-up">Nos Services</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="service-card bg-white p-8 rounded-lg shadow-md text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-car text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Cours de Conduite</h3>
                    <p class="text-gray-600 mb-6">Apprenez à conduire avec des moniteurs expérimentés.</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700 transition duration-300">En savoir plus</a>
                </div>
                
                <div class="service-card bg-white p-8 rounded-lg shadow-md text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-book text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Code de la Route</h3>
                    <p class="text-gray-600 mb-6">Préparez-vous à l'examen théorique avec nos cours interactifs.</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700 transition duration-300">En savoir plus</a>
                </div>
                
                <div class="service-card bg-white p-8 rounded-lg shadow-md text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-tasks text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Examens Pratiques</h3>
                    <p class="text-gray-600 mb-6">Passez votre examen de conduite dans les meilleures conditions.</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700 transition duration-300">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12" data-aos="fade-up">À Propos de Nous</h2>
            
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 md:pr-12 mb-8 md:mb-0" data-aos="fade-right">
                    <img src="{{ url('photoss/about.png')}}" alt="Leçon de conduite" class="w-full rounded-lg shadow-lg">
                </div>
                
                <div class="md:w-1/2" data-aos="fade-left">
                    <h3 class="text-2xl font-semibold mb-4">Pourquoi choisir notre auto-école ?</h3>
                    <p class="text-gray-600 mb-6">Une brève description de l'auto-école ici. "Fondée en 2010, notre auto-école a formé plus de 1000 candidats avec un taux de réussite de 95%."</p>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition duration-300">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12" data-aos="fade-up">Avis des Candidats</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="100">
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
                    <h4 class="text-lg font-semibold text-center mb-2">janat sahnoun</h4>
                    <p class="text-gray-600 text-center">Très professionnel, j'ai obtenu mon permis du premier coup !</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="200">
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
                    <h4 class="text-lg font-semibold text-center mb-2">issa sahnoun</h4>
                    <p class="text-gray-600 text-center">Les moniteurs sont très patients et pédagogues.</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="300">
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
                    <h4 class="text-lg font-semibold text-center mb-2">maryam sahnoun</h4>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: false,
                mirror: true
            });
            
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