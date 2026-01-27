<section class="space-y-6">
    <button
        class="btn-terminal-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <i class="fas fa-trash-alt mr-2"></i> Wipe Account Data
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white rounded-3xl">
            @csrf
            @method('delete')

            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                    Confirm Decommissioning?
                </h2>
            </div>

            <p class="text-sm font-bold text-gray-500 leading-relaxed mb-8">
                Once this protocol is executed, all of your sourcing records, manifest logs, and resource identification packets will be permanently wiped. This action is <span class="text-red-600">irreversible</span>.
            </p>

            <div class="space-y-4">
                <label for="password_deletion" class="terminal-label">Primary Authorization Key</label>
                <input
                    id="password_deletion"
                    name="password"
                    type="password"
                    class="terminal-input"
                    placeholder="Enter password to confirm"
                    required
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex gap-4">
                <button type="button" class="btn-terminal-outline flex-1" x-on:click="$dispatch('close')">
                    Abort Deletion
                </button>

                <button type="submit" class="btn-terminal-danger flex-1">
                    Execute Wipe
                </button>
            </div>
        </form>
    </x-modal>
</section>
