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
          
               

        </div>
        <div class="flex-1 overflow-auto">
         
            <div class="min-h-screen bg-gray-100">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex justify-between items-center mb-8">
                        <div class="text-lg font-medium text-gray-700">
                            Question <span class="font-bold">{{ $currentPosition }}</span>/{{ $totalQuestions }}
                        </div>
                        <div class="relative w-16 h-16">
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="16" fill="none" class="stroke-gray-200" stroke-width="2"></circle>
                                <circle cx="18" cy="18" r="16" fill="none" class="stroke-[#4D44B5]" stroke-width="2"
                                        stroke-dasharray="100" stroke-dashoffset="0" id="countdown-circle">
                                    <animate attributeName="stroke-dashoffset" from="0" to="100" dur="{{ $question->duration }}" 
                                             fill="freeze" id="circle-animation"/>
                                </circle>
                                <text x="18" y="22" text-anchor="middle" class="text-xl font-bold fill-[#4D44B5]" id="countdown-text">
                                    {{ $question->duration }}
                                </text>
                            </svg>
                        </div>
                    </div>
            
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 transition-all duration-500 transform" id="question-card">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $question->question_text }}</h2>
                            @if($question->image_path)
                            <div class="mb-6 flex justify-center">
                                <img src="{{ asset('storage/'.$question->image_path) }}" alt="Question image" 
                                     class="rounded-lg max-h-64 max-w-full">
                            </div>
                            @endif
                        </div>
                    </div>
            
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8" id="choices-grid">
                        @foreach($choices as $choice)
                        <button onclick="selectAnswer({{ $choice->id }}, {{ $choice->is_correct }})"
                                class="p-6 rounded-xl border-2 border-transparent bg-white shadow-md hover:shadow-lg 
                                       transition-all duration-300 transform hover:scale-[1.02] choice-btn
                                       focus:outline-none focus:ring-2 focus:ring-[#4D44B5]"
                                data-choice-id="{{ $choice->id }}"
                                data-is-correct="{{ $choice->is_correct }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#4D44B5] text-white 
                                            flex items-center justify-center font-bold mr-4">
                                    {{ chr(65 + $loop->index) }} 
                                </div>
                                <div class="text-left">
                                    {{ $choice->choice_text }}
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>
            
                    <form id="answerForm" method="POST" 
                          action="{{ route('candidats.questions', ['quiz' => $quiz, 'question' => $question]) }}"
                          class="hidden">
                        @csrf
                        <input type="hidden" name="choice_id" id="selectedChoice">
                    </form>
                </div>
            </div>
            
            <script>
                const duration = {{ $question->duration }};
                let timeLeft = duration;
                const countdownText = document.getElementById('countdown-text');
                const countdownInterval = setInterval(() => {
                    timeLeft--;
                    countdownText.textContent = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        autoSelectAnswer();
                    }
                }, 1000);
            
                function selectAnswer(choiceId, isCorrect) {
                    clearInterval(countdownInterval);
                    
                    document.querySelectorAll('.choice-btn').forEach(btn => {
                        btn.disabled = true;
                        btn.classList.remove('hover:shadow-lg', 'transform', 'hover:scale-[1.02]');
                    });
            
                    const selectedBtn = document.querySelector(`.choice-btn[data-choice-id="${choiceId}"]`);
                    const correctBtn = document.querySelector('.choice-btn[data-is-correct="1"]');
                    
                    if (isCorrect) {
                        selectedBtn.classList.add('bg-green-100', 'border-green-500');
                    } else {
                        selectedBtn.classList.add('bg-red-100', 'border-red-500');
                        correctBtn.classList.add('bg-green-100', 'border-green-500');
                    }
            
                    document.getElementById('selectedChoice').value = choiceId;
                    setTimeout(() => {
                        document.getElementById('answerForm').submit();
                    }, 1500);
                }
            
                function autoSelectAnswer() {
                    const choices = document.querySelectorAll('.choice-btn');
                    if (choices.length > 0) {
                        const randomChoice = choices[Math.floor(Math.random() * choices.length)];
                        selectAnswer(
                            randomChoice.dataset.choiceId, 
                            randomChoice.dataset.isCorrect === '1'
                        );
                    }
                }
            
                document.addEventListener('DOMContentLoaded', () => {
                    const questionCard = document.getElementById('question-card');
                    questionCard.classList.add('opacity-0', 'translate-y-6');
                    
                    setTimeout(() => {
                        questionCard.classList.remove('opacity-0', 'translate-y-6');
                    }, 100);
                });
 

        



    </script>

</body>

</html>
