<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sahnoun - Connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col md:flex-row h-screen w-full">
  <div class="hidden md:flex bg-indigo-700 text-white w-full md:w-2/5 p-8 flex-col items-center justify-center relative">
    <div class="mb-8">
      <img src="{{ url('resources/photoss/logo.png') }}" alt="Logo" class="w-64">
    </div>
    
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold mb-2">Bon retour parmi nous !</h1>
    </div>

  </div>

  <div class="bg-white w-full md:w-3/5 p-8 flex flex-col justify-center">
    <div class="max-w-lg mx-auto w-full">
      <h2 class="text-4xl font-bold text-indigo-900 mb-12">Se connecter</h2>
      
      <form class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <div class="relative">
            <input 
              type="email" 
              id="email" 
              value=""
              name="email"
              placeholder="Email"
              class="w-full px-4 py-3 bg-gray-100 rounded-md pr-12"
            >
          </div>
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
          <div class="relative">
            <input 
              type="password" 
              id="password" 
              value=""
                name="password"
              placeholder="••••••••••••••"
              class="w-full px-4 py-3 bg-gray-100 rounded-md pr-12"
            >
       
        </div>
        
        <button 
          type="submit" 
          class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition duration-300 mt-6"
        >
          Se connecter
        </button>
      </form>
            <div class="text-center mt-6">
        <p class="text-gray-600">
          Vous n'avez pas de compte ? 
          <a href="{{ route ('register')}}" class="text-cyan-500 font-medium hover:underline">S'inscrire</a>
        </p>
      </div>
    </div>
  </div>

</body>
</html>