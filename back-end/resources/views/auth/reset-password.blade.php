<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sahnoun - Réinitialisation du mot de passe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="icon" type="images/png" href="{{ asset('storage/images/logo.png') }}">

  <style>
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
    .input-hover-effect:focus {
      border-left: 4px solid #4f46e5;
      box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
    }
    .error-message {
      color: #ef4444;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    .input-error {
      border-color: #ef4444 !important;
    }
  </style>
</head>
<body class="flex flex-col md:flex-row min-h-screen w-full">
=  <div class="hidden md:flex animated-bg text-white p-8 flex-col items-center justify-center">
    <div class="mb-8 animate__animated animate__fadeIn">
      <a href="{{ route('/') }}"> <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-64"></a>
    </div>
    
    <div class="text-center mb-16">
      <h1 class="text-4xl font-bold mb-2">Réinitialiser votre mot de passe</h1>
      <p class="text-lg text-indigo-100 mt-4">Choisissez un nouveau mot de passe sécurisé.</p>
    </div>
  </div>

  <div class="right-side bg-white p-8 flex flex-col justify-center">
    <div class="max-w-lg mx-auto w-full">
      <h2 class="text-3xl font-bold text-gray-800 mb-6">Nouveau mot de passe</h2>
      
      @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ $email ?? old('email') }}"
            placeholder="exemple@email.com"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            required
            readonly
          >
          @error('email')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe *</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            required
          >
          @error('password')
            <p class="error-message">{{ $message }}</p>
          @enderror
          <p class="mt-1 text-xs text-gray-500">
            Doit contenir au moins 8 caractères, dont une majuscule, une minuscule et un chiffre.
          </p>
        </div>
        
        <div>
          <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe *</label>
          <input
            type="password"
            id="password-confirm"
            name="password_confirmation"
            placeholder="••••••••"
            class="w-full px-4 py-2 bg-gray-100 rounded-md input-hover-effect focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"
            required
          >
        </div>
        
        <div>
          <button
            type="submit"
            class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-all duration-300"
          >
            Réinitialiser le mot de passe
          </button>
        </div>
      </form>

      <div class="text-center mt-6">
        <p class="text-gray-600">
          <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">Retour à la page de connexion</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>