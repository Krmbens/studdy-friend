<section class="space-y-6">
    <header class="mb-8">
        <h2 class="text-xl font-black text-red-500 tracking-tight flex items-center gap-3">
            <span class="w-1.5 h-6 bg-red-500 rounded-full"></span>
            {{ __('Supprimer le Compte') }}
        </h2>

        <p class="mt-2 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Supprimer le Compte') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-[#0a0f1e] border border-white/5 rounded-[2rem]">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-white tracking-tight mb-4">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="text-sm text-slate-400 mb-8">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.') }}
            </p>

            <div class="space-y-3">
                <x-input-label for="password" value="{{ __('Mot de passe') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Votre mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Supprimer le Compte') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
