<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-4 bg-gradient-to-br from-[#8b5cf6] to-[#6366f1] border border-transparent rounded-2xl font-black text-[10px] text-white uppercase tracking-[0.2em] hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-purple-500/20 active:scale-95 shadow-lg shadow-purple-500/20 transition-all duration-300']) }}>
    {{ $slot }}
</button>
