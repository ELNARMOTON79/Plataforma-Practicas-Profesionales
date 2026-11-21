@extends('layouts.empresa', ['title' => 'Alumnos que ya laboran - Prácticas Profesionales UdeC', 'active' => 'solicitudes'])

@section('content')
    <!-- Header -->
    <x-page-header title="Alumnos que ya laboran" description="Define las fechas y el horario de los alumnos que ya trabajan en tu empresa. La aprobación de solicitudes la hace el coordinador."></x-page-header>

    {{-- Alumnos que ya trabajan en la empresa: la empresa define sus fechas y horario.
         Estilos en línea para no depender de clases de Tailwind no compiladas. --}}
    <div class="glass-card rounded-3xl fade-in-up" style="padding: 1.5rem;">
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.5rem; margin-bottom: 0.25rem;">
            <h3 class="text-lg font-bold text-gray-900">Alumnos que ya laboran en tu empresa</h3>
            <span style="font-size: 12px; font-weight: 600; color: #6b7280; background: #f9fafb; border: 1px solid #f3f4f6; border-radius: 8px; padding: 2px 10px;">{{ $alumnosLaborando->count() }} alumno(s)</span>
        </div>
        <p style="font-size: 13px; color: #6b7280; margin-bottom: 1rem;">Registra las fechas de inicio y fin y las horas por día que vienen en el documento del proyecto de cada alumno.</p>

        @if(session('success'))
            <div style="margin-bottom: 1rem; padding: 0.6rem 0.9rem; border-radius: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; font-size: 13px; font-weight: 600;">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div style="margin-bottom: 1rem; padding: 0.6rem 0.9rem; border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-size: 13px; font-weight: 600;">{{ $errors->first() }}</div>
        @endif

        @forelse($alumnosLaborando as $sol)
            @php
                $proyectoAlumno = $proyectosAlumnos->get($sol->estudiante_id);
                $definido = $sol->fecha_inicio && $sol->fecha_fin;
                $esErrorDeEsta = $errors->any() && (int) old('solicitud_id') === $sol->id;
            @endphp
            <div style="border: 1px solid #f3f4f6; background: rgba(255,255,255,0.7); border-radius: 16px; padding: 1rem; margin-top: 0.75rem;">
                <div style="display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 0.75rem;">
                    <div>
                        <p style="font-size: 14px; font-weight: 700; color: #111827;">{{ $sol->estudiante?->nombre_completo ?? 'Alumno' }}</p>
                        <p style="font-size: 12px; color: #6b7280;">{{ $sol->estudiante?->matricula }} · {{ $sol->estudiante?->carrera }}{{ $sol->unidadReceptora?->unidad_receptora ? ' · ' . $sol->unidadReceptora->unidad_receptora : '' }}</p>
                        @if($definido)
                            <span style="display: inline-block; margin-top: 6px; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px; background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">
                                {{ $sol->fecha_inicio->format('d/m/Y') }} — {{ $sol->fecha_fin->format('d/m/Y') }} · {{ $sol->horas_por_dia }} h/día
                            </span>
                        @else
                            <span style="display: inline-block; margin-top: 6px; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">Fechas y horario por definir</span>
                        @endif
                    </div>
                    @if($proyectoAlumno?->documento_ruta)
                        <a href="{{ asset('storage/' . $proyectoAlumno->documento_ruta) }}" target="_blank" hx-boost="false" style="font-size: 12px; font-weight: 700; color: #4E7D24; border: 1px solid #e5e7eb; background: #fff; border-radius: 12px; padding: 0.5rem 0.9rem;">Ver documento del proyecto</a>
                    @else
                        <span style="font-size: 12px; color: #9ca3af;">El alumno aún no sube el documento del proyecto</span>
                    @endif
                </div>

                <form method="POST" action="{{ route('empresa.solicitudes.periodo', $sol->id) }}" hx-boost="false" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 0.75rem; align-items: end; margin-top: 0.9rem;">
                    @csrf
                    <input type="hidden" name="solicitud_id" value="{{ $sol->id }}">
                    <label style="font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase;">Fecha de inicio
                        <input type="date" name="fecha_inicio" required value="{{ $esErrorDeEsta ? old('fecha_inicio') : $sol->fecha_inicio?->format('Y-m-d') }}" style="display: block; width: 100%; margin-top: 4px; padding: 0.55rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 10px; background: #f9fafb; font-size: 13px; color: #1f2937;">
                    </label>
                    <label style="font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase;">Fecha de fin
                        <input type="date" name="fecha_fin" required value="{{ $esErrorDeEsta ? old('fecha_fin') : $sol->fecha_fin?->format('Y-m-d') }}" style="display: block; width: 100%; margin-top: 4px; padding: 0.55rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 10px; background: #f9fafb; font-size: 13px; color: #1f2937;">
                    </label>
                    <label style="font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase;">Horas por día
                        <input type="number" name="horas_por_dia" required min="1" max="12" value="{{ $esErrorDeEsta ? old('horas_por_dia') : ($definido ? $sol->horas_por_dia : '') }}" placeholder="Ej. 6" onwheel="this.blur()" style="display: block; width: 100%; margin-top: 4px; padding: 0.55rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 10px; background: #f9fafb; font-size: 13px; color: #1f2937;">
                    </label>
                    <button type="submit" style="padding: 0.6rem 1rem; border-radius: 12px; background: #4E7D24; color: #fff; font-size: 13px; font-weight: 700;">Guardar</button>
                </form>
            </div>
        @empty
            <p style="font-size: 13px; color: #9ca3af;">Por ahora ningún alumno ha indicado que ya trabaja en tu empresa.</p>
        @endforelse
    </div>
@endsection
