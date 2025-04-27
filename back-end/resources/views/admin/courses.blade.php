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
        <button data-modal-target="courseModal" data-modal-toggle="courseModal"
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
                    <button data-modal-target="courseModal" data-modal-toggle="courseModal"
                        class="bg-[#4D44B5] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#3a32a1] transition">
                        <i class="fas fa-plus mr-2"></i> Créer un cours
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @foreach ($courses as $course)
                    <div class="border rounded-lg p-4 hover:shadow-md transition flex flex-col h-full">
                        <div class="mb-4 h-40 bg-gray-100 rounded-lg overflow-hidden">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        <h6 class="text-lg font-semibold text-[#4D44B5] mb-2">{{ $course->title }}</h6>
                        <div class="flex justify-between items-center">
                            <button data-modal-target="detailModal" data-modal-toggle="detailModal"
                                onclick="showCourseDetails('{{ $course->title }}', '{{ $course->description }}', '{{ $course->image ? asset('storage/' . $course->image) : '' }}')"
                                class="text-gray-600 hover:text-[#4D44B5] p-1" title="Voir les détails">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="flex space-x-2">
                                <button data-modal-target="courseModal" data-modal-toggle="courseModal"
                                    onclick="prepareEditForm('{{ $course->id }}', '{{ $course->title }}', `{{ $course->description }}`, '{{ $course->image ? asset('storage/' . $course->image) : '' }}')"
                                    class="text-[#4D44B5] hover:text-[#3a32a1] p-1" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"
                                        title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <div id="courseModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900" id="modalCourseTitle">
                        Nouveau Cours
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="courseModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Fermer</span>
                    </button>
                </div>
                <form id="courseForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.courses.store', $title->id) }}">
                    @csrf
                    <input type="hidden" id="courseId" name="id">
                    <input type="hidden" id="titleId" name="title_id" value="{{ $title->id }}">
                    <input type="hidden" id="_methodCourse" name="_method" value="POST">

                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <label for="courseTitle" class="block mb-2 text-sm font-medium text-gray-900">Titre *</label>
                            <input type="text" id="courseTitle" name="title" maxlength="255"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4D44B5] focus:border-[#4D44B5] block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="courseDescription" class="block mb-2 text-sm font-medium text-gray-900">Description *</label>
                            <textarea id="courseDescription" name="description" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4D44B5] focus:border-[#4D44B5] block w-full p-2.5" required></textarea>
                        </div>
                        <div>
                            <label for="courseImage" class="block mb-2 text-sm font-medium text-gray-900">Image</label>
                            <input type="file" id="courseImage" name="image" accept="image/*" 
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            <div id="imagePreviewContainer" class="mt-2 hidden">
                                <img id="imagePreview" class="h-32 w-full object-cover rounded-lg">
                                <button type="button" onclick="removeImagePreview()" class="mt-1 text-red-500 text-sm">
                                    <i class="fas fa-times mr-1"></i>Supprimer l'image
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-[#4D44B5] hover:bg-[#3a32a1] focus:ring-4 focus:outline-none focus:ring-[#4D44B5] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Enregistrer
                        </button>
                        <button type="button" data-modal-toggle="courseModal" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="detailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900" id="detailModalTitle"></h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="detailModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Fermer</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div class="flex justify-center items-center ">
                        {{-- <img
                            id="detailModalImage"
                            class="w-80 h-80 object-cover rounded shadow-md"
                            src=""
                            onerror="this.src='{{ asset('course/') }}'"
                            alt="Image du cours"
                        > --}}
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line" id="detailModalDescription"></p>
                    </div>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button type="button" data-modal-toggle="detailModal" class="text-white bg-[#4D44B5] hover:bg-[#3a32a1] focus:ring-4 focus:outline-none focus:ring-[#4D44B5] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.6/dist/flowbite.min.js"></script>
<script>
    function prepareEditForm(id, title, description, imageUrl) {
        $('#modalCourseTitle').text('Modifier Cours');
        $('#courseId').val(id);
        $('#_methodCourse').val('PUT');
        $('#courseTitle').val(title);
        $('#courseDescription').val(description);
        
        if (imageUrl) {
            $('#imagePreview').attr('src', imageUrl);
            $('#imagePreviewContainer').removeClass('hidden');
        } else {
            $('#imagePreviewContainer').addClass('hidden');
        }
        
        $('#courseForm').attr('action', `/admin/courses/${id}`);
    }

    function showCourseDetails(title, description, imageUrl) {
        $('#detailModalTitle').text(title);
        $('#detailModalDescription').text(description);
        $('#detailModalImage').attr('src', imageUrl || '{{ asset('course/') }}');
    }

    $('#courseImage').change(function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreviewContainer').removeClass('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    function removeImagePreview() {
        $('#courseImage').val('');
        $('#imagePreviewContainer').addClass('hidden');
    }

    $(document).ready(function() {
        $('[data-modal-toggle]').click(function() {
            const target = $(this).attr('data-modal-target');
            $(target).toggleClass('hidden');
        });

        $('[data-modal-target="courseModal"]').not('[onclick]').click(function() {
            $('#modalCourseTitle').text('Nouveau Cours');
            $('#courseForm')[0].reset();
            $('#courseId').val('');
            $('#_methodCourse').val('POST');
            $('#imagePreviewContainer').addClass('hidden');
            $('#courseForm').attr('action', '{{ route("admin.courses.store", $title->id) }}');
        });
    });
</script>
@endsection