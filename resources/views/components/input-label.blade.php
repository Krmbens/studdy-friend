<label {{ $attributes->merge(['class' => 'block font-black text-[10px] text-gray-500 uppercase tracking-[0.2em]']) }}>
    {{ $value ?? $slot }}
</label>
