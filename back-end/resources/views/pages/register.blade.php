<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sahnoun - Créer un compte</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col md:flex-row h-screen w-full">
  <div class="hidden md:flex bg-indigo-700 text-white w-full md:w-2/5 p-8 flex-col items-center justify-center relative">
    <div class="mb-8">

        <h2 class="text-4xl font-bold text-white-900 mb-8">Créer un compte</h2>

      <img src="{{ url('resources/photoss/logo.png') }}" alt="Logo" class="w-64">
    </div>
    
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold mb-2">Bon retour parmi nous !</h1>
   
        <p class="text-lg text-indigo-100 mt-4">Chez Sahnoun, nous simplifions chaque étape pour vous.</p>

        
      </div>
    
    <div class="flex space-x-2 mt-auto">
    </div>
  </div>


  <div class="bg-white w-full md:w-3/5 p-8 flex flex-col justify-center">
    <div class="max-w-lg mx-auto w-full">
      
      <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input 
              type="text" 
              id="nom" 
              value=""
              name="nom"
              placeholder="Nom"
              class="w-full px-4 py-2 bg-gray-100 rounded-md"
            >
          </div>
          <div>
            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
            <input 
              type="text" 
              id="prenom" 
              value=""
                name="prenom"
              placeholder="Prenom"
              class="w-full px-4 py-2 bg-gray-100 rounded-md"
            >
          </div>
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input 
            type="email" 
            id="email" 
            value=""
                 name="email"
              placeholder="Email"
            class="w-full px-4 py-2 bg-gray-100 rounded-md"
          >
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
          <input 
            type="password" 
            id="password" 
            value=""
                name="password"
              placeholder="Mot de passe"
            class="w-full px-4 py-2 bg-gray-100 rounded-md"
          >
        </div>
        
        <div>
          <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
          <input 
            type="text" 
            id="address" 
            value=""
             name="adresse"
              placeholder="Adresse"
            class="w-full px-4 py-2 bg-gray-100 rounded-md"
          >
        </div>
        
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
          <input 
            type="tel" 
            id="phone" 
            value=""
               name="phone"
              placeholder="Téléphone"
            class="w-full px-4 py-2 bg-gray-100 rounded-md"
          >
        </div>
        
        <div>
          <label for="licenseType" class="block text-sm font-medium text-gray-700 mb-1">Type de permis</label>
          <input 
            type="text" 
            id="licenseType" 
            value=""
              name="type"
              placeholder="Type de permis"
            class="w-full px-4 py-2 bg-gray-100 rounded-md"
          >
        </div>
        
        <div>
            <label for="licenseType" class="block text-sm font-medium text-gray-700 mb-1">Photos</label>
            <input 
              type="file" 
              id="photos" 
              value=""
                name="photos"
                placeholder="photos"
              class="w-full px-4 py-2 bg-gray-100 rounded-md"
            >
          </div>
        <button 
          type="submit" 
          class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition duration-300"
        >
          S'inscrire
        </button>
      </form>
      
      <div class="text-center mt-6">
        <p class="text-gray-600">
          Déjà membre ? 
          <a href="#" class="text-cyan-500 font-medium hover:underline">Se connecter</a>
        </p>
      </div>
    </div>
  </div>

</body>
</html>