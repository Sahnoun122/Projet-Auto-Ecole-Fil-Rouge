<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sahnoun - Inscription Candidat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
  <style>
    @keyframes float {
      0% { transform: translatey(0px); }
      50% { transform: translatey(-10px); }
      100% { transform: translatey(0px); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    
    @keyframes fadeInUp {
      from { opacity: 0; transform: translate3d(0, 20px, 0); }
      to { opacity: 1; transform: translate3d(0, 0, 0); }
    }
    .fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    .pulse { animation: pulse 2s infinite; }
    
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
      position: fixed;
      height: 100vh;
      width: 40%;
      top: 0;
      left: 0;
      overflow-y: auto;
    }
    
    @keyframes logoRotate {
      0% { transform: rotateY(0deg); }
      100% { transform: rotateY(360deg); }
    }
    .logo-spin { transition: all 0.5s ease; }
    .logo-spin:hover { animation: logoRotate 1.5s ease; }
    
    .error-message {
      color: #ef4444;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    .input-error {
      border-color: #ef4444 !important;
    }

    .right-side {
      margin-left: 40%;
      width: 60%;
    }

    @media (max-width: 767px) {
      .animated-bg {
        position: relative;
        width: 100%;
        height: auto;
      }
      .right-side {
        margin-left: 0;
        width: 100%;
      }
    }

    .file-upload-container {
      border: 2px dashed #4f46e5;
      border-radius: 0.5rem;
      padding: 1.5rem;
      transition: all 0.3s ease;
    }
    .file-upload-container:hover {
      background-color: #f0f9ff;
    }
  </style>
</head>
<body class="flex flex-col md:flex-row min-h-screen w-full">
  <div class="hidden md:flex animated-bg text-white p-8 flex-col items-center justify-center">
    <div class="mb-8 animate__animated animate__fadeIn">
      <a href="{{ route('/') }}"> <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-64"></a>
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

  <div class="right-side bg-white p-8 flex flex-col justify-center">
    <div class="max-w-lg mx-auto w-full">
      <h2 class="text-3xl font-bold text-gray-800 mb-6 animate__animated animate__fadeInDown">Inscription </h2>
      
      @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      @endif

      <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="role" value="candidat">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Nom -->
          <div class="fade-in-up" style="animation-delay: 0.1s;">
            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
            <input 
              type="text" 
              id="nom" 
              name="nom"
              value="{{ old('nom') }}"
              placeholder="Votre nom"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
              
            >
            <p id="nom-error" class="error-message"></p>
          </div>

          <div class="fade-in-up" style="animation-delay: 0.2s;">
            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
            <input 
              type="text" 
              id="prenom" 
              name="prenom"
              value="{{ old('prenom') }}"
              placeholder="Votre prénom"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
              
            >
            <p id="prenom-error" class="error-message"></p>
          </div>
        </div>

        <!-- Email -->
        <div class="fade-in-up" style="animation-delay: 0.3s;">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
          <input 
            type="email" 
            id="email" 
            name="email"
            value="{{ old('email') }}"
            placeholder="exemple@email.com"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            
          >
          <p id="email-error" class="error-message"></p>
        </div>

        <div class="fade-in-up" style="animation-delay: 0.4s;">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
          <input 
            type="password" 
            id="password" 
            name="password"
            placeholder="••••••••"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            
          >
          <p id="password-error" class="error-message"></p>
          <p class="mt-1 text-xs text-gray-500">
            Doit contenir au moins 8 caractères, dont une majuscule, une minuscule et un chiffre.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="fade-in-up" style="animation-delay: 0.5s;">
            <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
            <input 
              type="text" 
              id="adresse" 
              name="adresse"
              value="{{ old('adresse') }}"
              placeholder="Votre adresse"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
              
            >
            <p id="adresse-error" class="error-message"></p>
          </div>

          <div class="fade-in-up" style="animation-delay: 0.6s;">
            <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
            <input 
              type="tel" 
              id="telephone" 
              name="telephone"
              value="{{ old('telephone') }}"
              placeholder="0612345678"
              class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
              
            >
            <p id="telephone-error" class="error-message"></p>
          </div>
        </div>

        <div class="fade-in-up" style="animation-delay: 0.7s;">
          <label for="type_permis" class="block text-sm font-medium text-gray-700 mb-1">Type de permis *</label>
          <select 
            id="type_permis" 
            name="type_permis"
            class="w-full px-4 py-3 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            
          >
            <option value="">Sélectionnez un type</option>
            <option value="A" {{ old('type_permis') == 'A' ? 'selected' : '' }}>Permis A (Moto)</option>
            <option value="B" {{ old('type_permis') == 'B' ? 'selected' : '' }}>Permis B (Voiture)</option>
            <option value="C" {{ old('type_permis') == 'C' ? 'selected' : '' }}>Permis C (Poids lourd)</option>
            <option value="D" {{ old('type_permis') == 'D' ? 'selected' : '' }}>Permis D (Bus)</option>
            <option value="EB" {{ old('type_permis') == 'EB' ? 'selected' : '' }}>Permis EB (Remorque)</option>
            <option value="A1" {{ old('type_permis') == 'A1' ? 'selected' : '' }}>Permis A1 (Moto légère)</option>
            <option value="A2" {{ old('type_permis') == 'A2' ? 'selected' : '' }}>Permis A2 (Moto intermédiaire)</option>
            <option value="B1" {{ old('type_permis') == 'B1' ? 'selected' : '' }}>Permis B1 (Quadricycle lourd)</option>
            <option value="C1" {{ old('type_permis') == 'C1' ? 'selected' : '' }}>Permis C1 (Poids lourd moyen)</option>
            <option value="D1" {{ old('type_permis') == 'D1' ? 'selected' : '' }}>Permis D1 (Bus moyen)</option>
            <option value="BE" {{ old('type_permis') == 'BE' ? 'selected' : '' }}>Permis BE (Remorque lourde)</option>
            <option value="C1E" {{ old('type_permis') == 'C1E' ? 'selected' : '' }}>Permis C1E (PL + remorque)</option>
            <option value="D1E" {{ old('type_permis') == 'D1E' ? 'selected' : '' }}>Permis D1E (Bus + remorque)</option>
          </select>
          <p id="type_permis-error" class="error-message"></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="fade-in-up" style="animation-delay: 0.8s;">
            <label for="photo_profile" class="block text-sm font-medium text-gray-700 mb-2">Photo de profil *</label>
            <div class="file-upload-container">
              <input 
                type="file" 
                id="photo_profile" 
                name="photo_profile"
                accept="image/*"
                class="hidden"
                onchange="previewProfilePhoto(event)"
              
              >
              <label for="photo_profile" class="block text-center cursor-pointer">
                <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-700">Glissez-déposez votre photo ou cliquez pour sélectionner</span>
                <span class="mt-1 block text-xs text-gray-500">Format JPG, PNG (max. 2MB)</span>
              </label>
              <p id="photo_profile-error" class="error-message"></p>
            </div>
            <div id="previewProfileContainer" class="mt-4 hidden">
              <img id="profileImagePreview" class="mx-auto rounded-lg shadow-lg w-32 h-32 object-cover" alt="Aperçu de la photo de profil">
              <button type="button" id="removeProfileImage" class="mt-2 text-red-500 hover:text-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="block text-sm">Supprimer l'image</span>
              </button>
            </div>
          </div>
          
          <div class="fade-in-up" style="animation-delay: 0.9s;">
            <label for="photo_identite" class="block text-sm font-medium text-gray-700 mb-2">Photo d'identité *</label>
            <div class="file-upload-container">
              <input 
                type="file" 
                id="photo_identite" 
                name="photo_identite"
                accept="image/*"
                class="hidden"
                onchange="previewIdentityPhoto(event)"
                
              >
              <label for="photo_identite" class="block text-center cursor-pointer">
                <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-700">Glissez-déposez votre photo ou cliquez pour sélectionner</span>
                <span class="mt-1 block text-xs text-gray-500">Format JPG, PNG (max. 2MB)</span>
              </label>
              <p id="photo_identite-error" class="error-message"></p>
            </div>
            <div id="previewIdentityContainer" class="mt-4 hidden">
              <img id="identityImagePreview" class="mx-auto rounded-lg shadow-lg w-32 h-32 object-cover" alt="Aperçu de la photo d'identité">
              <button type="button" id="removeIdentityImage" class="mt-2 text-red-500 hover:text-red-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="block text-sm">Supprimer l'image</span>
              </button>
            </div>
          </div>
        </div>
        

        <div class="fade-in-up" style="animation-delay: 1.1s;">
          <button 
            type="submit"
            id="submitBtn"
            class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-all duration-300 transform hover:scale-102 pulse"
          >
            S'inscrire
          </button>
        </div>
      </form>

      <div class="text-center mt-6 animate__animated animate__fadeIn" style="animation-delay: 1.2s;">
        <p class="text-gray-600">
          Déjà membre ? 
          <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline transition-all duration-200">Se connecter</a>
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
      document.getElementById('photo_profile').value = '';
      document.getElementById('previewProfileContainer').classList.add('hidden');
    });

    document.getElementById('removeIdentityImage').addEventListener('click', function() {
      document.getElementById('photo_identite').value = '';
      document.getElementById('previewIdentityContainer').classList.add('hidden');
    });

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      let isValid = true;
      const requiredFields = [
        'nom', 'prenom', 'email', 'password', 'adresse', 'telephone', 'type_permis',
        'photo_profile', 'photo_identite'
      ];

      requiredFields.forEach(field => {
        const element = document.getElementById(field);
        const errorElement = document.getElementById(`${field}-error`);
        
        if (!element.value.trim()) {
          showError(element, errorElement, "Ce champ est obligatoire");
          isValid = false;
        } else {
          clearError(element, errorElement);
        }
      });

      const terms = document.getElementById('terms');
      const termsError = document.getElementById('terms-error');
      if (!terms.checked) {
        showError(terms, termsError, "Vous devez accepter les conditions");
        isValid = false;
      } else {
        clearError(terms, termsError);
      }

      if (!isValid) {
        e.preventDefault();
      }
    });

    function showError(input, errorElement, message) {
      input.classList.add('input-error');
      if (errorElement) {
        errorElement.textContent = message;
      }
    }

    function clearError(input, errorElement) {
      input.classList.remove('input-error');
      if (errorElement) {
        errorElement.textContent = '';
      }
    }

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

    const patterns = {
      name: /^[a-zA-ZÀ-ÿ\s'-]{2,50}$/,
      email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/,
      password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/,
      phone: /^[0-9]{10,15}$/
    };

    function validateName(input) {
      const errorElement = document.getElementById(`${input.id}-error`);
      if (!patterns.name.test(input.value)) {
        showError(input, errorElement, "Veuillez entrer un nom valide (2-50 caractères)");
        return false;
      } else {
        clearError(input, errorElement);
        return true;
      }
    }

    function validateEmail(input) {
      const errorElement = document.getElementById(`${input.id}-error`);
      if (!patterns.email.test(input.value)) {
        showError(input, errorElement, "Veuillez entrer une adresse email valide");
        return false;
      } else {
        clearError(input, errorElement);
        return true;
      }
    }

    function validatePassword(input) {
      const errorElement = document.getElementById(`${input.id}-error`);
      if (!patterns.password.test(input.value)) {
        showError(input, errorElement, "Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial");
        return false;
      } else {
        clearError(input, errorElement);
        return true;
      }
    }

    function validatePhone(input) {
      const errorElement = document.getElementById(`${input.id}-error`);
      if (!patterns.phone.test(input.value)) {
        showError(input, errorElement, "Veuillez entrer un numéro de téléphone valide (10-15 chiffres)");
        return false;
      } else {
        clearError(input, errorElement);
        return true;
      }
    }

    function validateFile(input, errorId, allowedExtensions) {
      const errorElement = document.getElementById(errorId);
      if (input.files.length > 0) {
        const file = input.files[0];
        const extension = file.name.split('.').pop().toLowerCase();
        const isValid = allowedExtensions.includes(extension);
        
        if (!isValid) {
          showError(input, errorElement, `Format non supporté. Utilisez: ${allowedExtensions.join(', ')}`);
          return false;
        } else if (file.size > 2 * 1024 * 1024) { // 2MB
          showError(input, errorElement, "La taille du fichier ne doit pas dépasser 2MB");
          return false;
        } else {
          clearError(input, errorElement);
          return true;
        }
      } else {
        showError(input, errorElement, "Ce champ est obligatoire");
        return false;
      }
    }

    function validateTerms() {
      const checkbox = document.getElementById('terms');
      const errorElement = document.getElementById('terms-error');
      if (!checkbox.checked) {
        showError(checkbox, errorElement, "Vous devez accepter les conditions");
        return false;
      } else {
        clearError(checkbox, errorElement);
        return true;
      }
    }

    function showError(input, errorElement, message) {
      input.classList.add('input-error');
      errorElement.textContent = message;
    }

    function clearError(input, errorElement) {
      input.classList.remove('input-error');
      errorElement.textContent = '';
    }

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
      document.getElementById('photo_profile').value = '';
      document.getElementById('previewProfileContainer').classList.add('hidden');
      clearError(document.getElementById('photo_profile'), document.getElementById('photo_profile-error'));
    });

    document.getElementById('removeIdentityImage').addEventListener('click', function() {
      document.getElementById('photo_identite').value = '';
      document.getElementById('previewIdentityContainer').classList.add('hidden');
      clearError(document.getElementById('photo_identite'), document.getElementById('photo_identite-error'));
    });

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      let isValid = true;
      
      isValid &= validateName(document.getElementById('nom'));
      isValid &= validateName(document.getElementById('prenom'));
      isValid &= validateEmail(document.getElementById('email'));
      isValid &= validatePassword(document.getElementById('password'));
      isValid &= validatePhone(document.getElementById('telephone'));
      isValid &= validateFile(document.getElementById('photo_profile'), 'photo_profile-error', ['jpg', 'jpeg', 'png']);
      isValid &= validateFile(document.getElementById('photo_identite'), 'photo_identite-error', ['jpg', 'jpeg', 'png']);
      isValid &= validateTerms();
      
      // Check select field
      const typePermis = document.getElementById('type_permis');
      const typePermisError = document.getElementById('type_permis-error');
      if (typePermis.value === '') {
        showError(typePermis, typePermisError, "Veuillez sélectionner un type de permis");
        isValid = false;
      } else {
        clearError(typePermis, typePermisError);
      }
      
      const adresse = document.getElementById('adresse');
      const adresseError = document.getElementById('adresse-error');
      if (adresse.value.trim() === '') {
        showError(adresse, adresseError, "Veuillez entrer une adresse");
        isValid = false;
      } else {
        clearError(adresse, adresseError);
      }
      
      if (!isValid) {
        e.preventDefault();
      }
    });

    
  </script>
</body>
</html>