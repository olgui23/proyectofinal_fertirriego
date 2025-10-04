@extends('layout')

@section('title', 'Inicio - Panel de Administración')


@section('cabecera')

    <div class="navbar-spacer" style="height: 80px;"></div>

@endsection

@section('contenido')

<!-- Estadísticas rápidas -->
<div class="row mb-4" style="margin-top: 1%;">
    <!-- Total de Usuarios -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total de Usuarios</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agricultores -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Agricultores</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $farmersCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-seedling fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compradores -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Compradores</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $buyersCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cultivos Activos -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Cultivos Activos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeCrops }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tractor fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Panel de Administración
        </h1>
        <div class="d-flex">
            <span class="badge bg-primary fs-6">
                <i class="fas fa-user-shield me-1"></i> Administrador
            </span>
        </div>
    </div>


    <div class="row">
        <!-- Gráfico de usuarios por rol -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribución de Usuarios por Rol</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-primary btn-block">
                            <i class="fas fa-users me-2"></i>Gestionar Usuarios
                        </a>
                        <a href="#" class="btn btn-success btn-block">
                            <i class="fas fa-seedling me-2"></i>Gestionar Cultivos
                        </a>
                        <a href="#" class="btn btn-info btn-block">
                            <i class="fas fa-tools me-2"></i>Gestionar Equipos
                        </a>
                        <a href="#" class="btn btn-warning btn-block">
                            <i class="fas fa-chart-bar me-2"></i>Ver Reportes
                        </a>
                        <a href="#" class="btn btn-secondary btn-block">
                            <i class="fas fa-cog me-2"></i>Configuración del Sistema
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Últimos usuarios registrados -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Últimos Usuarios Registrados</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->nombre_completo }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->rol === 'Administrador' ? 'primary' : ($user->rol === 'Agricultor' ? 'success' : 'info') }}">
                                            {{ $user->rol }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-primary">Ver todos los usuarios</a>
                </div>
            </div>
        </div>


</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de distribución de usuarios por rol
        const ctx = document.getElementById('userRoleChart').getContext('2d');
        const userRoleChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Administradores', 'Agricultores', 'Compradores'],
                datasets: [{
                    label: 'Cantidad de Usuarios',
                    data: [{ $adminCount }, { $farmersCount }, { $buyersCount }],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        }); // <-- Este paréntesis estaba faltando

        // Actualizar datos cada 60 segundos
        setInterval(() => {
            fetch('{{ route("admin.dashboard.stats") }}')
                .then(response => response.json())
                .then(data => {
                    userRoleChart.data.datasets[0].data = [
                        data.admin_count,
                        data.farmers_count,
                        data.buyers_count
                    ];
                    userRoleChart.update();
                });
        }, 60000);
    }); // <-- Este paréntesis estaba faltando
</script>

@endsection

