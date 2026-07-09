            <!-- Quick Actions -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Accesos Rápidos</h3>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('estudiante.convenios') }}" class="flex items-center gap-4 p-3.5 bg-gradient-to-r from-[#4E7D24]/10 to-transparent hover:from-[#4E7D24]/15 rounded-2xl border border-[#4E7D24]/10 transition-all group">
                        <div class="w-10 h-10 bg-[#4E7D24] text-white rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Buscar Convenios</span>
                            <span class="text-xs text-gray-500 font-medium">Ver empresas y vacantes</span>
                        </div>
                    </a>

                    <a href="{{ route('estudiante.proyecto') }}" class="flex items-center gap-4 p-3.5 bg-gradient-to-r from-blue-50 to-transparent hover:from-blue-100/50 rounded-2xl border border-blue-100 transition-all group">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Subir Documento</span>
                            <span class="text-xs text-gray-500 font-medium">Carga de trámites en formato PDF</span>
                        </div>
                    </a>
                </div>
            </div>
