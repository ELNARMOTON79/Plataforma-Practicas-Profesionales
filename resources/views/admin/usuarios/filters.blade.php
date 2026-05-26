<!-- Filters & Search -->
<form method="GET" action="{{ route('admin.usuarios') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between mb-6 w-full">
    <!-- Left side: Show entries -->
    <div class="flex items-center gap-2 text-sm text-gray-600 font-medium w-full md:w-auto">
        <span>Mostrar</span>
        <select name="per_page" onchange="this.form.submit()" class="pl-3 pr-8 py-1.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
            <option value="5" {{ request('per_page', '5') == '5' ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
        </select>
        <span>registros</span>
    </div>

    <!-- Right side: Filters & Search -->
    <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
        <select name="rol" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
            <option value="">Todos los Roles</option>
            <option value="2" {{ request('rol') == '2' ? 'selected' : '' }}>Coordinador</option>
            <option value="3" {{ request('rol') == '3' ? 'selected' : '' }}>Alumno</option>
            <option value="4" {{ request('rol') == '4' ? 'selected' : '' }}>Empresa</option>
        </select>
        <select name="estado" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
            <option value="">Estado</option>
            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
        <div class="relative w-full sm:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors restrict-search" placeholder="Buscar..." pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]+$" title="El buscador solo acepta letras, números, espacios, @ y puntos." onkeypress="return (event.ctrlKey || event.metaKey || event.altKey) || /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]$/.test(event.key) || ['Backspace', 'Enter', 'Tab', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key)" oninput="this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/g, '')">
        </div>
        <button type="submit" class="hidden">Buscar</button>
    </div>
</form>
