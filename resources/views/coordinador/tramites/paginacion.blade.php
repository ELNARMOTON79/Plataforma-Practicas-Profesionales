{{-- Estado vacío y enlaces de paginación de una tabla de trámites. Espera $items (paginador o colección vacía). --}}
@if($items->isEmpty())
    <div class="py-12 px-4 text-center flex flex-col items-center justify-center">
        <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-3 shadow-inner border border-gray-200/50">
            @if($search !== '')
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            @else
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            @endif
        </div>
        @if($search !== '')
            <h3 class="text-sm font-bold text-gray-700">Sin coincidencias</h3>
            <p class="text-xs text-gray-400 mt-1">Intenta ajustando el término de búsqueda.</p>
        @else
            <h3 class="text-sm font-bold text-gray-700">Sin datos disponibles</h3>
            <p class="text-xs text-gray-400 mt-1 max-w-xs">No existen registros en esta categoría actualmente.</p>
        @endif
    </div>
@elseif($items instanceof \Illuminate\Contracts\Pagination\Paginator && $items->hasPages())
    <div class="mt-6">
        {{ $items->links() }}
    </div>
@endif
