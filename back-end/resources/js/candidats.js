document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('candidateModal');
    const form = document.getElementById('candidateForm');
    const searchInput = document.getElementById('searchInput');
    const candidateRows = document.querySelectorAll('.candidate-row');

    // Configuration des prévisualisations d'image
    setupFilePreview('candidateProfilePhoto', 'profileImagePreview', 'previewProfileContainer', 'profilePhotoFileName');
    setupFilePreview('candidateIdentitePhoto', 'identiteImagePreview', 'previewIdentiteContainer', 'identitePhotoFileName');

    // Bouton pour ajouter un nouveau candidat
    document.getElementById('newCandidateBtn').addEventListener('click', function() {
        form.reset();
        document.getElementById('candidateId').value = '';
        document.getElementById('_method').value = 'POST';
        document.getElementById('modalTitle').textContent = 'Ajouter un Candidat';
        document.getElementById('candidatePassword').required = true;
        document.querySelectorAll('[id$="Preview"]').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('[id$="FileName"]').forEach(el => el.textContent = 'Aucun fichier sélectionné');
        modal.classList.remove('hidden');
    });

    // Bouton d'annulation
    document.getElementById('cancelBtn').addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    // Recherche en temps réel
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        candidateRows.forEach(row => {
            const name = row.getAttribute('data-name');
            if (name.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Fonction pour éditer un candidat
    window.handleEditCandidate = function(id) {
        fetch(`/admin/candidats/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('candidateId').value = data.id;
                document.getElementById('_method').value = 'PUT';
                form.action = `/admin/candidats/${data.id}`;
                document.getElementById('modalTitle').textContent = 'Modifier un Candidat';
                
                // Remplir les champs
                document.getElementById('candidateNom').value = data.nom;
                document.getElementById('candidatePrenom').value = data.prenom;
                document.getElementById('candidateEmail').value = data.email;
                document.getElementById('candidateAdresse').value = data.adresse;
                document.getElementById('candidateTelephone').value = data.telephone;
                document.getElementById('candidatePermis').value = data.type_permis;
                document.getElementById('candidatePassword').required = false;
                
                // Prévisualiser les images existantes
                if(data.photo_profile) {
                    document.getElementById('profileImagePreview').src = `/storage/${data.photo_profile}`;
                    document.getElementById('previewProfileContainer').classList.remove('hidden');
                    document.getElementById('profilePhotoFileName').textContent = 'Photo existante';
                }
                
                if(data.photo_identite) {
                    document.getElementById('identiteImagePreview').src = `/storage/${data.photo_identite}`;
                    document.getElementById('previewIdentiteContainer').classList.remove('hidden');
                    document.getElementById('identitePhotoFileName').textContent = 'Photo existante';
                }
                
                modal.classList.remove('hidden');
            });
    };

    // Fonction pour supprimer un candidat
    window.handleDeleteCandidate = function(id) {
        if (confirm('Voulez-vous vraiment supprimer ce candidat ?')) {
            fetch(`/admin/candidats/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Erreur lors de la suppression');
                }
            });
        }
    };

    // Fonction pour bannir un candidat
    window.handleBanCandidate = function(id) {
        if (confirm('Voulez-vous vraiment bannir ce candidat ?')) {
            fetch(`/admin/candidats/${id}/ban`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Erreur lors du bannissement');
                }
            });
        }
    };
});

function setupFilePreview(inputId, previewImgId, previewContainerId, fileNameId) {
    const input = document.getElementById(inputId);
    const fileNameElement = document.getElementById(fileNameId);
    
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileNameElement.textContent = file.name;
            
            const preview = document.getElementById(previewImgId);
            const previewContainer = document.getElementById(previewContainerId);
            
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
}

function removeImage(inputId, previewContainerId, fileNameId) {
    document.getElementById(inputId).value = '';
    document.getElementById(previewContainerId).classList.add('hidden');
    document.getElementById(fileNameId).textContent = 'Aucun fichier sélectionné';
}
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


async function logout() {
try {
const response = await fetch('/api/logout', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`, 
    },
});

const data = await response.json();

if (response.ok) {
    localStorage.removeItem('token');
    localStorage.removeItem('role');
    alert(data.message);
    window.location.href = '/connecter'; 
} else {
    alert('Échec de la déconnexion : ' + data.message); 
}
} catch (error) {
console.error('Erreur lors de la déconnexion:', error);
alert('Une erreur est survenue. Veuillez réessayer.');
}
}

document.getElementById('logoutButton').addEventListener('click', logout);
