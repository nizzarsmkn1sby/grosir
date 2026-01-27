<form method="post" action="{{ route('password.update') }}" class="space-y-8">
    @csrf
    @method('put')

    <div class="space-y-8">
        <!-- Current Password -->
        <div>
            <label for="current_password" class="terminal-label">Active Authorization Key</label>
            <input id="current_password" name="current_password" type="password" class="terminal-input" autocomplete="current-password" placeholder="••••••••" />
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- New Password -->
            <div>
                <label for="password" class="terminal-label">New Sourcing Protocol Key</label>
                <input id="password" name="password" type="password" class="terminal-input" autocomplete="new-password" placeholder="Min. 8 characters" />
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="terminal-label">Confirm New Protocol</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="terminal-input" autocomplete="new-password" placeholder="Repeat new key" />
                <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>
        </div>
    </div>

    <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
        <button type="submit" class="btn-terminal-secondary">
            <i class="fas fa-key mr-2"></i> Rotate Security Keys
        </button>

        @if (session('status') === 'password-updated')
            <div class="protocol-status">
                <i class="fas fa-lock mr-2"></i> Encryption Updated
            </div>
        @endif
    </div>
</form>
