@props(['title', 'description' => null])

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up relative z-30">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $title }}</h1>
        @if($description)
            <p class="text-gray-600 font-medium">{{ $description }}</p>
        @endif
    </div>
    @if(isset($actions))
        <div class="flex items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
