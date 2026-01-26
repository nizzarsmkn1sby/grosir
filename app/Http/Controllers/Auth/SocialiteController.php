<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect to the provider
     *
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle provider callback
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            $driver = Socialite::driver($provider);

            // Bypass SSL verification for local development (Fix cURL error 60)
            if (config('app.env') === 'local') {
                $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }

            $user = $driver->user();

            $findUser = User::where('social_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect('/');
            } else {
                // If user with same email exists, link them
                $existingUser = User::where('email', $user->email)->first();

                if ($existingUser) {
                    $existingUser->update([
                        'social_id' => $user->id,
                        'social_type' => $provider,
                        'avatar' => $user->avatar,
                    ]);
                    Auth::login($existingUser);
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'social_id' => $user->id,
                        'social_type' => $provider,
                        'avatar' => $user->avatar,
                        'password' => Hash::make(Str::random(24)),
                        'role' => 'user',
                    ]);
                    Auth::login($newUser);
                }

                return redirect('/');
            }

        } catch (Exception $e) {
            \Log::error('Socialite Login Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Login gagal menggunakan ' . ucfirst($provider) . '. Error: ' . $e->getMessage());
        }
    }
}
