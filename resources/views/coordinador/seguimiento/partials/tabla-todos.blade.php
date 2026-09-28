<!-- TAB 3: TODOS LOS ALUMNOS -->
<div id="content-todos" class="hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table id="tabla-todos" class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/50">
                <tr>
                    <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Matrícula</th>
                    <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proyecto / Institución</th>
                    <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Responsable del Proyecto</th>
                    <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acción</th>
                </tr>
            </thead>
            <tbody class="bg-transparent divide-y divide-gray-100">
                @foreach(collect($data) as $student)
                    @php
                        $wordsTodos = explode(' ', trim($student['nombre_completo']));
                        $initialsTodos = strtoupper(substr($wordsTodos[0] ?? 'A', 0, 1) . (isset($wordsTodos[1]) ? substr($wordsTodos[1], 0, 1) : ''));
                        $isProceso = $student['estatus'] == 'EN PROCESO';
                    @endphp
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group align-top">
                        <!-- Estudiante -->
                        <td class="px-4 py-4 whitespace-nowrap text-left">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full {{ $isProceso ? 'bg-yellow-100 text-yellow-750' : 'bg-green-100 text-green-750' }} flex items-center justify-center font-bold text-xs select-none flex-shrink-0">
                                    {{ $initialsTodos }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight">{{ $student['nombre_completo'] }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold mt-1">Matrícula: {{ $student['matricula'] }}</div>
                                </div>
                            </div>
                        </td>
                        <!-- Proyecto / Institución -->
                        <td class="px-4 py-4 text-left max-w-[220px] whitespace-normal">
                            <div class="text-xs text-gray-800 font-bold uppercase leading-tight break-words">{{ $student['titulo_proyecto'] }}</div>
                            <div class="text-[10px] text-gray-400 font-semibold mt-1 uppercase break-words">{{ $student['institucion'] }}</div>
                        </td>
                        <!-- Responsable -->
                        <td class="px-4 py-4 text-left max-w-[240px]">
                            <div class="text-xs font-bold text-gray-800 uppercase leading-snug">{{ $student['responsable'] }}</div>
                            <div class="text-[10px] text-gray-500 font-semibold mt-0.5 leading-tight">{{ $student['cargo'] }}</div>
                            <div class="text-[9px] text-[#4E7D24] font-bold mt-1.5 select-all break-all leading-tight">{{ $student['correo_destino'] }}</div>
                        </td>
                        <!-- Estado -->
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 text-[9px] leading-5 font-bold rounded-lg {{ $isProceso ? 'bg-yellow-50 text-yellow-750 border border-yellow-100' : 'bg-green-50 text-green-755 border border-green-100' }} uppercase tracking-wider">
                                {{ $student['estatus'] }}
                            </span>
                        </td>
                        <!-- Acción -->
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('coordinador.seguimiento.show', $student['id']) }}" class="inline-flex items-center justify-center px-5 py-2 bg-[#0085D1] hover:bg-[#0072B8] text-white rounded-full text-xs font-extrabold tracking-wider uppercase shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                Seguimiento
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
