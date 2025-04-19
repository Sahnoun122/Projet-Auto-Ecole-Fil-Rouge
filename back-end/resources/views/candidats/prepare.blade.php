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
    </div>


    <script>

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
      const progressBars = document.querySelectorAll('.progress-bar');
      progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
          bar.style.width = width;
        }, 300);
      });
    }, 500);
    
    const badge = document.querySelector('.pulse');
    if (badge) {
      setInterval(() => {
        badge.classList.add('animate-pulse');
        setTimeout(() => {
          badge.classList.remove('animate-pulse');
        }, 1000);
      }, 2000);
    }
  });
        
  document.addEventListener("DOMContentLoaded", function () {
    function toggleSection(headerId, listId, arrowId) {
      const header = document.getElementById(headerId);
      const list = document.getElementById(listId);
      const arrow = document.getElementById(arrowId);
  
      let isOpen = list.style.maxHeight !== "0px";
  
      header.addEventListener("click", function () {
        if (isOpen) {
          list.style.maxHeight = "0";
          arrow.style.transform = "rotate(0deg)";
        } else {
          list.style.maxHeight = `${list.scrollHeight}px`;
          arrow.style.transform = "rotate(90deg)";
        }
        isOpen = !isOpen;
      });
    }
  
    toggleSection("cours-theorique-header", "cours-theorique-list", "cours-theorique-arrow");
    toggleSection("cours-pratique-header", "cours-pratique-list", "cours-pratique-arrow");
    toggleSection("examen-header", "examen-list", "examen-arrow");
    toggleSection("moniteurs-header", "moniteurs-list", "moniteurs-arrow");
    toggleSection("caisse-header", "caisse-list", "caisse-arrow");
  });



    </script>

</body>

</html>
