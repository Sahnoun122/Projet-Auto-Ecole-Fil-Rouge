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
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('/') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.1s;">Accueil</a>
                <a href="{{ route('services') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">Services</a>
                <a href="{{ route('propos') }}" class="nav-item text-gray-600 hover:text-indigo-600 transition duration-300 animate__animated animate__fadeInDown" style="animation-delay: 0.3s;">À propos</a>
                
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

    <section class="py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-4" data-aos="fade-up">Nos Services</h2>
            <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">Découvrez notre gamme complète de services conçus pour vous aider à devenir un conducteur confiant et compétent.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Cours de Conduite -->
                <div class="service-card bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="150">
                    <div class="relative">
                        <img src="{{asset('storage/images/service1.png')}}" alt="Cours de conduite" class="w-full h-56 object-cover">
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-transparent to-black opacity-60"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-3 text-indigo-700">Cours de Conduite</h3>
                        <p class="text-gray-700 mb-4">
                            Nos cours de conduite sont adaptés à tous les niveaux, des débutants aux conducteurs expérimentés.
                        </p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Moniteurs diplômés et expérimentés</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Véhicules modernes et sécurisés</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Horaires flexibles</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="relative">
                        <img src="{{asset('storage/images/service2.png')}}" alt="Code de la route" class="w-full h-56 object-cover">
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-transparent to-black opacity-60"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-3 text-indigo-700">Code de la Route</h3>
                        <p class="text-gray-700 mb-4">
                            Préparez-vous à l'examen théorique avec nos cours interactifs et nos supports pédagogiques.
                        </p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Cours en salle et en ligne</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Tests blancs pour vous entraîner</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Suivi personnalisé</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="450">
                    <div class="relative">
                        <img src="{{ asset('storage/images/service3.png')}}" alt="Examen pratique" class="w-full h-56 object-cover">
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-transparent to-black opacity-60"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-3 text-indigo-700">Examens Pratiques</h3>
                        <p class="text-gray-700 mb-4">
                            Passez votre examen pratique dans les meilleures conditions avec nos véhicules et nos moniteurs.
                        </p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Véhicules identiques à ceux de l'examen</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Moniteurs expérimentés</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Simulation d'examen</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

      
        </div>
    </section>

    <section class="py-16 bg-indigo-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">Pourquoi nous choisir?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="mb-4 text-indigo-600 text-4xl flex justify-center">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Moniteurs Expérimentés</h3>
                    <p class="text-gray-600">Notre équipe de moniteurs possède une grande expérience dans l'enseignement de la conduite.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="mb-4 text-indigo-600 text-4xl flex justify-center">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Véhicules Modernes</h3>
                    <p class="text-gray-600">Nous utilisons des véhicules récents et bien entretenus pour vos leçons de conduite et examens.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="mb-4 text-indigo-600 text-4xl flex justify-center">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Taux de Réussite Élevé</h3>
                    <p class="text-gray-600">Notre approche pédagogique assure un taux de réussite supérieur à la moyenne nationale.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="mb-4 text-indigo-600 text-4xl flex justify-center">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Horaires Flexibles</h3>
                    <p class="text-gray-600">Nous nous adaptons à votre emploi du temps pour des cours à des heures qui vous conviennent.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
                    <img src="{{asset('storage/images/permis.jpg')}}" alt="Témoignages" class="rounded-lg shadow-lg w-full">
                </div>
                <div class="md:w-1/2 md:pl-12" data-aos="fade-left">
                    <h2 class="text-3xl font-bold mb-8">Ce que nos élèves disent</h2>
                    
                    <div class="testimonial-slider">
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-indigo-500">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400 flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="text-gray-700 italic mb-4">"Grâce à mon moniteur patient et pédagogue, j'ai réussi mon permis du premier coup ! Je recommande vivement cette auto-école."</p>
                            <p class="font-semibold">khadija sahnoun</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-indigo-500">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400 flex">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="text-gray-700 italic mb-4">"Formation complète et de qualité. Les cours de code en ligne m'ont permis d'apprendre à mon rythme. Je suis très satisfait !"</p>
                            <p class="font-semibold">issa sahnoun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 gradient-bg text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8" data-aos="fade-up">Prêt à prendre le volant ?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">Inscrivez-vous dès maintenant et commencez votre formation à la conduite avec les meilleurs moniteurs.</p>
            <a href="{{ route('register')}}" class="inline-block px-8 py-3 bg-white text-indigo-700 rounded-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105" data-aos="fade-up" data-aos-delay="200">S'inscrire maintenant</a>
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

    <a href="#" id="back-to-top" class="fixed bottom-6 right-6 p-3 bg-indigo-600 text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 transform hover:scale-110">
        <i class="fas fa-arrow-up"></i>
    </a>

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
            
            const backToTopButton = document.getElementById('back-to-top');
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });
            
            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            const testimonials = document.querySelectorAll('.testimonial-slider > div');
            let currentTestimonial = 0;
            
            function showNextTestimonial() {
                testimonials[currentTestimonial].classList.add('animate__animated', 'animate__fadeOut');
                
                setTimeout(() => {
                    testimonials[currentTestimonial].style.display = 'none';
                    testimonials[currentTestimonial].classList.remove('animate__fadeOut');
                    
                    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
                    
                    testimonials[currentTestimonial].style.display = 'block';
                    testimonials[currentTestimonial].classList.add('animate__animated', 'animate__fadeIn');
                }, 500);
            }
            
            for (let i = 1; i < testimonials.length; i++) {
                testimonials[i].style.display = 'none';
            }
            
            setInterval(showNextTestimonial, 5000);
            
            const serviceCards = document.querySelectorAll('.service-card');
            
            function checkScroll() {
                serviceCards.forEach(card => {
                    const cardTop = card.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (cardTop < windowHeight * 0.85) {
                        card.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            }
            
     
            function animateValue(obj, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    obj.innerHTML = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }
            
     
        });
    </script>
</body>
</html>