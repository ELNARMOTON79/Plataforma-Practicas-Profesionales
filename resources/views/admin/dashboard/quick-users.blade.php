<div class="glass-card rounded-3xl p-8 fade-in-up delay-200 flex-1 flex flex-col min-h-0">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Gestión Rápida de Usuarios
                        </h2>
                        <a href="{{ route('admin.usuarios') }}" class="text-sm font-bold text-[#6BA53A] hover:text-[#4E7D24] transition-colors">Ver todos</a>
                    </div>
                    
                    <div class="overflow-hidden bg-white/60 rounded-2xl border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rol</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-transparent divide-y divide-gray-200">
                                @forelse($recentUsers as $usuario)
                                    @php
                                        $nombre = '';
                                        $avatarBg = 'bg-gray-100 text-gray-600';
                                        $avatarText = 'US';
                                        $rolPill = '';
                                        
                                        if ($usuario->rol_id == 1) {
                                            $nombre = $usuario->coordinador->nombre_completo ?? 'Administrador General';
                                            $avatarBg = 'bg-gray-100 text-gray-600';
                                            $avatarText = 'AD';
                                            $rolPill = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-gray-100 text-gray-700 border border-gray-200">Administrador</span>';
                                        } elseif ($usuario->rol_id == 2) {
                                            $nombre = $usuario->coordinador->nombre_completo ?? 'Usuario Coordinador';
                                            $avatarBg = $usuario->activo ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400';
                                            $avatarText = 'CO';
                                            $rolPill = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-blue-50 text-blue-700">Coordinador</span>';
                                        } elseif ($usuario->rol_id == 3) {
                                            $nombre = $usuario->alumno->nombre_completo ?? 'Estudiante';
                                            $avatarBg = $usuario->activo ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-400';
                                            $avatarText = 'AL';
                                            $rolPill = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-purple-50 text-purple-700">Alumno</span>';
                                        } elseif ($usuario->rol_id == 4) {
                                            $nombre = $usuario->empresa->nombre_empresa ?? 'Empresa';
                                            $avatarBg = $usuario->activo ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-400';
                                            $avatarText = 'EM';
                                            $rolPill = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-yellow-50 text-yellow-700">Empresa</span>';
                                        }
                                        
                                        // Generate initials
                                        if ($nombre) {
                                            $words = explode(' ', trim($nombre));
                                            $avatarText = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                        }
                                    @endphp
                                    <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full {{ $avatarBg }} flex items-center justify-center font-bold">
                                                    {{ $avatarText }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $nombre }}</div>
                                                    <div class="text-sm text-gray-500">{{ $usuario->correo }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {!! $rolPill !!}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($usuario->activo)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-50 text-green-700">Activo</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-gray-100 text-gray-400">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.usuarios') }}" class="text-gray-400 hover:text-[#4E7D24] transition-colors">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                            No hay usuarios registrados recientemente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
