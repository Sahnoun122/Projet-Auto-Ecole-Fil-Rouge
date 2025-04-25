<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-école Sahnoun - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>

</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: true }">

             
                
        </div>

        <div class="flex-1 overflow-auto">
             
            <div class="min-h-screen bg-[#4D44B5] flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-4xl font-bold mb-6">Prêt à commencer ?</h1>
                    <div class="text-8xl font-bold mb-8" id="countdown">3</div>
                    <p class="text-xl">Le quiz <span class="font-bold">{{ $quiz->title }}</span> va commencer</p>
                </div>
            </div>
            
            <script>
                let count = 3;
                const countdownElement = document.getElementById('countdown');
                const countdownInterval = setInterval(() => {
                    count--;
                    countdownElement.textContent = count;
                    
                    if (count <= 0) {
                        clearInterval(countdownInterval);
                        window.location.href = "{{ route('candidats.start', $quiz) }}";
                    }
                }, 1000);
            </script>

</body>

</html>
