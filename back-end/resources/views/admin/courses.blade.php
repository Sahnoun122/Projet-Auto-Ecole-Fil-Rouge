@extends('layouts.admin')
@section('content')
 
<div class="flex-1 overflow-auto">
    <header class="bg-[#4D44B5] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Cours pour: {{ $title->name }}</h1>
            <span class="inline-block px-3 py-1 bg-white text-[#4D44B5] rounded-full text-sm font-medium">
                Permis {{ $title->type_permis }}
            </span>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <a href="{{ route('admin.titles') }}"
            class="bg-[#4D44B5] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition">
            <i class="fas fa-arrow-left mr-2"></i> Retour aux Titres
        </a>
        <button id="newCourseBtn"
            class="bg-white text-[#4D44B5] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
            <i class="fas fa-plus mr-2"></i> Nouveau Cours
        </button>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            @if ($courses->isEmpty())
                <div class="text-center p-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun cours disponible</h3>
                    <p class="text-gray-500 mb-6">Commencez par créer votre premier cours pour ce titre.</p>
                    <button id="emptyNewCourseBtn"
                        class="bg-[#4D44B5] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition">
                        <i class="fas fa-plus mr-2"></i> Créer un cours
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6" id="coursesContainer">
                    @foreach ($courses as $course)
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="mb-4 h-40 bg-gray-100 rounded-lg overflow-hidden">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-[#4D44B5] mb-2">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($course->description, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $course->duration }} minutes</span>
                            <div class="flex space-x-2">
                                <button onclick="handleEditCourse('{{ $course->id }}', '{{ $course->title }}', `{{ $course->description }}`, '{{ $course->duration }}', '{{ $course->image ? asset('storage/' . $course->image) : '' }}')"
                                    class="text-[#4D44B5] hover:text-[#3a32a1] p-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="handleDeleteCourse('{{ $course->id }}')"
                                    class="text-red-500 hover:text-red-700 p-1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <div id="courseModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white w-full max-w-md p-6 rounded-lg">
            <h2 id="modalCourseTitle" class="text-lg font-bold mb-4">Nouveau Cours</h2>
            <form id="courseForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="courseId" name="id">
                <input type="hidden" id="titleId" name="title_id" value="{{ $title->id }}">
                <input type="hidden" id="_methodCourse" name="_method" value="POST">

                <div class="mb-4">
                    <label for="courseTitle" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                    <input type="text" id="courseTitle" name="title" maxlength="255"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                </div>

                <div class="mb-4">
                    <label for="courseDescription" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                    <textarea id="courseDescription" name="description" rows="3"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="courseImage" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <input type="file" id="courseImage" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                    <div id="imagePreviewContainer" class="mt-2 hidden">
                        <img id="imagePreview" class="h-32 object-cover rounded-lg">
                        <button type="button" onclick="removeImagePreview()" class="mt-1 text-red-500 text-sm">
                            <i class="fas fa-times mr-1"></i>Supprimer l'image
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="courseDuration" class="block text-sm font-medium text-gray-700 mb-1">Durée (minutes) *</label>
                    <input type="number" id="courseDuration" name="duration" min="1"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4D44B5]" required>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelCourseBtn"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit" id="submitCourseBtn"
                        class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const newCourseBtn = document.getElementById('newCourseBtn');
const emptyNewCourseBtn = document.getElementById('emptyNewCourseBtn');
const courseModal = document.getElementById('courseModal');
const cancelCourseBtn = document.getElementById('cancelCourseBtn');
const courseForm = document.getElementById('courseForm');
const modalCourseTitle = document.getElementById('modalCourseTitle');
const courseId = document.getElementById('courseId');
const _methodCourse = document.getElementById('_methodCourse');
const courseImage = document.getElementById('courseImage');
const imagePreviewContainer = document.getElementById('imagePreviewContainer');
const imagePreview = document.getElementById('imagePreview');

newCourseBtn.addEventListener('click', () => {
    courseModal.classList.remove('hidden');
    modalCourseTitle.textContent = 'Nouveau Cours';
    courseForm.reset();
    courseId.value = '';
    _methodCourse.value = 'POST';
    imagePreviewContainer.classList.add('hidden');
});

if (emptyNewCourseBtn) {
    emptyNewCourseBtn.addEventListener('click', () => {
        courseModal.classList.remove('hidden');
        modalCourseTitle.textContent = 'Nouveau Cours';
        courseForm.reset();
        courseId.value = '';
        _methodCourse.value = 'POST';
        imagePreviewContainer.classList.add('hidden');
    });
}

cancelCourseBtn.addEventListener('click', () => {
    courseModal.classList.add('hidden');
});

function handleEditCourse(id, title, description, duration, imageUrl) {
    courseModal.classList.remove('hidden');
    modalCourseTitle.textContent = 'Modifier Cours';
    courseId.value = id;
    _methodCourse.value = 'PUT';
    document.getElementById('courseTitle').value = title;
    document.getElementById('courseDescription').value = description;
    document.getElementById('courseDuration').value = duration;
    
    if (imageUrl) {
        imagePreview.src = imageUrl;
        imagePreviewContainer.classList.remove('hidden');
    } else {
        imagePreviewContainer.classList.add('hidden');
    }
}

function handleDeleteCourse(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')) {
        fetch(`/admin/courses/${id}`, {
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
                loadCourses();
            }
        });
    }
}

courseImage.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreviewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(this.files[0]);
    }
});

function removeImagePreview() {
    courseImage.value = '';
    imagePreviewContainer.classList.add('hidden');
}

courseForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = courseId.value ? `/admin/courses/${courseId.value}` : `/admin/titles/{{ $title->id }}/courses`;
    const method = courseId.value ? 'PUT' : 'POST';

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
            courseModal.classList.add('hidden');
            loadCourses();
        }
    })
    .catch(error => console.error('Error:', error));
});

function loadCourses() {
    fetch(`/admin/titles/{{ $title->id }}/courses`)
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newContent = doc.getElementById('coursesContainer').innerHTML;
        document.getElementById('coursesContainer').innerHTML = newContent;
    });
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

  

    </script>
@endsection
