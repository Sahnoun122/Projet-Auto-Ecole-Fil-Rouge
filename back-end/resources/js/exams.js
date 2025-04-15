      
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

    function toggleSection(headerId, listId, arrowId) {
        const header = document.getElementById(headerId);
        const list = document.getElementById(listId);
        const arrow = document.getElementById(arrowId);

        let isOpen = list.style.maxHeight !== "0px";

        header.addEventListener("click", function() {
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

    toggleSection("candidats-header", "candidats-list", "candidats-arrow");
    toggleSection("cours-theorique-header", "cours-theorique-list", "cours-theorique-arrow");
    toggleSection("cours-pratique-header", "cours-pratique-list", "cours-pratique-arrow");
    toggleSection("vehicule-header", "vehicule-list", "vehicule-arrow");
    toggleSection("examen-header", "examen-list", "examen-arrow");
    toggleSection("moniteurs-header", "moniteurs-list", "moniteurs-arrow");
    toggleSection("caisse-header", "caisse-list", "caisse-arrow");

    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            })
            .catch(error => {
                console.error('Erreur lors de la déconnexion:', error);
            });
        });
    }
});





