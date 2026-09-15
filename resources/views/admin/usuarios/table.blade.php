<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50/50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Usuario</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rol</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-transparent divide-y divide-gray-100">
            @forelse($usuarios as $usuario)
                @php
                    $nombre = '';
                    $subtexto = '';
                    $avatarBg = 'bg-gray-100 text-gray-600';
                    $avatarText = 'US';
                    $rolPill = '';
                    
                    if ($usuario->rol_id == 1) {
                        $nombre = $usuario->coordinador->nombre_completo ?? 'Administrador General';
                        $subtexto = 'Sistema';
                        $avatarBg = 'bg-gray-100 text-gray-600';
                        $avatarText = 'AD';
                        $rolPill = '<span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-gray-100 text-gray-800 border border-gray-200">Administrador</span>';
                    } elseif ($usuario->rol_id == 2) {
                        $nombre = $usuario->coordinador->nombre_completo ?? 'Usuario Coordinador';
                        $subtexto = 'ID: ' . ($usuario->coordinador->id ?? 'Personal');
                        $avatarBg = $usuario->activo ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400';
                        $avatarText = 'CO';
                        $rolPill = $usuario->activo 
                            ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">Coordinador</span>'
                            : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-gray-100 text-gray-400 border border-gray-200">Coordinador</span>';
                    } elseif ($usuario->rol_id == 3) {
                        $nombre = $usuario->alumno->nombre_completo ?? 'Estudiante';
                        $subtexto = 'Matrícula: ' . ($usuario->alumno->matricula ?? 'N/A');
                        $avatarBg = $usuario->activo ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-400';
                        $avatarText = 'AL';
                        $rolPill = $usuario->activo
                            ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-100">Alumno</span>'
                            : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-gray-100 text-gray-400 border border-gray-200">Alumno</span>';
                    } elseif ($usuario->rol_id == 4) {
                        $nombre = $usuario->empresa->nombre_empresa ?? 'Empresa';
                        $subtexto = 'Tipo: ' . ($usuario->empresa->tipo_persona ?? 'N/A');
                        $avatarBg = $usuario->activo ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-400';
                        $avatarText = 'EM';
                        $rolPill = $usuario->activo
                            ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-100">Empresa</span>'
                            : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-gray-100 text-gray-400 border border-gray-200">Empresa</span>';
                    }
                    
                    // Generate initials
                    if ($nombre) {
                        $words = explode(' ', trim($nombre));
                        $avatarText = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                    }
                @endphp
                <tr class="transition-colors group {{ !$usuario->activo ? 'bg-gray-50/50 opacity-60 text-gray-400' : 'hover:bg-[#6BA53A]/5' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 md:h-12 md:w-12 rounded-full {{ $avatarBg }} flex items-center justify-center font-bold shadow-sm">
                                {{ $avatarText }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold {{ $usuario->activo ? 'text-gray-900 group-hover:text-[#4E7D24]' : 'text-gray-400' }} transition-colors">{{ $nombre }}</div>
                                <div class="text-xs {{ $usuario->activo ? 'text-gray-500' : 'text-gray-400' }}">{{ $usuario->correo }}</div>
                                <div class="text-xs {{ $usuario->activo ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $subtexto }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {!! $rolPill !!}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($usuario->activo)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> Activo
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-gray-100 text-gray-400 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5 mt-1.5"></span> Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            @if($usuario->activo)
                                <button class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition-all btn-edit-user" 
                                    title="Editar"
                                    data-id="{{ $usuario->id }}"
                                    data-correo="{{ $usuario->correo }}"
                                    data-rol-id="{{ $usuario->rol_id }}"
                                    data-nombre="{{ $nombre }}"
                                    @if($usuario->rol_id == 3)
                                        data-matricula="{{ $usuario->alumno->matricula ?? '' }}"
                                        data-carrera="{{ $usuario->alumno->carrera ?? '' }}"
                                        data-semestre="{{ $usuario->alumno->semestre ?? '' }}"
                                        data-grupo="{{ $usuario->alumno->grupo ?? '' }}"
                                    @elseif($usuario->rol_id == 4)
                                        data-direccion="{{ $usuario->empresa->direccion ?? '' }}"
                                        data-tipo-persona="{{ $usuario->empresa->tipo_persona ?? '' }}"
                                    @endif
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                            @endif
                            @if($usuario->rol_id != 1)
                                @if($usuario->activo)
                                    <button type="button" onclick="confirmDeactivate('{{ $usuario->id }}', '{{ addslashes($nombre) }}')" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-all" title="Deshabilitar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>
                                @else
                                    <button type="button" onclick="toggleUserStatus('{{ $usuario->id }}')" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 hover:text-green-700 rounded-lg transition-all" title="Habilitar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                        No se encontraron usuarios que coincidan con los criterios de búsqueda.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $usuarios->appends(request()->query())->links() }}
</div>
