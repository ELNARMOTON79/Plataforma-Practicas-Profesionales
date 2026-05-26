<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 fade-in-up delay-100">
                    
                    <!-- Metric Card 1 -->
                    <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-16 h-16 text-[#4E7D24]" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-500 mb-2">Total Alumnos</span>
                        <div class="flex items-end gap-3 mb-2">
                            <span class="text-4xl font-extrabold text-gray-900">{{ number_format($totalAlumnos) }}</span>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">Activos en prácticas profesionales</span>
                    </div>

                    <!-- Metric Card 2 -->
                    <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-500 mb-2">Convenios Activos</span>
                        <div class="flex items-end gap-3 mb-2">
                            <span class="text-4xl font-extrabold text-gray-900">{{ number_format($conveniosActivos) }}</span>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">Empresas e instituciones vinculadas</span>
                    </div>

                    <!-- Metric Card 3 -->
                    <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-16 h-16 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-500 mb-2">Solicitudes Pendientes</span>
                        <div class="flex items-end gap-3 mb-2">
                            <span class="text-4xl font-extrabold text-gray-900">{{ number_format($solicitudesPendientes) }}</span>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">Esperando aprobación de coordinador</span>
                    </div>

                    <!-- Metric Card 4 -->
                    <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-red-100 hover:border-red-300">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-red-500 mb-2">Alertas del Sistema</span>
                        <div class="flex items-end gap-3 mb-2">
                            <span class="text-4xl font-extrabold text-red-600">{{ number_format($alertasSistema) }}</span>
                        </div>
                        <span class="text-xs text-red-400 font-medium">Convenios por vencer en 30 días</span>
                    </div>

                </div>
