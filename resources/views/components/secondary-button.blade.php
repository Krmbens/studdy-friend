<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-8 py-4 bg-white/5 border border-white/5 rounded-2xl font-black text-[10px] text-gray-400 uppercase tracking-[0.2em] shadow-sm hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/10 disabled:opacity-25 transition-all duration-300 active:scale-95']) }}>
    {{ $slot }}
</button>
