@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-black/40 border-white/5 focus:border-purple-500/40 focus:ring-purple-500/20 rounded-2xl shadow-sm text-white font-bold text-sm p-4 transition-all placeholder-gray-700']) }}>
