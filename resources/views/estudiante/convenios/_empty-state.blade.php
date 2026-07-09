        <!-- Empty state -->
        <div class="glass-card rounded-3xl p-14 text-center fade-in-up delay-200">
            <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-gray-500">No se encontraron empresas</h3>
            <p class="text-sm text-gray-400 mt-1">
                {{ $search ? 'Ninguna empresa coincide con "' . $search . '".' : 'Aún no hay unidades receptoras registradas.' }}
            </p>
            @if($search)
                <a href="{{ route('estudiante.convenios') }}" class="mt-4 inline-block text-sm font-semibold text-[#4E7D24] hover:underline">Ver todas las empresas</a>
            @endif
        </div>
