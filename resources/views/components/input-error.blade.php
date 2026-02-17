@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[10px] uppercase tracking-widest font-bold text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
