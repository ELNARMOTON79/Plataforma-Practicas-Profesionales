@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">

        {{-- Mobile View --}}
        <div class="flex gap-2 items-center justify-between sm:hidden w-full">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold text-gray-400 bg-gray-50/50 border border-gray-200 cursor-not-allowed rounded-xl">
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-white/50 border border-gray-200 rounded-xl hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] hover:border-[#6BA53A]/20 transition-all">
                    Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-white/50 border border-gray-200 rounded-xl hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] hover:border-[#6BA53A]/20 transition-all">
                    Siguiente
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold text-gray-400 bg-gray-50/50 border border-gray-200 cursor-not-allowed rounded-xl">
                    Siguiente
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between sm:gap-4 w-full">
            <div>
                <p class="text-sm text-gray-600 font-medium">
                    Mostrando
                    @if ($paginator->firstItem())
                        <span class="font-bold text-gray-800">{{ $paginator->firstItem() }}</span>
                        a
                        <span class="font-bold text-gray-800">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    de
                    <span class="font-bold text-gray-800">{{ $paginator->total() }}</span>
                    registros
                </p>
            </div>

            <div>
                <span class="inline-flex flex-row gap-1.5">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center p-2 text-sm font-medium text-gray-300 bg-gray-50/50 border border-gray-200 cursor-not-allowed rounded-xl" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center p-2 text-sm font-medium text-gray-700 bg-white/50 border border-gray-200 rounded-xl hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] hover:border-[#6BA53A]/20 transition-all" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-3.5 py-2 text-sm font-semibold text-gray-400 bg-gray-50/50 border border-gray-200 cursor-default rounded-xl">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-3.5 py-2 text-sm font-bold text-white bg-[#4E7D24] border border-[#4E7D24] rounded-xl shadow-sm cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-3.5 py-2 text-sm font-semibold text-gray-700 bg-white/50 border border-gray-200 rounded-xl hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] hover:border-[#6BA53A]/20 transition-all" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center p-2 text-sm font-medium text-gray-700 bg-white/50 border border-gray-200 rounded-xl hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] hover:border-[#6BA53A]/20 transition-all" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center p-2 text-sm font-medium text-gray-300 bg-gray-50/50 border border-gray-200 cursor-not-allowed rounded-xl" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
