<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-4 bg-red-500/10 border border-red-500/20 rounded-2xl font-black text-[10px] text-red-500 uppercase tracking-[0.2em] hover:bg-red-500/20 focus:outline-none focus:ring-2 focus:ring-red-500/20 active:scale-95 transition-all duration-300']) }}>
    {{ $slot }}
</button>
