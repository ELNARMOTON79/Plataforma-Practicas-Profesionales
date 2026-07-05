{{--
    Alert Flash Component
    Props (optional):
      $successClass  – extra CSS classes for success alert
      $errorClass    – extra CSS classes for error alert
    Usage:
      <x-estudiante.alert-flash />
--}}
@if(session('success'))
    <div {{ $attributes->merge(['class' => 'rounded-2xl bg-green-50 border border-green-100 p-4 text-sm text-green-800 fade-in-up']) }}>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div {{ $attributes->merge(['class' => 'rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-red-800 fade-in-up']) }}>
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
