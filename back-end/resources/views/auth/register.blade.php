<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sahnoun - Créer un compte</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
  
  <style>
    @keyframes float {
      0% { transform: translatey(0px); }
      50% { transform: translatey(-10px); }
      100% { transform: translatey(0px); }
    }
    
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translate3d(0, 20px, 0);
      }
      to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
      }
    }
    
    .fade-in-up {
      animation: fadeInUp 0.6s ease-out forwards;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    .pulse {
      animation: pulse 2s infinite;
    }
    
    .input-hover-effect {
      transition: all 0.3s ease;
      border-left: 0px solid transparent;
    }
    
    .input-hover-effect:focus {
      border-left: 4px solid #4f46e5;
      box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
    }
    
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    .animated-bg {
      background: linear-gradient(-45deg, #4f46e5, #6366f1, #818cf8, #4f46e5);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
    }
    
    @keyframes logoRotate {
      0% { transform: rotateY(0deg); }
      100% { transform: rotateY(360deg); }
    }
    
    .logo-spin {
      transition: all 0.5s ease;
    }
    
    .logo-spin:hover {
      animation: logoRotate 1.5s ease;
    }
  </style>
</head>
<body class="flex flex-col md:flex-row h-screen w-full">
  <div class="hidden md:flex animated-bg text-white w-full md:w-2/5 p-8 flex-col items-center justify-center relative">
    <div class="mb-8 animate__animated animate__fadeIn">
      <img src="{{ url('resources/photoss/logo.png') }}" alt="Logo" class="w-64 logo-spin animate-float">
    </div>
    
    <div class="text-center mb-16 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
      <h1 class="text-4xl font-bold mb-2">Bon retour parmi nous !</h1>
      <p class="text-lg text-indigo-100 mt-4">Chez Sahnoun, nous simplifions chaque étape pour vous.</p>
    </div>
    
    <div class="absolute bottom-10 left-10 animate-float" style="animation-delay: 1s;">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="rgba(255,255,255,0.3)"/>
      </svg>
    </div>
    <div class="absolute top-20 right-10 animate-float" style="animation-delay: 0.5s;">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="12" cy="12" r="10" fill="rgba(255,255,255,0.2)"/>
      </svg>
    </div>
    <div class="absolute top-40 left-20 animate-float" style="animation-delay: 1.5s;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="4" y="4" width="16" height="16" rx="2" fill="rgba(255,255,255,0.25)"/>
      </svg>
    </div>
  </div>

  <div class="bg-white w-full md:w-3/5 p-8 flex flex-col justify-center">
    <div class="max-w-lg mx-auto w-full">
      <h2 class="text-3xl font-bold text-gray-800 mb-6 animate__animated animate__fadeInDown">Créez votre compte</h2>
      @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="fade-in-up" style="animation-delay: 0.1s;">
            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input 
              type="text" 
              id="nom" 
              value="{{ old('nom') }}"
              name="nom"
              placeholder="Nom"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            >
          </div>
          <div class="fade-in-up" style="animation-delay: 0.2s;">
            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
            <input 
              type="text" 
              id="prenom" 
              value="{{ old('prenom') }}"
              name="prenom"
              placeholder="Prenom"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            >
          </div>
        </div>
        
        <div class="fade-in-up" style="animation-delay: 0.3s;">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input 
            type="email" 
            id="email" 
            value="{{ old('email') }}"
            name="email"
            placeholder="Email"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
          >
        </div>
        
        <div class="fade-in-up" style="animation-delay: 0.4s;">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
          <input 
            type="password" 
            id="password" 
            value=""
            name="password"
            placeholder="Mot de passe"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
          >
        </div>
        
        <div class="fade-in-up" style="animation-delay: 0.5s;">
          <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
          <input 
            type="text" 
            id="address" 
            value=""
            value="{{ old('adresse') }}"
            placeholder="Adresse"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
          >
        </div>

        <div class="fade-in-up" style="animation-delay: 0.6s;">
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
          <input 
            type="tel" 
            id="telephone" 
            value="{{ old('telephone') }}"
            name="telephone"
            placeholder="Téléphone"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
          >
        </div>
        
        <div class="fade-in-up" style="animation-delay: 0.7s;">
          <label for="licenseType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis</label>
          <input 
            type="text" 
            id="licenseType" 
            value="{{ old('type-permis') }}"
            name="type-permis"
            placeholder="Type de permis"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
          >
        </div>
        
        <div class="fade-in-up" style="animation-delay: 0.8s;">
          <label for="photos" class="block text-sm font-medium text-gray-700 mb-1">Photos</label>
          <div class="relative">
            <input 
              type="file" 
              id="photos-identité" 
              value=""
              name="photos-identité"
              placeholder="photos identité"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            >
            <span class="absolute right-2 top-2 text-indigo-500">
                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
              </svg>
            </span>
          </div>
        </div>

        <div class="fade-in-up" style="animation-delay: 0.8s;">
          <label for="photos" class="block text-sm font-medium text-gray-700 mb-1">Photos</label>
          <div class="relative">
            <input 
              type="file" 
              id="photos-profile" 
              value=""
              name="photos-profile"
              placeholder="photos profile"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            >
            <span class="absolute right-2 top-2 text-indigo-500">
                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
              </svg>
            </span>
          </div>
        </div>
        
        <div class="fade-in-up" style="animation-delay: 0.9s;">
          <button 
            type="submit" 
            class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-all duration-300 transform hover:scale-102 pulse"
          >
            S'inscrire
          </button>
        </div>
      </form>
      
      <div class="text-center mt-6 animate__animated animate__fadeIn" style="animation-delay: 1s;">
        <p class="text-gray-600">
          Déjà membre ? 
          <a href="{{ route ('connecter') }}" class="text-indigo-600 font-medium hover:underline transition-all duration-200">Se connecter</a>
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init();
            const animateForm = () => {
        const inputs = document.querySelectorAll('input');
        inputs.forEach((input, index) => {
          setTimeout(() => {
            input.classList.add('focus-within:ring-2');
          }, 100 * index);
        });
      };
      
      setTimeout(animateForm, 500);
      
      const inputs = document.querySelectorAll('input');
      inputs.forEach(input => {
        input.addEventListener('focus', () => {
          input.style.transition = 'all 0.3s ease';
        });
      });
      
      const logo = document.querySelector('.logo-spin');
      if (logo) {
        logo.addEventListener('mouseover', () => {
          logo.style.animation = 'logoRotate 1.5s ease';
        });
        
        logo.addEventListener('animationend', () => {
          logo.style.animation = '';
        });
      }
    });
  </script>

  
</body>
</html>