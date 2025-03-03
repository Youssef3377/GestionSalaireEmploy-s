@extends('layouts.template')

@section('content')
<h1 class="app-page-title">Dashboard</h1>

<div class="row mt-2 mb-2">
    @if ($payementNotification)
        <div class="alert alert-warning">
            {{ $payementNotification }}
        </div>
    @endif
</div>

<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat card-hover shadow-sm h-100 bg-gradient-primary rounded-3 p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="stats-type mb-2 text-primary-light">Total Départements</h4>
                    <div class="stats-figure fs-2 fw-bold text-white">{{ $totalDepartements }}</div>
                </div>
                <i class="fa-solid fa-building fa-3x icon-opacity text-white"></i>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat card-hover shadow-sm h-100 bg-gradient-warning rounded-3 p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="stats-type mb-2 text-warning-light">Total Employés</h4>
                    <div class="stats-figure fs-2 fw-bold text-white">{{ $totalEmployers }}</div>
                </div>
                <i class="fa-solid fa-users fa-3x icon-opacity text-white"></i>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat card-hover shadow-sm h-100 bg-gradient-info rounded-3 p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="stats-type mb-2 text-info-light">Total Admins</h4>
                    <div class="stats-figure fs-2 fw-bold text-white">{{ $totalAdmin }}</div>
                </div>
                <i class="fa-solid fa-user-shield fa-3x icon-opacity text-white"></i>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat card-hover shadow-sm h-100 bg-gradient-danger rounded-3 p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="stats-type mb-2 text-danger-light">Retard Paiement</h4>
                    <div class="stats-figure fs-2 fw-bold text-white">0</div>
                </div>
                <i class="fa-solid fa-exclamation-circle fa-3x icon-opacity text-white"></i>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-lg-6">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Statistiques en Pourcentage</h4>
            <canvas id="statsPercentageChart"></canvas>

        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="#"></a>
    </div><!--//app-card-->
</div><!--//col-->

@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('statsPercentageChart').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Départements', 'Employés', 'Admins'],
                datasets: [{
                    label: 'Statistiques en Pourcentage',
                    data: [{{ $totalDepartements }}, {{ $totalEmployers }}, {{ $totalAdmin }}],  // Remplace par tes variables
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',  // Bleu pour Départements
                        'rgba(255, 159, 64, 0.6)',  // Orange pour Employés
                        'rgba(75, 192, 192, 0.6)'   // Vert pour Admins
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' personnes';  // Affiche le nombre de personnes dans chaque catégorie
                            }
                        }
                    },
                    datalabels: {
                        formatter: function(value, context) {
                            const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                            const percentage = ((value / total) * 100).toFixed(2); // Calcule le pourcentage
                            return percentage + '%'; // Affiche le pourcentage
                        },
                        color: '#fff', // Couleur du texte pour les pourcentages
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        padding: 10
                    }
                }
            }
        });
    });
</script>
@endsection
