<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-white tracking-tight">
            {{ __('Study Sessions') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-0">
        <div class="max-w-[1520px] mx-auto">
            <livewire:study-session-tracker />
        </div>
    </div>
</x-app-layout>
