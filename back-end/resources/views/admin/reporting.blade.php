@extends('layouts.admin')
@section('content')

        <div class="flex-1 overflow-auto">
            <div class="bg-[#4D44B5] text-white shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">Reporting des Examens</h1>
                        <p class="text-white opacity-80 text-sm md:text-base">Statistiques et analyses des examens passés</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                        <button onclick="generatePdfReport()"
                            class="bg-white text-[#4D44B5] px-3 py-1 md:px-4 md:py-2 rounded-lg font-medium hover:bg-gray-100 transition text-center text-sm md:text-base">
                            <i class="fas fa-file-pdf mr-2"></i>Exporter PDF
                        </button>
                    </div>
                </div>
            </div>
        
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <div class="flex justify-between items-center">
                            <p class="text-sm md:text-base">{{ session('success') }}</p>
                            <button type="button" class="text-green-700"
                                onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
                <div class="bg-white rounded-xl shadow p-4 md:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtrer les données</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                            <select id="periode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm">
                                <option value="7">7 derniers jours</option>
                                <option value="30">30 derniers jours</option>
                                <option value="90">3 derniers mois</option>
                                <option value="365">12 derniers mois</option>
                                <option value="custom">Personnalisée</option>
                            </select>
                        </div>
                        <div id="customDateRange" class="hidden md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                    <input type="date" id="date_debut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                    <input type="date" id="date_fin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-3 flex justify-end">
                            <button onclick="loadReportData()"
                                class="bg-[#4D44B5] text-white px-4 py-2 rounded-lg hover:bg-[#3a32a1] transition font-medium text-sm">
                                <i class="fas fa-filter mr-2"></i>Filtrer
                            </button>
                        </div>
                    </div>
                </div>
        
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Examens total</p>
                                <h3 class="text-2xl font-bold text-[#4D44B5]" id="total_examens">0</h3>
                            </div>
                            <div class="bg-[#4D44B5] bg-opacity-10 p-3 rounded-full">
                                <i class="fas fa-clipboard-list text-[#4D44B5] text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Examens terminés</p>
                                <h3 class="text-2xl font-bold text-[#4D44B5]" id="examens_termines">0</h3>
                            </div>
                            <div class="bg-[#4D44B5] bg-opacity-10 p-3 rounded-full">
                                <i class="fas fa-check-circle text-[#4D44B5] text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Taux de réussite</p>
                                <h3 class="text-2xl font-bold text-[#4D44B5]" id="taux_reussite_global">0%</h3>
                            </div>
                            <div class="bg-[#4D44B5] bg-opacity-10 p-3 rounded-full">
                                <i class="fas fa-chart-line text-[#4D44B5] text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Candidats inscrits</p>
                                <h3 class="text-2xl font-bold text-[#4D44B5]" id="candidats_inscrits">0</h3>
                            </div>
                            <div class="bg-[#4D44B5] bg-opacity-10 p-3 rounded-full">
                                <i class="fas fa-users text-[#4D44B5] text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow p-4 md:p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Taux de réussite par type d'examen</h2>
                        <div class="h-64" id="successRateChart"></div>
                    </div>
        
                    <div class="bg-white rounded-xl shadow p-4 md:p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Top moniteurs</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moniteur</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Examens</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taux réussite</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="moniteursTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        
                <div class="bg-white rounded-xl shadow p-4 md:p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Détails des examens</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taux réussite</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidats</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="examsTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        
            <div id="pdfExportModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 p-2 md:p-4">
                <div class="bg-white w-full max-w-md rounded-lg overflow-hidden">
                    <div class="bg-[#4D44B5] text-white px-4 py-3 md:px-6 md:py-4 flex justify-between items-center">
                        <h2 class="text-lg md:text-xl font-bold">Exporter le rapport</h2>
                        <button onclick="closeModal('pdfExportModal')" class="text-white hover:text-gray-200 text-lg">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-4 md:p-6">
                        <form id="pdfExportForm">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                                    <select name="periode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm">
                                        <option value="7">7 derniers jours</option>
                                        <option value="30">30 derniers jours</option>
                                        <option value="90">3 derniers mois</option>
                                        <option value="365">12 derniers mois</option>
                                        <option value="custom">Personnalisée</option>
                                    </select>
                                </div>
                                <div id="pdfCustomDateRange" class="hidden">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                            <input type="date" name="date_debut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                            <input type="date" name="date_fin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D44B5] focus:border-[#4D44B5] transition text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="closeModal('pdfExportModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium text-sm">
                                    Annuler
                                </button>
                                <button type="submit" class="px-4 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#3a32a1] transition font-medium text-sm">
                                    <i class="fas fa-file-pdf mr-2"></i>Générer PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
            <div id="successToast" class="hidden fixed top-4 right-4 z-50">
                <div class="bg-green-500 text-white px-4 py-3 md:px-6 md:py-4 rounded-lg shadow-lg flex items-center text-sm md:text-base">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span id="successMessage"></span>
                </div>
            </div>
        
            <script>
                let successRateChart;
                
                function initChart(data) {
                    const options = {
                        series: [{
                            name: 'Taux de réussite',
                            data: data.map(item => parseFloat(item.taux_moyen.toFixed(2)))
                        }],
                        chart: {
                            type: 'bar',
                            height: '100%',
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#4D44B5'],
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                horizontal: false,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: data.map(item => item.type),
                            labels: {
                                style: {
                                    colors: '#6B7280',
                                    fontSize: '12px'
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Taux de réussite (%)',
                                style: {
                                    color: '#6B7280',
                                    fontSize: '12px'
                                }
                            },
                            labels: {
                                formatter: function(val) {
                                    return val.toFixed(0) + '%';
                                },
                                style: {
                                    colors: '#6B7280',
                                    fontSize: '12px'
                                }
                            },
                            min: 0,
                            max: 100
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val.toFixed(2) + '%';
                                }
                            }
                        }
                    };
        
                    successRateChart = new ApexCharts(document.querySelector("#successRateChart"), options);
                    successRateChart.render();
                }
        
                function toggleModal(modalId, show = true) {
                    const modal = document.getElementById(modalId);
                    if (show) {
                        modal.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    } else {
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                }
        
                function closeModal(modalId) {
                    toggleModal(modalId, false);
                }
        
                $(document).ready(function() {
                    loadReportData();
        
                    $('#periode').change(function() {
                        if ($(this).val() === 'custom') {
                            $('#customDateRange').removeClass('hidden');
                        } else {
                            $('#customDateRange').addClass('hidden');
                        }
                    });
        
                    // PDF export form
                    $('select[name="periode"]', '#pdfExportForm').change(function() {
                        if ($(this).val() === 'custom') {
                            $('#pdfCustomDateRange').removeClass('hidden');
                        } else {
                            $('#pdfCustomDateRange').addClass('hidden');
                        }
                    });
        
                    $('#pdfExportForm').submit(function(e) {
                        e.preventDefault();
                        const formData = $(this).serialize();
                        
                        const $submitBtn = $(this).find('button[type="submit"]');
                        const originalBtnText = $submitBtn.html();
                        $submitBtn.prop('disabled', true);
                        $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Génération...');
        
                        $.ajax({
                            url: '{{ route("admin.reporting.generate-pdf") }}',
                            method: 'POST',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success: function(blob) {
                                const url = window.URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.href = url;
                                a.download = 'rapport-examens-' + new Date().toISOString().split('T')[0] + '.pdf';
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                                window.URL.revokeObjectURL(url);
                                closeModal('pdfExportModal');
                                showToast('Rapport PDF généré avec succès');
                            },
                            error: function(xhr) {
                                showToast('Erreur lors de la génération du PDF', false);
                            },
                            complete: function() {
                                $submitBtn.prop('disabled', false);
                                $submitBtn.html(originalBtnText);
                            }
                        });
                    });
                });
        
                function loadReportData() {
                    const periode = $('#periode').val();
                    let startDate, endDate;
        
                    if (periode === 'custom') {
                        startDate = $('#date_debut').val();
                        endDate = $('#date_fin').val();
                        
                        if (!startDate || !endDate) {
                            showToast('Veuillez sélectionner une plage de dates', false);
                            return;
                        }
                    } else {
                        const days = parseInt(periode);
                        endDate = new Date().toISOString().split('T')[0];
                        const start = new Date();
                        start.setDate(start.getDate() - days);
                        startDate = start.toISOString().split('T')[0];
                    }
        
                    $('#total_examens, #examens_termines, #taux_reussite_global, #candidats_inscrits').text('...');
                    $('#moniteursTableBody, #examsTableBody').html('<tr><td colspan="5" class="text-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i>Chargement...</td></tr>');
        
                    $.ajax({
                        url: '{{ route("admin.reporting.data") }}',
                        method: 'GET',
                        data: {
                            startDate: startDate,
                            endDate: endDate
                        },
                        success: function(data) {
                            $('#total_examens').text(data.stats.total_examens);
                            $('#examens_termines').text(data.stats.examens_termines);
                            $('#taux_reussite_global').text(data.stats.taux_reussite_global ? data.stats.taux_reussite_global.toFixed(2) + '%' : 'N/A');
                            $('#candidats_inscrits').text(data.stats.candidats_inscrits);
        
                            if (successRateChart) {
                                successRateChart.updateSeries([{
                                    name: 'Taux de réussite',
                                    data: data.successRates.map(item => parseFloat(item.taux_moyen.toFixed(2)))
                                }]);
                                successRateChart.updateOptions({
                                    xaxis: {
                                        categories: data.successRates.map(item => item.type)
                                    }
                                });
                            } else {
                                initChart(data.successRates);
                            }
        
                            let moniteursHtml = '';
                            if (data.moniteursStats.length > 0) {
                                data.moniteursStats.forEach(moniteur => {
                                    moniteursHtml += `
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${moniteur.name}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${moniteur.exams_termines}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 py-1 rounded-full ${moniteur.taux_reussite_moyen >= 70 ? 'bg-green-100 text-green-800' : moniteur.taux_reussite_moyen >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                                    ${moniteur.taux_reussite_moyen ? moniteur.taux_reussite_moyen.toFixed(2) + '%' : 'N/A'}
                                                </span>
                                            </td>
                                        </tr>
                                    `;
                                });
                            } else {
                                moniteursHtml = '<tr><td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">Aucun moniteur trouvé</td></tr>';
                            }
                            $('#moniteursTableBody').html(moniteursHtml);
        
                            let examsHtml = '';
                            if (data.exams.length > 0) {
                                data.exams.forEach(exam => {
                                    examsHtml += `
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${new Date(exam.date_exam).toLocaleDateString()}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${exam.type}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 py-1 rounded-full ${exam.statut === 'termine' ? 'bg-green-100 text-green-800' : exam.statut === 'en_cours' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'}">
                                                    ${exam.statut === 'termine' ? 'Terminé' : exam.statut === 'en_cours' ? 'En cours' : 'Planifié'}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                ${exam.taux_reussite ? exam.taux_reussite.toFixed(2) + '%' : 'N/A'}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${exam.nombre_presents || 0}/${exam.nombre_inscrits || 0}</td>
                                        </tr>
                                    `;
                                });
                            } else {
                                examsHtml = '<tr><td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">Aucun examen trouvé</td></tr>';
                            }
                            $('#examsTableBody').html(examsHtml);
                        },
                        error: function(xhr) {
                            showToast('Erreur lors du chargement des données', false);
                        }
                    });
                }
        
                function generatePdfReport() {
                    toggleModal('pdfExportModal');
                }
        
                function showToast(message, isSuccess = true) {
                    const toast = $('#successToast');
                    const toastMessage = $('#successMessage');
        
                    toastMessage.text(message);
                    toast.removeClass('hidden bg-red-500').addClass(isSuccess ? 'bg-green-500' : 'bg-red-500');
        
                    setTimeout(() => {
                        toast.addClass('hidden');
                    }, 3000);
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
    </script>
@endsection
