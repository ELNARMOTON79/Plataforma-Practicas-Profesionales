                <form action="{{ route('estudiante.nuevaSolicitudDetalles') }}" method="GET" class="mt-6 space-y-6">
                    @if(isset($unidadSelected) && $unidadSelected)
                        <input type="hidden" name="ur_id" value="{{ $unidadSelected->id }}" />
                    @endif
                    <div class="grid gap-5">
                        <!-- Nombre de la Empresa -->
                        <div class="space-y-2">
                            <div class="relative">
                                <input type="text" name="empresa_nombre" value="{{ old('empresa_nombre', $unidadSelected?->nombre_empresa ?? request('empresa_nombre', '')) }}" placeholder="Buscar empresa..." class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->nombre_empresa) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 pl-4 pr-11 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->nombre_empresa) ? 'readonly' : '' }} required />
                                <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Dirección de la Empresa -->
                        <div class="space-y-2">
                            <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Dirección de la Empresa <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <div>
                                <input type="text" name="empresa_direccion" value="{{ old('empresa_direccion', $unidadSelected?->direccion ?? request('empresa_direccion', '')) }}" placeholder="Ej: Miguel de la Madrid #22" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->direccion) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->direccion) ? 'readonly' : '' }} required />
                            </div>
                        </div>

                        <!-- Nombre del Supervisor & Teléfono del Supervisor -->
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Nombre del Supervisor <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="text" name="supervisor_nombre" value="{{ old('supervisor_nombre', $unidadSelected?->titular ?? request('supervisor_nombre', '')) }}" placeholder="Nombre completo" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->titular) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->titular) ? 'readonly' : '' }} required />
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Teléfono del Supervisor
                                    </span>
                                </label>
                                <input type="tel" name="supervisor_telefono" value="{{ old('supervisor_telefono', $unidadSelected?->telefono ?? request('supervisor_telefono', '')) }}" placeholder="(809) 123-4567" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->telefono) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->telefono) ? 'readonly' : '' }} />
                            </div>
                        </div>

                        <!-- Email del Supervisor -->
                        <div class="space-y-2">
                            <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Email del Supervisor <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input type="email" name="supervisor_email" value="{{ old('supervisor_email', $unidadSelected?->user?->correo ?? request('supervisor_email', '')) }}" placeholder="supervisor@empresa.com" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && ($unidadSelected->user?->correo || request('supervisor_email'))) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && ($unidadSelected->user?->correo || request('supervisor_email'))) ? 'readonly' : '' }} required />
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-end items-center pt-4">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#4E7D24] hover:bg-[#3b6620] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-250 cursor-pointer">
                            Siguiente <span class="ml-2 font-bold">&gt;</span>
                        </button>
                    </div>
                </form>
