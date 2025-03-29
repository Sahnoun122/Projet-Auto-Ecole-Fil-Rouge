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
        <h1 class="text-4xl font-bold mb-2">Dernière étape !</h1>
        <p class="text-lg text-indigo-100 mt-4">Complétez votre inscription pour accéder à votre espace candidat.</p>
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
        <h2 class="text-3xl font-bold text-gray-800 mb-6 animate__animated animate__fadeInDown">Informations complémentaires</h2>      @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif


  <form id="completeRegistrationForm" method="POST" action="/api/complete-registration" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <input type="hidden" name="_token" value="votre_token_csrf_ici">
    <input type="hidden" name="role"  value="candidat">

    <div class="fade-in-up" style="animation-delay: 0.2s;">
      <label for="type_permis" class="block text-sm font-medium text-gray-700 mb-2">Type de permis</label>
      <select 
        id="type_permis" 
        name="type_permis"
        class="w-full px-4 py-3 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
        required
      >
        <option value="">Sélectionnez votre type de permis</option>
        <option value="A">Permis A (Moto)</option>
        <option value="B">Permis B (Voiture)</option>
        <option value="C">Permis C (Poids lourd)</option>
        <option value="D">Permis D (Bus)</option>
        <option value="EB">Permis EB (Remorque)</option>
      </select>

    </div>


    <div class="fade-in-up">
        <label class="block text-sm font-medium text-gray-700 mb-2">Photo d'identité</label>
        <div class="border-2 border-dashed border-blue-500 rounded-lg p-6 hover:bg-blue-50 transition ease-in-out">
          <label for="photo_identite" class="block text-center cursor-pointer">
            <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="mt-2 block text-sm font-medium text-gray-700">Glissez-déposez votre photo ou cliquez pour sélectionner</span>
            <span class="mt-1 block text-xs text-gray-500">Format JPG, PNG (max. 2MB)</span>
          </label>
          <input type="file" id="photo_identite" name="photo_identite" accept="image/*" class="hidden">
        </div>
      
        <div id="previewContainer" class="mt-4 hidden">
          <img id="imagePreview" class="mx-auto rounded-lg shadow-lg" alt="Aperçu de la photo d'identité">
          <button id="removeImage" class="mt-2 text-red-500 hover:text-red-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="block text-sm">Supprimer l'image</span>
          </button>
        </div>
      </div>
    
    <button 
      type="submit" 
      id="submitBtn"
      class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-all duration-300 transform hover:scale-102 pulse"
    >
      Finaliser l'inscription
    </button>
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

    document.addEventListener('DOMContentLoaded', function() {
  // 1. Initialisation des animations
  AOS.init();

  // 2. Animation des éléments du formulaire
  const animateForm = () => {
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach((input, index) => {
      setTimeout(() => {
        input.classList.add('focus-within:ring-2');
      }, 100 * index);
    });
  };
  setTimeout(animateForm, 500);

  // 3. Animation du logo au survol
  const logo = document.querySelector('.logo-spin');
  if (logo) {
    logo.addEventListener('mouseover', () => {
      logo.style.animation = 'logoRotate 1.5s ease';
    });
    logo.addEventListener('animationend', () => {
      logo.style.animation = '';
    });
  }

  // 4. Gestion de la photo d'identité
  const photoInput = document.getElementById('photo_identite');
  const previewContainer = document.getElementById('previewContainer');
  const imagePreview = document.getElementById('imagePreview');
  const removeImageBtn = document.getElementById('removeImage');
  const dropZone = document.querySelector('.border-blue-500');

  // 4.1. Affichage de l'aperçu quand une image est sélectionnée
  photoInput.addEventListener('change', function(e) {
    handleImageSelection(e.target.files);
  });

  // 4.2. Bouton pour supprimer l'image
  removeImageBtn.addEventListener('click', function() {
    resetImageUpload();
  });

  // 5. Gestion du drag and drop
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
  });

  ['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlightDropZone, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlightDropZone, false);
  });

  dropZone.addEventListener('drop', function(e) {
    handleDrop(e);
  });

  // 6. Soumission du formulaire
  const form = document.getElementById('completeRegistrationForm');
  const submitBtn = document.getElementById('submitBtn');

  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    await handleFormSubmission();
  });

  // Fonctions utilitaires:

  // Gère la sélection d'image via input file
  function handleImageSelection(files) {
    if (files && files.length > 0) {
      const file = files[0];
      
      // Vérification de la taille (max 2MB)
      if (file.size > 2 * 1024 * 1024) {
        alert('La taille du fichier ne doit pas dépasser 2MB');
        return;
      }
      
      // Vérification du type (image seulement)
      if (!file.type.match('image.*')) {
        alert('Veuillez sélectionner une image valide (JPG, PNG)');
        return;
      }
      
      // Création de l'aperçu
      const reader = new FileReader();
      reader.onload = function(event) {
        imagePreview.src = event.target.result;
        previewContainer.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  }

  // Réinitialise le champ d'upload d'image
  function resetImageUpload() {
    photoInput.value = '';
    previewContainer.classList.add('hidden');
  }

  // Empêche le comportement par défaut pour le drag and drop
  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  // Met en surbrillance la zone de drop
  function highlightDropZone() {
    dropZone.classList.add('bg-blue-100', 'border-blue-600');
  }

  // Retire la surbrillance de la zone de drop
  function unhighlightDropZone() {
    dropZone.classList.remove('bg-blue-100', 'border-blue-600');
  }

  // Gère le drop d'un fichier
  function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length) {
      photoInput.files = files;
      const event = new Event('change');
      photoInput.dispatchEvent(event);
    }
  }

  // Gère la soumission du formulaire
  async function handleFormSubmission() {
    const originalBtnText = submitBtn.textContent;
    
    // Affiche un indicateur de chargement
    submitBtn.innerHTML = `
      <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      Traitement en cours...
    `;
    submitBtn.disabled = true;

    // Récupère le token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (!csrfToken) {
      alert('Erreur de sécurité. Veuillez rafraîchir la page.');
      resetSubmitButton(originalBtnText);
      return;
    }

    // Valide les champs requis avant envoi
    if (!validateRequiredFields()) {
      resetSubmitButton(originalBtnText);
      return;
    }

    try {
      // Prépare les données du formulaire
      const formData = new FormData(form);
      
      // Envoi de la requête
      const response = await fetch('/api/complete-registration', {
        method: 'POST',
        body: formData,
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
        },
        credentials: 'include'
      });

      const data = await response.json();

      if (!response.ok) {
        throw data;
      }

      // Redirection après succès
      window.location.href = "/dashboard?success=Inscription complétée avec succès!";
      
    } catch (error) {
      handleSubmissionError(error);
    } finally {
      resetSubmitButton(originalBtnText);
    }
  }

  // Valide les champs requis du formulaire
  function validateRequiredFields() {
    const typePermis = document.getElementById('type_permis').value;
    const photoIdentite = document.getElementById('photo_identite').files.length;
    
    if (!typePermis) {
      alert('Veuillez sélectionner un type de permis');
      return false;
    }
    
    if (!photoIdentite) {
      alert('Veuillez télécharger une photo d\'identité');
      return false;
    }
    
    return true;
  }

  // Gère les erreurs de soumission
  function handleSubmissionError(error) {
    console.error('Erreur:', error);
    let errorMessage = "Une erreur est survenue";
    
    if (error.errors) {
      errorMessage = Object.values(error.errors).flat().join('\n');
    } else if (error.message) {
      errorMessage = error.message;
    }
    
    alert(errorMessage);
  }

  // Réinitialise le bouton de soumission
  function resetSubmitButton(originalText) {
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  }
});
  </script>


</body>
</html> 