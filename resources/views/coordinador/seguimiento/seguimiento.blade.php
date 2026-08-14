@extends('layouts.coordinador', ['active' => 'seguimiento', 'title' => 'Seguimiento de Alumnos - Coordinador'])

@section('content')
    <x-page-header title="Seguimiento de Horas" description="Monitorea el progreso de los estudiantes que tienen una práctica profesional activa">
        <x-slot:actions>
            <div class="bg-[#6BA53A]/10 text-[#4E7D24] px-4 py-2 rounded-xl font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Total Activos: {{ $totalActivos }}
            </div>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Gráfica de Progreso -->
        <div class="lg:col-span-1 glass-card rounded-3xl p-6 fade-in-up">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Progreso General</h3>
            <p class="text-xs text-gray-500 mb-6">Distribución de alumnos según su porcentaje de horas completadas.</p>
            
            <div class="relative h-64 w-full flex items-center justify-center">
                <canvas id="horasPieChart"></canvas>
            </div>
        </div>

        <!-- Tabla de Alumnos Activos -->
        <div class="lg:col-span-2 glass-card rounded-3xl p-6 fade-in-up delay-100 flex flex-col h-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Estudiantes Activos</h3>
            </div>

            <div class="overflow-x-auto flex-grow custom-scrollbar">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Institución</th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Horas</th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Progreso</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @forelse($alumnosPaginados as $alumno)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <td class="px-4 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $alumno['nombre'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $alumno['matricula'] }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-gray-700 font-medium">{{ $alumno['unidad_receptora'] }}</span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="font-bold text-gray-900">{{ $alumno['horas_completadas'] }}</span>
                                    <span class="text-xs text-gray-500">/ 480</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2 w-full max-w-[120px] mx-auto">
                                        <div class="flex-grow bg-gray-200 rounded-full h-2 overflow-hidden flex">
                                            <div class="bg-[#4E7D24] h-full" style="width: {{ $alumno['porcentaje'] }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-[#4E7D24] w-8 text-right">{{ $alumno['porcentaje'] }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="text-sm font-medium text-gray-500">No hay estudiantes activos en este momento.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($alumnosPaginados->hasPages())
                <div class="mt-4 border-t border-gray-100 pt-4">
                    {{ $alumnosPaginados->links() }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function() {
            const canvas = document.getElementById('horasPieChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            
            const data = {
                labels: ['0% - 25%', '26% - 50%', '51% - 75%', '76% - 100%'],
                datasets: [{
                    data: [
                        {{ $horasRango['0_25'] }},
                        {{ $horasRango['26_50'] }},
                        {{ $horasRango['51_75'] }},
                        {{ $horasRango['76_100'] }}
                    ],
                    backgroundColor: [
                        '#F87171', // Red-400
                        '#FBBF24', // Amber-400
                        '#60A5FA', // Blue-400
                        '#4E7D24'  // Verde UdeC
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            };

            const isEmpty = data.datasets[0].data.every(val => val === 0);

            if (isEmpty) {
                // Dummy data para gráfica vacía
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sin Datos'],
                        datasets: [{ data: [1], backgroundColor: ['#E5E7EB'], borderWidth: 0 }]
                    },
                    options: {
                        cutout: '75%',
                        plugins: { legend: { display: false }, tooltip: { enabled: false } }
                    }
                });
            } else {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: { size: 11, family: "'Inter', sans-serif", weight: '600' }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#1f2937',
                                bodyColor: '#4b5563',
                                bodyFont: { weight: 'bold' },
                                padding: 12,
                                boxPadding: 6,
                                borderColor: 'rgba(0,0,0,0.05)',
                                borderWidth: 1,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed !== null) { label += context.parsed + ' alumnos'; }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        })();
    </script>
@endsection
