const newVehicleBtn = document.getElementById('newVehicleBtn');
const vehicleModal = document.getElementById('vehicleModal');
const cancelBtn = document.getElementById('cancelBtn');
const vehicleForm = document.getElementById('vehicleForm');
const modalVehicleTitle = document.getElementById('modalVehicleTitle');
const vehicleId = document.getElementById('vehicleId');
const _method = document.getElementById('_method');

newVehicleBtn.addEventListener('click', () => {
    vehicleModal.classList.remove('hidden');
    modalVehicleTitle.textContent = 'Nouveau Véhicule';
    vehicleForm.reset();
    vehicleId.value = '';
    _method.value = 'POST';
    document.getElementById('vehicleProchaineMaintenance').min = new Date().toISOString().split('T')[0];
});

cancelBtn.addEventListener('click', () => {
    vehicleModal.classList.add('hidden');
});

function handleEditVehicle(id, marque, modele, immatriculation, dateAchat, kilometrage, prochaineMaintenance, statut) {
    vehicleModal.classList.remove('hidden');
    modalVehicleTitle.textContent = 'Modifier Véhicule';
    vehicleId.value = id;
    _method.value = 'PUT';
    document.getElementById('vehicleMarque').value = marque;
    document.getElementById('vehicleModele').value = modele;
    document.getElementById('vehicleImmatriculation').value = immatriculation;
    document.getElementById('vehicleDateAchat').value = dateAchat;
    document.getElementById('vehicleKilometrage').value = kilometrage;
    document.getElementById('vehicleProchaineMaintenance').value = prochaineMaintenance;
    document.getElementById('vehicleStatut').value = statut;
}

function handleDeleteVehicle(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')) {
        fetch(`/admin/vehicles/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadVehicles();
            }
        });
    }
}

vehicleForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = vehicleId.value ? `/admin/vehicles/${vehicleId.value}` : '/admin/vehicles';
    const method = vehicleId.value ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            vehicleModal.classList.add('hidden');
            loadVehicles();
        }
    })
    .catch(error => console.error('Error:', error));
});

function loadVehicles() {
    fetch('/admin/vehicles')
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newContent = doc.getElementById('vehiclesContainer').innerHTML;
        document.getElementById('vehiclesContainer').innerHTML = newContent;
    });
}

const maintenanceAlertsBtn = document.getElementById('maintenanceAlertsBtn');
const maintenanceAlertsModal = document.getElementById('maintenanceAlertsModal');
const closeAlertsBtn = document.getElementById('closeAlertsBtn');

maintenanceAlertsBtn.addEventListener('click', () => {
    fetch('/admin/vehicles/maintenance-alerts')
    .then(response => response.json())
    .then(data => {
        let alertsHTML = '';
        if (data.length > 0) {
            data.forEach(vehicle => {
                const date = new Date(vehicle.prochaine_maintenance);
                alertsHTML += `
                    <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded">
                        <h4 class="font-medium text-red-800">${vehicle.marque} ${vehicle.modele}</h4>
                        <p class="text-sm text-red-600">${vehicle.immatriculation}</p>
                        <p class="text-sm text-red-600">Maintenance prévue: ${date.toLocaleDateString()}</p>
                    </div>
                `;
            });
        } else {
            alertsHTML = '<p class="text-center text-gray-500 py-4">Aucune alerte de maintenance</p>';
        }
        document.getElementById('alertsContent').innerHTML = alertsHTML;
        maintenanceAlertsModal.classList.remove('hidden');
    });
});

closeAlertsBtn.addEventListener('click', () => {
    maintenanceAlertsModal.classList.add('hidden');
});


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
  
    toggleSection("candidats-header", "candidats-list", "candidats-arrow");
    toggleSection("cours-theorique-header", "cours-theorique-list", "cours-theorique-arrow");
    toggleSection("cours-pratique-header", "cours-pratique-list", "cours-pratique-arrow");
    toggleSection("vehicule-header", "vehicule-list", "vehicule-arrow");
    toggleSection("examen-header", "examen-list", "examen-arrow");
    toggleSection("moniteurs-header", "moniteurs-list", "moniteurs-arrow");
    toggleSection("caisse-header", "caisse-list", "caisse-arrow");
  });

  
