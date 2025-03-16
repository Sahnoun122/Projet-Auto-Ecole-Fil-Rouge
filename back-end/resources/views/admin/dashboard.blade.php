<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auto-école Khalid - Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>

</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
  <div class="flex h-screen">
    <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white shadow-lg transition-all duration-300 flex flex-col">
      <div class="p-4 flex justify-between items-center border-b">
       
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-primary">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </button>
      </div>
      
      <div class="p-4 border-b flex justify-center">
        <div class="relative group">
          <div class="absolute inset-0 bg-primary rounded-full opacity-10 group-hover:opacity-20 transition-opacity"></div>
          <img src="/api/placeholder/60/60" alt="Auto-école Khalid" class="h-16 w-16 object-contain rounded-full border-2 border-gray-200" />
          <div class="absolute bottom-0 right-0 h-4 w-4 bg-green-500 rounded-full border-2 border-white"></div>
        </div>
      </div>
      
      <div :class="sidebarOpen ? 'block' : 'hidden'" class="text-center py-2 text-sm font-medium text-gray-600">
        Auto-école S A H N O U N 
      </div>

    </div>

 </div>

</body>
</html>
 
