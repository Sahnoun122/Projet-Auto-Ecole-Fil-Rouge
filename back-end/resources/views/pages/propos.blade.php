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
                <a href="{{ route('/') }}"> <img src="{{ asset('storage/images/logo.png') }}" alt="Logo Auto-École" class="h-20 w-auto animate__animated animate__fadeIn"> </a>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('/') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.1s;">Accueil</a>
                <a href="{{ route('services') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">Services</a>
                <a href="{{ route('propos') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.3s;">À propos</a>
            </nav>
            
            <div class="hidden md:flex space-x-4">
                <a href="{{ route ('login')}}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100 transition duration-300 animate__animated animate__fadeInRight" style="animation-delay: 0.3s;">Connexion</a>
                <a href="{{route ('register')}}" class="px-4 py-2 gradient-bg text-white rounded hover:opacity-90 transition duration-300 transform hover:scale-105 btn-hover animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">Register</a>
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
                </nav>
                
                <div class="mt-6 flex flex-col space-y-4">
                    <a href="{{ route ('login')}}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100 transition duration-300 slide-in-left" style="animation-delay: 0.4s;">Connexion</a>
                    <a href="{{route ('register')}}" class="px-4 py-2 gradient-bg text-white rounded hover:opacity-90 transition duration-300 transform hover:scale-105 btn-hover slide-in-left" style="animation-delay: 0.5s;">Register</a>
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
                
                <a href="{{route ('register')}}" class="px-4 py-2 gradient-bg text-white rounded hover:opacity-90 transition duration-300 transform hover:scale-105 btn-hover animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">Register</a>
            </div>
            
            <div class="md:w-1/2 mt-10 md:mt-0" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                <img src="{{asset('storage/images/accueil.png')}}" alt="Voiture" class="w-full rounded-lg shadow-lg animate-float">
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl text-center mb-16" data-aos="fade-up" data-aos-duration="800">
                À propos
            </h2>
            
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12 card-hover-effect" data-aos="fade-up" data-aos-duration="800">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-6 text-indigo-600 slide-in-left">À propos de l'auto-école Sahnoun</h3>
                        <p class="text-gray-700 mb-4 fade-in-up" style="animation-delay: 0.2s;">
                            Bienvenue à l'auto-école Sahnoun, votre partenaire de confiance pour l'apprentissage de la conduite à Safi. 
                            Depuis notre création en 2025, nous avons aidé des milliers d'élèves à obtenir leur permis de conduire en toute sécurité et confiance.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12 card-hover-effect" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="md:flex">
                        <div class="md:w-2/5 bg-indigo-600 text-white p-8 flex items-center justify-center">
                            <h3 class="text-2xl font-bold rotate-in">Notre Histoire</h3>
                        </div>
                        <div class="md:w-3/5 p-8">
                            <p class="text-gray-700 leading-relaxed slide-in-right">
                                L'auto-école Sahnoun a été fondée par khadija Sahnoun avec la vision de fournir une formation de conduite de haute qualité,
                                 axée sur la sécurité routière et le respect des règles de circulation.
                                  Au fil des années, nous avons élargi nos services pour répondre aux besoins variés de nos élèves,
                                   qu'ils soient débutants ou conducteurs expérimentés cherchant à améliorer leurs compétences.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12 card-hover-effect" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-6 text-indigo-600 slide-in-left">Nos Valeurs</h3>
                        <p class="text-gray-700 mb-6 leading-relaxed fade-in-up" style="animation-delay: 0.2s;">
                            Chez Sahnoun, nous croyons en des valeurs fondamentales qui guident notre approche pédagogique :
                        </p>
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-indigo-600" data-aos="zoom-in" data-aos-delay="100">
                                <h4 class="font-bold text-lg mb-3 text-gray-800">Sécurité avant tout</h4>
                                <p class="text-gray-600">La sécurité de nos élèves et de tous les usagers de la route est notre priorité absolue.</p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-indigo-600" data-aos="zoom-in" data-aos-delay="200">
                                <h4 class="font-bold text-lg mb-3 text-gray-800">Qualité d'enseignement</h4>
                                <p class="text-gray-600">Nous nous engageons à fournir une formation de qualité, dispensée par des instructeurs expérimentés et certifiés.</p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-indigo-600" data-aos="zoom-in" data-aos-delay="300">
                                <h4 class="font-bold text-lg mb-3 text-gray-800">Confiance et respect</h4>
                                <p class="text-gray-600">Nous valorisons une relation de confiance et de respect mutuel entre nos élèves et nos instructeurs.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover-effect" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="md:flex">
                        <div class="md:w-3/5 p-8">
                            <h3 class="text-2xl font-bold mb-6 text-indigo-600 slide-in-left">Notre Équipe</h3>
                            <p class="text-gray-700 leading-relaxed fade-in-up" style="animation-delay: 0.2s;">
                                Notre équipe est composée de professionnels dévoués et passionnés par l'enseignement de la conduite. Nos instructeurs sont non seulement des experts en conduite, mais aussi des éducateurs patients et empathiques qui sont là pour vous soutenir à chaque étape de votre apprentissage.
                            </p>
                        </div>
                        <div class="md:w-2/5 bg-cover bg-center" style="background-image: url('team.jpg');" data-aos="zoom-in">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-indigo-600 py-12 text-white" data-aos="fade-up" data-aos-duration="800">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-4 animate__animated animate__fadeInUp">Prêt à commencer votre formation ?</h2>
            <p class="text-indigo-100 mb-6 max-w-2xl mx-auto animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">Rejoignez les milliers d'élèves satisfaits qui ont obtenu leur permis avec l'auto-école Sahnoun.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{route('register')}}" class="px-6 py-3 bg-indigo-700 text-white font-medium rounded-md hover:bg-indigo-800 transition duration-300 btn-hover animate__animated animate__fadeInUp pulse" style="animation-delay: 0.4s;">S'inscrire maintenant</a>
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
            // Initialize AOS
            AOS.init({
                once: false,
                mirror: false,
                duration: 800
            });
            
            // Mobile menu toggle
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
            
            // Add scroll animations
            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY;
                
                // Add additional scroll-triggered animations here if needed
                if (scrollPosition > 100) {
                    document.querySelector('header').classList.add('shadow-md');
                } else {
                    document.querySelector('header').classList.remove('shadow-md');
                }
            });
            
            // Add animation to elements when they come into view
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.card-hover-effect');
                elements.forEach(function(element) {
                    const position = element.getBoundingClientRect();
                    if (position.top < window.innerHeight && position.bottom >= 0) {
                        element.classList.add('shadow-lg');
                    }
                });
            };
            
            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll(); // Run once on page load
        });
    </script>

</body>
</html>