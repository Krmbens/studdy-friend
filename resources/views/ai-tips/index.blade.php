<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <h2 class="text-3xl font-black text-white tracking-tight uppercase tracking-widest">
                {{ __('AI Study Tips') }}
            </h2>
            <p class="text-gray-600 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Advanced AI Study Optimization</p>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-0">
        <div class="max-w-[1520px] mx-auto">
            <livewire:ai-tip-generator />
        </div>
    </div>
</x-app-layout>
