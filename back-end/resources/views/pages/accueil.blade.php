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
                <a href="#" class="text-gray-600 hover:text-blue-600">Accueil</a>
                <a href="#" class="text-gray-600 hover:text-blue-600">Services</a>
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