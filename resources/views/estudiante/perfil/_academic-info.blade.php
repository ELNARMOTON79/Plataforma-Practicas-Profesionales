    {{-- Academic info (read-only) --}}
    <div class="glass-card rounded-3xl p-8 fade-in-up delay-200">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">Datos Académicos</h2>
            <p class="text-sm text-gray-500 mt-0.5">Información registrada en el sistema. Contacta a tu coordinador para modificarla.</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2">
            <div class="bg-gray-50/60 border border-gray-100 rounded-2xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Matrícula</p>
                <p class="text-sm font-bold text-gray-800">{{ $matricula !== '—' ? $matricula : 'No registrada' }}</p>
            </div>
            <div class="bg-gray-50/60 border border-gray-100 rounded-2xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Carrera</p>
                <p class="text-sm font-bold text-gray-800">{{ $carrera !== '—' ? $carrera : 'No registrada' }}</p>
            </div>
        </div>
    </div>
