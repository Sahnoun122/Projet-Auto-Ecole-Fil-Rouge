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

        <div class="fade-in-up" style="animation-delay: 0.8s;">
            <label class="block text-sm font-medium text-gray-700 mb-2">Avez-vous déjà un permis de conduire ? *</label>
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="avez_vous_permis" value="1" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" {{ old('avez_vous_permis') == '1' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Oui</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="avez_vous_permis" value="0" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" {{ old('avez_vous_permis', '0') == '0' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Non</span>
                </label>
            </div>
             <p id="avez_vous_permis-error" class="error-message"></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="fade-in-up" style="animation-delay: 0.8s;">
            <label for="photo_profile" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil *</label>
            <input 
              type="file" 
              id="photo_profile" 
              name="photo_profile"
              accept="image/*"
              class="block w-full text-sm text-gray-500
                     file:mr-4 file:py-2 file:px-4
                     file:rounded-md file:border-0
                     file:text-sm file:font-semibold
                     file:bg-indigo-50 file:text-indigo-700
                     hover:file:bg-indigo-100"
              onchange="previewProfilePhoto(event)"
            >
            <p id="photo_profile-error" class="error-message mt-1"></p>
            <div id="previewProfileContainer" class="mt-2 hidden flex items-center space-x-2">
              <img id="profileImagePreview" class="rounded-md w-16 h-16 object-cover" alt="Aperçu profil">
              <span id="profileFileName" class="text-sm text-gray-600 truncate"></span>
              <button type="button" id="removeProfileImage" class="ml-auto text-xs text-red-600 hover:text-red-800 transition">Supprimer</button>
            </div>
          </div>
          
          <div class="fade-in-up" style="animation-delay: 0.9s;">
            <label for="photo_identite" id="photo_identite_label" class="block text-sm font-medium text-gray-700 mb-1">Pièce d'identité (PDF) *</label> {{-- Label mis à jour par JS --}}
            <input 
              type="file" 
              id="photo_identite" 
              name="photo_identite"
              accept="application/pdf" {{-- Toujours PDF --}}
              class="block w-full text-sm text-gray-500
                     file:mr-4 file:py-2 file:px-4
                     file:rounded-md file:border-0
                     file:text-sm file:font-semibold
                     file:bg-indigo-50 file:text-indigo-700
                     hover:file:bg-indigo-100"
              onchange="previewIdentityPhoto(event)"
            >
             <p id="photo_identite_format" class="text-xs text-gray-500 mt-1">Format PDF (max. 2MB)</p> {{-- Toujours PDF --}}
            <p id="photo_identite-error" class="error-message"></p>
            <div id="previewIdentityContainer" class="mt-2 hidden flex items-center space-x-2">
              {{-- Retrait de l'aperçu image, seule l'icône PDF est nécessaire --}}
               <svg id="identityPdfIcon" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500 hidden" viewBox="0 0 20 20" fill="currentColor">
                 <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0111.293 2.707l4 4A1 1 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
               </svg>
              <span id="identityFileName" class="text-sm text-gray-600 truncate"></span>
              <button type="button" id="removeIdentityImage" class="ml-auto text-xs text-red-600 hover:text-red-800 transition">Supprimer</button>
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
      
      const hasPermis = document.querySelector('input[name="avez_vous_permis"]:checked').value === '1';
      const identiteExtensions = hasPermis ? ['jpg', 'jpeg', 'png'] : ['pdf'];
      isValid &= validateFile(document.getElementById('photo_identite'), 'photo_identite-error', identiteExtensions);
      
      const permisRadios = document.querySelectorAll('input[name="avez_vous_permis"]');
      const permisError = document.getElementById('avez_vous_permis-error');
      let permisSelected = false;
      permisRadios.forEach(radio => {
          if (radio.checked) permisSelected = true;
      });
      if (!permisSelected) {
          showError(permisRadios[0], permisError, "Veuillez indiquer si vous avez un permis."); 
          isValid = false;
      } else {
          clearError(permisRadios[0], permisError);
      }

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

    document.addEventListener('DOMContentLoaded', function() {
        const radiosPermis = document.querySelectorAll('input[name="avez_vous_permis"]');
        const photoIdentiteInput = document.getElementById('photo_identite');
        const photoIdentiteLabel = document.getElementById('photo_identite_label');
        const photoIdentiteFormat = document.getElementById('photo_identite_format');
        
        const previewProfileContainer = document.getElementById('previewProfileContainer');
        const profileImagePreview = document.getElementById('profileImagePreview');
        const profileFileName = document.getElementById('profileFileName'); 

        const previewIdentityContainer = document.getElementById('previewIdentityContainer');
        const identityImagePreview = document.getElementById('identityImagePreview');
        const identityFileName = document.getElementById('identityFileName');
        const identityPdfIcon = document.getElementById('identityPdfIcon'); 

        function updatePhotoIdentiteField(hasPermis) {
            if (hasPermis) {
                photoIdentiteLabel.textContent = "Photo du permis (PDF) *"; // Préciser PDF
            } else {
                photoIdentiteLabel.textContent = "Pièce d'identité (PDF) *"; // Préciser PDF
            }
            // Toujours PDF
            photoIdentiteInput.accept = "application/pdf";
            photoIdentiteFormat.textContent = "Format PDF (max. 2MB)";
            
            // Réinitialiser
            photoIdentiteInput.value = ''; 
            previewIdentityContainer.classList.add('hidden');
            identityPdfIcon.classList.add('hidden');
            identityFileName.textContent = '';
            clearError(photoIdentiteInput, document.getElementById('photo_identite-error'));
        }

        radiosPermis.forEach(radio => {
            radio.addEventListener('change', function() {
                updatePhotoIdentiteField(this.value === '1');
            });
        });

        const initialPermisValue = document.querySelector('input[name="avez_vous_permis"]:checked').value;
        updatePhotoIdentiteField(initialPermisValue === '1');

        window.previewProfilePhoto = function(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function() {
                    profileImagePreview.src = reader.result;
                    profileFileName.textContent = file.name; 
                    previewProfileContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                clearError(event.target, document.getElementById('photo_profile-error'));
            } else {
                event.target.value = ''; 
                previewProfileContainer.classList.add('hidden');
                 if(file) { 
                   showError(event.target, document.getElementById('photo_profile-error'), 'Veuillez sélectionner une image (PNG, JPG).');
                }
            }
        };

        window.previewIdentityPhoto = function(event) {
            const file = event.target.files[0];
            if (file) {
                let isValid = false;
                
                // Cacher icône par défaut
                identityPdfIcon.classList.add('hidden');

                // Accepter uniquement PDF
                if (file.type === 'application/pdf') {
                    isValid = true;
                    identityPdfIcon.classList.remove('hidden'); // Afficher icône PDF
                    identityFileName.textContent = file.name; // Afficher le nom du fichier
                    previewIdentityContainer.classList.remove('hidden');
                } else {
                    // Fichier invalide
                    event.target.value = ''; 
                    previewIdentityContainer.classList.add('hidden');
                    alert('Veuillez sélectionner un fichier PDF.');
                }

                if(isValid){
                    clearError(event.target, document.getElementById('photo_identite-error'));
                }
            } else {
                 previewIdentityContainer.classList.add('hidden'); 
            }
        };

        document.getElementById('removeProfileImage').addEventListener('click', function() {
            document.getElementById('photo_profile').value = '';
            previewProfileContainer.classList.add('hidden');
            profileFileName.textContent = '';
            profileImagePreview.src = '';
            clearError(document.getElementById('photo_profile'), document.getElementById('photo_profile-error'));
        });

        document.getElementById('removeIdentityImage').addEventListener('click', function() {
            document.getElementById('photo_identite').value = '';
            previewIdentityContainer.classList.add('hidden');
            identityFileName.textContent = '';
            identityPdfIcon.classList.add('hidden');
            clearError(document.getElementById('photo_identite'), document.getElementById('photo_identite-error'));
        });
        
        window.validateFile = function(input, errorId, allowedExtensions) {
            const errorElement = document.getElementById(errorId);
            if (input.files.length > 0) {
                const file = input.files[0];
                const extension = file.name.split('.').pop().toLowerCase();
                let isValid = false;
                let currentAllowedExtensions = [];

                // Toujours PDF pour photo_identite
                if (input.id === 'photo_identite') {
                    currentAllowedExtensions = ['pdf'];
                    isValid = currentAllowedExtensions.includes(extension);
                } else { // Pour photo_profile (image)
                    currentAllowedExtensions = allowedExtensions; // ['jpg', 'jpeg', 'png']
                    isValid = currentAllowedExtensions.includes(extension);
                }
                
                if (!isValid) {
                    showError(input, errorElement, `Format non supporté. Utilisez: ${currentAllowedExtensions.join(', ')}`);
                    if(input.id === 'photo_profile') {
                         document.getElementById('previewProfileContainer').classList.add('hidden');
                    } else {
                         document.getElementById('previewIdentityContainer').classList.add('hidden');
                    }
                    return false;
                } else if (file.size > 2 * 1024 * 1024) { 
                    showError(input, errorElement, "La taille du fichier ne doit pas dépasser 2MB");
                     if(input.id === 'photo_profile') {
                         document.getElementById('previewProfileContainer').classList.add('hidden');
                    } else {
                         document.getElementById('previewIdentityContainer').classList.add('hidden');
                    }
                    return false;
                } else {
                    clearError(input, errorElement);
                    return true;
                }
            } else {
                 clearError(input, errorElement);
                 return true; 
            }
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            isValid &= validateName(document.getElementById('nom'));
            isValid &= validateName(document.getElementById('prenom'));
            isValid &= validateEmail(document.getElementById('email'));
            isValid &= validatePassword(document.getElementById('password'));
            isValid &= validatePhone(document.getElementById('telephone'));
            
            const photoProfileInput = document.getElementById('photo_profile');
            if (!photoProfileInput.files.length) {
                 showError(photoProfileInput, document.getElementById('photo_profile-error'), "Ce champ est obligatoire");
                 isValid = false;
            } else {
                 isValid &= validateFile(photoProfileInput, 'photo_profile-error', ['jpg', 'jpeg', 'png']);
            }

            const photoIdentiteInput = document.getElementById('photo_identite');
            const identiteExtensions = ['pdf']; // Toujours PDF
             if (!photoIdentiteInput.files.length) {
                 showError(photoIdentiteInput, document.getElementById('photo_identite-error'), "Ce champ est obligatoire");
                 isValid = false;
            } else {
                isValid &= validateFile(photoIdentiteInput, 'photo_identite-error', identiteExtensions);
            }
            
            const permisRadios = document.querySelectorAll('input[name="avez_vous_permis"]');
            const permisError = document.getElementById('avez_vous_permis-error');
            let permisSelected = false;
            permisRadios.forEach(radio => {
                if (radio.checked) permisSelected = true;
            });
            if (!permisSelected) {
                const permisLabel = document.querySelector('label[for="avez_vous_permis"]'); 
                 showError(permisRadios[0], permisError, "Veuillez indiquer si vous avez un permis."); 
                isValid = false;
            } else {
                clearError(permisRadios[0], permisError);
            }

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
    });
  </script>
</body>
</html>