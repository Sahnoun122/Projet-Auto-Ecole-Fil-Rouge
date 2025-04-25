@extends('layouts.candidats')

@section('content')
<div class="flex-1 overflow-auto">
    <div class="min-h-screen">
        <header class="bg-[#4D44B5] text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-6">
                <h1 class="text-2xl md:text-3xl font-bold">Résultats du Quiz</h1>
                <p class="mt-1 md:mt-2 text-base md:text-lg text-purple-100">
                    Permis {{ $quiz->type_permis }} - {{ $quiz->title }}
                </p>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-4 md:py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                <div class="bg-white rounded-lg md:rounded-xl shadow-md p-4 md:p-6 border-t-4 border-[#4D44B5]">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-3 md:mb-4">Résumé</h3>
                    
                    <div class="space-y-3 md:space-y-4">
                        <div class="flex items-center justify-between p-2 md:p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-1 md:p-2 rounded-full bg-green-100 text-green-600 mr-2 md:mr-3">
                                    <i class="fas fa-check text-sm md:text-base"></i>
                                </div>
                                <span class="text-sm md:text-base text-gray-700">Bonnes réponses</span>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-green-600">{{ $results['correct_answers'] }}</span>
                                <span class="text-xs md:text-sm text-gray-500 ml-1">({{ $results['correct_percentage'] }}%)</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-2 md:p-3 bg-red-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-1 md:p-2 rounded-full bg-red-100 text-red-600 mr-2 md:mr-3">
                                    <i class="fas fa-times text-sm md:text-base"></i>
                                </div>
                                <span class="text-sm md:text-base text-gray-700">Mauvaises réponses</span>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-red-600">{{ $results['wrong_answers'] }}</span>
                                <span class="text-xs md:text-sm text-gray-500 ml-1">({{ $results['wrong_percentage'] }}%)</span>
                            </div>
                        </div>
                        
                        @if($results['unanswered'] > 0)
                        <div class="flex items-center justify-between p-2 md:p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-1 md:p-2 rounded-full bg-gray-100 text-gray-600 mr-2 md:mr-3">
                                    <i class="fas fa-question text-sm md:text-base"></i>
                                </div>
                                <span class="text-sm md:text-base text-gray-700">Non répondu</span>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-gray-600">{{ $results['unanswered'] }}</span>
                                <span class="text-xs md:text-sm text-gray-500 ml-1">({{ $results['unanswered_percentage'] }}%)</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 md:mt-6 pt-3 md:pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm md:text-base text-gray-700">Score total</span>
                            <span class="font-bold text-base md:text-lg {{ $results['passed'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $results['correct_answers'] }}/40
                            </span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-sm md:text-base text-gray-700">Score requis</span>
                            <span class="text-sm md:text-base font-medium">32/40</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg md:rounded-xl shadow-md p-4 md:p-6">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-3 md:mb-4">Répartition</h3>
                    <div class="h-48 md:h-64 flex items-center justify-center">
                        <canvas id="resultsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg md:rounded-xl shadow-md overflow-hidden mb-6 md:mb-8">
                <div class="border-b border-gray-200 px-4 md:px-6 py-3 md:py-4 flex flex-col md:flex-row md:justify-between md:items-center">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 flex items-center mb-2 md:mb-0">
                        Détail des questions
                    </h3>
                    <div class="flex space-x-2 overflow-x-auto py-1 md:py-0">
                        <span class="whitespace-nowrap px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                            Correct: {{ $results['correct_answers'] }}
                        </span>
                        <span class="whitespace-nowrap px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                            Incorrect: {{ $results['wrong_answers'] }}
                        </span>
                        @if($results['unanswered'] > 0)
                        <span class="whitespace-nowrap px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                            Non répondu: {{ $results['unanswered'] }}
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="divide-y divide-gray-200 max-h-[500px] overflow-y-auto">
                    @foreach($results['details'] as $index => $detail)
                    <div class="p-4 md:p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start">
                            <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 md:h-8 md:w-8 rounded-full 
                                      {{ $detail['is_correct'] ? 'bg-green-100 text-green-800' : ($detail['answered'] ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }} mr-3 md:mr-4 text-xs md:text-sm">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <h4 class="text-base md:text-lg font-medium text-gray-800 mb-2 md:mb-3">{{ $detail['question_text'] }}</h4>
                                
                                @if($detail['answered'])
                                <div class="grid grid-cols-1 gap-3 md:gap-4 mb-2 md:mb-3">
                                    <div class="{{ $detail['is_correct'] ? 'bg-green-50' : 'bg-red-50' }} p-2 md:p-3 rounded-lg">
                                        <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Votre réponse</p>
                                        <p class="{{ $detail['is_correct'] ? 'text-green-800' : 'text-red-800' }} font-medium text-sm md:text-base">
                                            {{ $detail['user_answer'] }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-2 md:p-3 rounded-lg">
                                        <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Bonne réponse</p>
                                        <p class="text-gray-800 font-medium text-sm md:text-base">{{ $detail['correct_answer'] }}</p>
                                    </div>
                                </div>
                                @else
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 md:p-4 mb-2 md:mb-3">
                                    <p class="text-yellow-700 flex items-center text-xs md:text-sm">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        Non répondu
                                    </p>
                                </div>
                                @endif
                                
                                <div class="flex items-center text-xs md:text-sm">
                                    @if($detail['answered'])
                                        @if($detail['is_correct'])
                                            <span class="inline-flex items-center text-green-600">
                                                <i class="fas fa-check-circle mr-1"></i> Correcte
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-red-600">
                                                <i class="fas fa-times-circle mr-1"></i> Incorrecte
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center text-gray-600">
                                            <i class="fas fa-question-circle mr-1"></i> Non répondu
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-3 md:gap-4">
                <a href="{{ route('candidats.quizzes') }}" 
                   class="bg-[#4D44B5] hover:bg-[#3a32a1] text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-medium transition text-center text-sm md:text-base">
                   <i class="fas fa-list mr-1 md:mr-2"></i> Tous les quiz
                </a>
                @if(!$results['passed'])
                <a href="{{ route('candidats.start', $quiz) }}" 
                   class="bg-white hover:bg-gray-100 text-[#4D44B5] border border-[#4D44B5] px-4 md:px-6 py-2 md:py-3 rounded-lg font-medium transition text-center text-sm md:text-base">
                   <i class="fas fa-redo mr-1 md:mr-2"></i> Réessayer
                </a>
                @endif
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('resultsChart').getContext('2d');
        const resultsChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Correctes', 'Incorrectes', 'Non répondues'],
                datasets: [{
                    data: [
                        {{ $results['correct_answers'] }},
                        {{ $results['wrong_answers'] }},
                        {{ $results['unanswered'] }}
                    ],
                    backgroundColor: [
                        '#10B981',
                        '#EF4444',
                        '#9CA3AF'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            }
                        }
                    },
                    tooltip: {
                        bodyFont: {
                            size: window.innerWidth < 768 ? 10 : 12
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: window.innerWidth < 768 ? '60%' : '70%'
            }
        });

        setTimeout(() => {
            const cards = document.querySelectorAll('.grid > div');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.transform = 'translateY(10px)';
                    card.style.opacity = '0';
                    card.style.transition = 'all 0.3s ease-out';
                    
                    setTimeout(() => {
                        card.style.transform = 'translateY(0)';
                        card.style.opacity = '1';
                    }, 300);
                }, index * 100);
            });
        }, 500);

        window.addEventListener('resize', function() {
            resultsChart.options.plugins.legend.labels.font.size = window.innerWidth < 768 ? 10 : 12;
            resultsChart.options.plugins.tooltip.bodyFont.size = window.innerWidth < 768 ? 10 : 12;
            resultsChart.options.cutout = window.innerWidth < 768 ? '60%' : '70%';
            resultsChart.update();
        });
    });
</script>
@endsection