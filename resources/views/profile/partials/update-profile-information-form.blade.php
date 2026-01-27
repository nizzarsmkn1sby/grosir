<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-8">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Name Field -->
        <div>
            <label for="name" class="terminal-label">Full Entity Name</label>
            <input id="name" name="name" type="text" class="terminal-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="terminal-label">Business Email Address</label>
            <input id="email" name="email" type="email" class="terminal-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-orange-50 rounded-2xl border border-orange-100">
                    <p class="text-[11px] font-black text-orange-600 uppercase tracking-widest mb-2">Identification Required</p>
                    <p class="text-xs font-bold text-gray-500 mb-3">Your email address is currently unverified in our sourcing node.</p>
                    <button form="send-verification" class="text-[10px] font-black uppercase tracking-widest text-orange-500 hover:underline">
                        Re-send Verification Key
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                            <i class="fas fa-check-circle mr-1"></i> New Protocol Sent
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
        <button type="submit" class="btn-terminal-primary">
            <i class="fas fa-save mr-2"></i> Update Identity
        </button>

        @if (session('status') === 'profile-updated')
            <div class="protocol-status">
                <i class="fas fa-check-double"></i> Manifest Updated Successful
            </div>
        @endif
    </div>
</form>
