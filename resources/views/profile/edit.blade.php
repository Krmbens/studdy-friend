<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-white tracking-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-0">
        <div class="max-w-[1520px] mx-auto space-y-10">
            <div class="p-10 bg-[#0a0f1e] border border-white/5 shadow-2xl rounded-[3rem] relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl opacity-50"></div>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-10 bg-[#0a0f1e] border border-white/5 shadow-2xl rounded-[3rem] relative overflow-hidden">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-10 bg-[#0a0f1e] border border-white/5 shadow-2xl rounded-[3rem] relative overflow-hidden">
                <div class="max-w-xl text-red-400">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
