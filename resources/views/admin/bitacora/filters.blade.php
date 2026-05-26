<!-- Advanced Search, Module and Level Filters -->
<form method="GET" action="{{ route('admin.bitacora') }}" class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between mb-6 pb-6 border-b border-gray-100 w-full">
    <input type="hidden" name="view" id="filter-view" value="{{ request('view', 'table') }}">
    
    <!-- Search & Dropdowns -->
    <div class="flex flex-col md:flex-row gap-3 flex-1">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" id="log-search" value="{{ request('search') }}" class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] text-sm transition-colors" placeholder="Buscar por usuario, IP, descripción, acción...">
        </div>

        <div class="flex flex-wrap md:flex-nowrap gap-3">
            <!-- Level Filter -->
            <select name="level" id="filter-level" onchange="this.form.submit()" class="block w-full md:w-44 pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                <option value="">Severidad: Todo</option>
                <option value="success" {{ request('level') == 'success' ? 'selected' : '' }}>Éxito</option>
                <option value="info" {{ request('level') == 'info' ? 'selected' : '' }}>Info</option>
                <option value="warning" {{ request('level') == 'warning' ? 'selected' : '' }}>Advertencia</option>
                <option value="danger" {{ request('level') == 'danger' ? 'selected' : '' }}>Error</option>
            </select>

            <!-- Module Filter -->
            <select name="module" id="filter-module" onchange="this.form.submit()" class="block w-full md:w-44 pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                <option value="">Módulo: Todo</option>
                <option value="Autenticación" {{ request('module') == 'Autenticación' ? 'selected' : '' }}>Autenticación</option>
                <option value="Usuarios" {{ request('module') == 'Usuarios' ? 'selected' : '' }}>Usuarios</option>
                <option value="Documentos" {{ request('module') == 'Documentos' ? 'selected' : '' }}>Documentos</option>
                <option value="Proyectos" {{ request('module') == 'Proyectos' ? 'selected' : '' }}>Proyectos</option>
                <option value="Empresas" {{ request('module') == 'Empresas' ? 'selected' : '' }}>Empresas</option>
                <option value="Sistema" {{ request('module') == 'Sistema' ? 'selected' : '' }}>Sistema</option>
            </select>

            <!-- Quick Date Filter -->
            <select name="date" id="filter-date" onchange="this.form.submit()" class="block w-full md:w-44 pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                <option value="">Fecha: Todo</option>
                <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Hoy</option>
                <option value="yesterday" {{ request('date') == 'yesterday' ? 'selected' : '' }}>Ayer</option>
                <option value="older" {{ request('date') == 'older' ? 'selected' : '' }}>Más de 2 días</option>
            </select>
        </div>
    </div>

    <!-- View Toggles (Table vs Timeline) -->
    <div class="flex items-center gap-1.5 bg-gray-100/80 p-1 rounded-2xl self-start lg:self-center">
        <button type="button" id="tab-table" onclick="toggleView('table')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 @if(request('view', 'table') != 'timeline') shadow bg-white text-[#4E7D24] @else text-gray-500 hover:text-gray-900 @endif">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Tabla
        </button>
        <button type="button" id="tab-timeline" onclick="toggleView('timeline')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 @if(request('view', 'table') == 'timeline') shadow bg-white text-[#4E7D24] @else text-gray-500 hover:text-gray-900 @endif">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Línea de Tiempo
        </button>
    </div>
</form>
