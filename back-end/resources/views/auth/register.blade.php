 <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sahnoun - Créer un compte</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

  <meta name="csrf-token" content="{{ csrf_token() }}">
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
          {{-- <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul> --}}
      </div>
  @endif

  <form id="registerForm" method="POST" action="http://127.0.0.1:8000/api/register" enctype="multipart/form-data" class="space-y-6">
    @csrf
      <input type="hidden" name="_token" value="votre_token_csrf_ici">
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
          <input type="hidden" name="role"  value="candidat">
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="fade-in-up" style="animation-delay: 0.1s;">
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
          <div class="fade-in-up" style="animation-delay: 0.2s;">
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
          <input type="hidden" name="role"  value="candidat">
        </div>


        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="fade-in-up" style="animation-delay: 0.1s;">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
            <input 
              type="text" 
              id="address" 
              name="adresse"
              value=""
              value="{{ old('adresse') }}"
              placeholder="Adresse"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            >
          </div>
          <div class="fade-in-up" style="animation-delay: 0.2s;">
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
          <input type="hidden" name="role"  value="candidat">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  
          <div class="fade-in-up" style="animation-delay: 0.8s;">
            <label for="photo-profile" class="block text-sm font-medium text-gray-700 mb-2">Photo de Profil</label>
            <div class="relative border-2 border-dashed border-blue-500 rounded-lg p-6 hover:bg-blue-50 transition ease-in-out">
              <input 
                type="file" 
                id="photo-profile" 
                name="photo_profile"
                accept="image/*"
                class="hidden"
                onchange="previewProfilePhoto(event)"
              >
              <label for="photo-profile" class="block text-center cursor-pointer">
                <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-700">Glissez-déposez votre photo ou cliquez pour sélectionner</span>
                <span class="mt-1 block text-xs text-gray-500">Format JPG, PNG (max. 2MB)</span>
              </label>
            </div>
            
            <!-- Preview -->
            <div id="previewProfileContainer" class="mt-4 hidden">
              <img id="profileImagePreview" class="mx-auto rounded-lg shadow-lg w-32 h-32 object-cover" alt="Aperçu de la photo de profil">
              <button id="removeProfileImage" class="mt-2 text-red-500 hover:text-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="block text-sm">Supprimer l'image</span>
              </button>
            </div>
          </div>
          
          <div class="fade-in-up">
            <label for="photo_identite" class="block text-sm font-medium text-gray-700 mb-2">Photo d'identité</label>
            <div class="relative border-2 border-dashed border-blue-500 rounded-lg p-6 hover:bg-blue-50 transition ease-in-out">
              <input type="file" id="photo_identite" name="photo_identite" accept="image/*" class="hidden" onchange="previewIdentityPhoto(event)">
              <label for="photo_identite" class="block text-center cursor-pointer">
                <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-700">Glissez-déposez votre photo ou cliquez pour sélectionner</span>
                <span class="mt-1 block text-xs text-gray-500">Format JPG, PNG (max. 2MB)</span>
              </label>
            </div>
            
            <!-- Preview -->
            <div id="previewIdentityContainer" class="mt-4 hidden">
              <img id="identityImagePreview" class="mx-auto rounded-lg shadow-lg w-32 h-32 object-cover" alt="Aperçu de la photo d'identité">
              <button id="removeIdentityImage" class="mt-2 text-red-500 hover:text-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="block text-sm">Supprimer l'image</span>
              </button>
            </div>
          </div>
          
          </div>
        
        
        <button 
        type="submit" 
        id="submitBtn"
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
            function previewProfilePhoto(event) {
              const file = event.target.files[0];
              if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                  const preview = document.getElementById('profileImagePreview');
                  preview.src = reader.result;
                  document.getElementById('previewProfileContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
              }
            }
          
            function previewIdentityPhoto(event) {
              const file = event.target.files[0];
              if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                  const preview = document.getElementById('identityImagePreview');
                  preview.src = reader.result;
                  document.getElementById('previewIdentityContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
              }
            }
          
            document.getElementById('removeProfileImage').addEventListener('click', function() {
              document.getElementById('photo-profile').value = '';
              document.getElementById('previewProfileContainer').classList.add('hidden');
            });
          
            // Supprimer la photo d'identité
            document.getElementById('removeIdentityImage').addEventListener('click', function() {
              document.getElementById('photo_identite').value = '';
              document.getElementById('previewIdentityContainer').classList.add('hidden');
            });
          
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


    //fetch 
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Inscription en cours...';

    const formData = new FormData(this);

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            body: formData,
            credentials: 'include'
        });

        const data = await response.json();

        if (!response.ok) {
            throw data;
        }

        window.location.href = data.redirect;

    } catch (error) {
        console.error('Erreur:', error);
        alert(error.error || 'Une erreur est survenue');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'S\'inscrire';
    }
});



  </script>


</body>
</html> 