@extends('layouts.public')

@section('title', 'Profile Terminal - GrosirKu')

@push('styles')
<style>
    /* Premium Profile Terminal Styles */
    .profile-terminal-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 10rem;
    }

    .profile-header-terminal {
        background: #0f172a; /* Dark background */
        padding: 4rem 0;
        margin-bottom: 5rem;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .profile-header-terminal::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 80, 0, 0.3), transparent);
    }

    .terminal-section-card {
        background: white;
        border-radius: 40px;
        padding: 4rem;
        border: 1px solid #f1f5f9;
        box-shadow: var(--shadow-premium);
        margin-bottom: 3rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .section-title-terminal {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .section-badge-terminal {
        width: 40px;
        height: 40px;
        background: var(--alibaba-orange);
        color: white;
        border-radius: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.875rem;
        box-shadow: 0 10px 20px rgba(255, 80, 0, 0.2);
    }

    .section-name-terminal {
        font-size: 1.5rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.03em;
    }

    .terminal-label {
        font-size: 10px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-bottom: 1rem;
        display: block;
    }

    .terminal-input {
        width: 100%;
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 20px;
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: #0f172a;
        transition: all 0.3s;
    }

    .terminal-input:focus {
        border-color: var(--alibaba-orange);
        background: white;
        outline: none;
        box-shadow: 0 0 0 5px rgba(255, 80, 0, 0.05);
    }

    .btn-terminal-save {
        background: var(--alibaba-orange);
        color: white;
        padding: 1.25rem 2.5rem;
        border-radius: 100px;
        font-weight: 900;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: none;
        cursor: pointer;
        transition: all 0.4s;
        box-shadow: 0 20px 40px rgba(255, 80, 0, 0.25);
    }

    .btn-terminal-save:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px rgba(255, 80, 0, 0.35);
    }

    .btn-terminal-danger {
        background: #ef4444;
        color: white;
        padding: 1.25rem 2.5rem;
        border-radius: 100px;
        font-weight: 900;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: none;
        cursor: pointer;
        transition: all 0.4s;
    }

    .btn-terminal-danger:hover {
        background: #dc2626;
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(239, 68, 68, 0.25);
    }

    .terminal-help-text {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 1rem;
    }

    .protocol-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #f0fdf4;
        color: #16a34a;
        padding: 0.5rem 1rem;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>
@endpush

@section('content')
<div class="profile-terminal-wrapper">
    <!-- Header -->
    <div class="profile-header-terminal mb-16">
        <div class="container mx-auto px-8">
            <div class="text-[10px] font-black text-orange-500 uppercase tracking-[0.3em] mb-4">Account Metadata Hub</div>
            <h1 class="text-4xl font-black text-white tracking-tight">Profile & Authorization Management</h1>
        </div>
    </div>

    <div class="container mx-auto px-8 max-w-5xl">
        <!-- Profile Information -->
        <div class="terminal-section-card">
            <div class="section-title-terminal">
                <div class="section-badge-terminal"><i class="fas fa-user"></i></div>
                <div>
                    <h2 class="section-name-terminal">Sourcing Identity</h2>
                    <p class="terminal-help-text">Update your account's manifest identification and communication channels.</p>
                </div>
            </div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Password Update -->
        <div class="terminal-section-card">
            <div class="section-title-terminal">
                <div class="section-badge-terminal bg-blue-600 shadow-blue-500/20"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <h2 class="section-name-terminal">Authorization Protocol</h2>
                    <p class="terminal-help-text">Synchronize your security keys to maintain secure terminal access.</p>
                </div>
            </div>
            @include('profile.partials.update-password-form')
        </div>

        <!-- Danger Zone: Delete Account -->
        <div class="terminal-section-card border-red-50">
            <div class="section-title-terminal">
                <div class="section-badge-terminal bg-red-600 shadow-red-500/20"><i class="fas fa-exclamation-triangle"></i></div>
                <div>
                    <h2 class="section-name-terminal">Terminal Decommissioning</h2>
                    <p class="terminal-help-text">Irreversibly wipe all account resource metadata from the ecosystem.</p>
                </div>
            </div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
