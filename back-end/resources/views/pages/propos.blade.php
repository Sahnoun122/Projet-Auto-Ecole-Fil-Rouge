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
        <div class="container mx-auto px-4">
            <h2 class="text-3xl  text-center mb-16">
                À propos
            </h2>
            
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-6 text-indigo-600">À propos de l'auto-école Sahnoun</h3>
                        <p class="text-gray-700 mb-4">
                            Bienvenue à l'auto-école Sahnoun, votre partenaire de confiance pour l'apprentissage de la conduite à Safi. 
                            Depuis notre création en 2025, nous avons aidé des milliers d'élèves à obtenir leur permis de conduire en toute sécurité et confiance.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
                    <div class="md:flex">
                        <div class="md:w-2/5 bg-indigo-600 text-white p-8 flex items-center justify-center">
                            <h3 class="text-2xl font-bold">Notre Histoire</h3>
                        </div>
                        <div class="md:w-3/5 p-8">
                            <p class="text-gray-700 leading-relaxed">
                                L'auto-école Sahnoun a été fondée par khadija Sahnoun avec la vision de fournir une formation de conduite de haute qualité,
                                 axée sur la sécurité routière et le respect des règles de circulation.
                                  Au fil des années, nous avons élargi nos services pour répondre aux besoins variés de nos élèves,
                                   qu'ils soient débutants ou conducteurs expérimentés cherchant à améliorer leurs compétences.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-6 text-indigo-600">Nos Valeurs</h3>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            Chez Sahnoun, nous croyons en des valeurs fondamentales qui guident notre approche pédagogique :
                        </p>
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-indigo-600">
                                <h4 class="font-bold text-lg mb-3 text-gray-800">Sécurité avant tout</h4>
                                <p class="text-gray-600">La sécurité de nos élèves et de tous les usagers de la route est notre priorité absolue.</p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-indigo-600">
                                <h4 class="font-bold text-lg mb-3 text-gray-800">Qualité d'enseignement</h4>
                                <p class="text-gray-600">Nous nous engageons à fournir une formation de qualité, dispensée par des instructeurs expérimentés et certifiés.</p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-indigo-600">
                                <h4 class="font-bold text-lg mb-3 text-gray-800">Confiance et respect</h4>
                                <p class="text-gray-600">Nous valorisons une relation de confiance et de respect mutuel entre nos élèves et nos instructeurs.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-3/5 p-8">
                            <h3 class="text-2xl font-bold mb-6 text-indigo-600">Notre Équipe</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Notre équipe est composée de professionnels dévoués et passionnés par l'enseignement de la conduite. Nos instructeurs sont non seulement des experts en conduite, mais aussi des éducateurs patients et empathiques qui sont là pour vous soutenir à chaque étape de votre apprentissage.
                            </p>
                        </div>
                        <div class="md:w-2/5 bg-cover bg-center" style="background-image: url('team.jpg');">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-indigo-600 py-12 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-4">Prêt à commencer votre formation ?</h2>
            <p class="text-indigo-100 mb-6 max-w-2xl mx-auto">Rejoignez les milliers d'élèves satisfaits qui ont obtenu leur permis avec l'auto-école Sahnoun.</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="px-6 py-3 bg-white text-indigo-600 font-medium rounded-md hover:bg-gray-100 transition duration-300">Nous contacter</a>
                <a href="#" class="px-6 py-3 bg-indigo-700 text-white font-medium rounded-md hover:bg-indigo-800 transition duration-300">S'inscrire maintenant</a>
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