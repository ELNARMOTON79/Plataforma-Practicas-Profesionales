                <!-- Circular Step Progress Indicator -->
                <div class="relative flex items-center justify-between w-full max-w-md mx-auto mt-4 mb-12">
                    <!-- Line segment background -->
                    <div class="absolute left-[25%] right-[25%] top-6 h-[2px] bg-gray-200 z-0"></div>
                    
                    <!-- Line segment active -->
                    <div class="absolute left-[25%] top-6 h-[2px] bg-[#8cc772] z-0 transition-all duration-300" style="width: {{ $progress ?? '0%' }};"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 {{ $step >= 1 ? 'border-[#8cc772] bg-white text-[#4E7D24]' : 'border-gray-300 bg-white text-gray-400' }} shadow-sm transition-all duration-200">
                            <!-- Ícono de Empresa -->
                            <svg class="w-5 h-5 {{ $step >= 1 ? 'text-[#6BA53A]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="mt-3 text-xs sm:text-sm font-semibold {{ $step >= 1 ? 'text-[#6BA53A]' : 'text-gray-400 font-medium' }} text-center max-w-[140px] leading-tight">Informacion de la Empresa</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full {{ $step >= 2 ? 'border-2 border-[#8cc772] bg-white text-[#4E7D24]' : 'border border-gray-300 bg-white text-gray-400' }} transition-all duration-200">
                            <!-- Ícono de Detalles -->
                            <svg class="w-5 h-5 {{ $step >= 2 ? 'text-[#6BA53A]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="mt-3 text-xs sm:text-sm {{ $step >= 2 ? 'font-semibold text-[#6BA53A]' : 'font-medium text-gray-400' }} text-center max-w-[140px] leading-tight">Detalles de la Practica</span>
                    </div>
                </div>
