$(document).ready(function () {
    const modal = $('#monitorModal');

    setupFilePreview('monitorProfilePhoto', 'profileImagePreview', 'previewProfileContainer', 'profilePhotoFileName');
    setupFilePreview('monitorIdentitePhoto', 'identiteImagePreview', 'previewIdentiteContainer', 'identitePhotoFileName');
    setupFilePreview('monitorCertifications', null, 'certificationsPreview', 'certificationsFileName', true);
    setupFilePreview('monitorQualifications', null, 'qualificationsPreview', 'qualificationsFileName', true);

    $('#newMonitorBtn').click(function () {
        $('#monitorForm')[0].reset();
        $('#monitorId').val('');
        $('#_method').val('POST');
        $('[id$="Preview"]').addClass('hidden');
        $('[id$="FileName"]').text('Aucun fichier sélectionné');
        $('#modalTitle').text('Ajouter un Moniteur');
        modal.removeClass('hidden').fadeIn();
    });

    $('#cancelBtn').click(function () {
        modal.fadeOut(() => modal.addClass('hidden'));
    });

    window.handleEditMonitor = function(id) {
        $.get(`/admin/moniteurs/${id}/edit`, function(data) {
            $('#monitorId').val(data.id);
            $('#_method').val('PUT');
            $('#monitorNom').val(data.nom);
            $('#monitorPrenom').val(data.prenom);
            $('#monitorEmail').val(data.email);
            $('#monitorAdresse').val(data.adresse);
            $('#monitorTelephone').val(data.telephone);
            $('#monitorPermis').val(data.type_permis);
            $('#monitorPassword').val('').removeAttr('required');
            
            if(data.photo_profile) {
                $('#profileImagePreview').attr('src', `/storage/${data.photo_profile}`);
                $('#previewProfileContainer').removeClass('hidden');
                $('#profilePhotoFileName').text('Photo existante');
            }
            
            if(data.photo_identite) {
                $('#identiteImagePreview').attr('src', `/storage/${data.photo_identite}`);
                $('#previewIdentiteContainer').removeClass('hidden');
                $('#identitePhotoFileName').text('Photo existante');
            }
            
            $('#modalTitle').text('Modifier un Moniteur');
            modal.removeClass('hidden').fadeIn();
        });
    }

    window.handleDeleteMonitor = function(id) {
        if (confirm('Voulez-vous vraiment supprimer ce moniteur ?')) {
            $.ajax({
                url: `/admin/moniteurs/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    location.reload();
                }
            });
        }
    }

    window.handleBanMonitor = function(id) {
        if (confirm('Voulez-vous vraiment bannir ce moniteur ?')) {
            $.post(`/admin/moniteurs/${id}/ban`, {
                _token: '{{ csrf_token() }}'
            }, function () {
                location.reload();
            });
        }
    }
});

function setupFilePreview(inputId, previewImgId, previewContainerId, fileNameId, isDocument = false) {
    const input = document.getElementById(inputId);
    const fileNameElement = document.getElementById(fileNameId);
    
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileNameElement.textContent = file.name;
            
            if (isDocument) {
                const previewContainer = document.getElementById(previewContainerId);
                const previewContent = document.getElementById(previewContainerId + 'Content');
                
                if (file.type === 'application/pdf') {
                    previewContent.type = 'application/pdf';
                    previewContent.src = URL.createObjectURL(file);
                    previewContainer.classList.remove('hidden');
                } else {
                    // Pour les autres types de documents, afficher un message
                    previewContainer.classList.add('hidden');
                    alert('La prévisualisation est disponible uniquement pour les fichiers PDF');
                }
            } else {
                const preview = document.getElementById(previewImgId);
                const previewContainer = document.getElementById(previewContainerId);
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
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

function previewProfilePhoto(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function() {
      const preview = document.getElementById('profileImagePreview');
      preview.src = reader.result;
      document.getElementById('previewProfileContainer').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }
}

function previewIdentityPhoto(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function() {
      const preview = document.getElementById('identityImagePreview');
      preview.src = reader.result;
      document.getElementById('previewIdentityContainer').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }
}

document.getElementById('removeProfileImage').addEventListener('click', function() {
  document.getElementById('photo-profile').value = '';
  document.getElementById('previewProfileContainer').classList.add('hidden');
});

document.getElementById('removeIdentityImage').addEventListener('click', function() {
  document.getElementById('photo_identite').value = '';
  document.getElementById('previewIdentityContainer').classList.add('hidden');
});

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

//fetch 
document.getElementById('registerForm').addEventListener('submit', async function(e) {
e.preventDefault();

const submitBtn = document.getElementById('submitBtn');
submitBtn.disabled = true;
submitBtn.textContent = 'Inscription en cours...';

const formData = new FormData(this);

try {
const response = await fetch('/api/register', {
method: 'POST',
body: formData,
credentials: 'include'
});

const data = await response.json();

if (!response.ok) {
throw data;
}

window.location.href = '/connecter'; 
} catch (error) {
console.error('Erreur:', error);
alert(error.error || 'Une erreur est survenue');
} finally {
submitBtn.disabled = false;
submitBtn.textContent = 'S\'inscrire';
}
});