<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            Setting::all()->each(function ($setting) {
                $value = $setting->getDecodedValue();
                if ($value === null) return;

                // Map setting keys to config values
                match ($setting->key) {
                    // General
                    'app_name'          => Config::set('app.name', $value),
                    'app_url'           => Config::set('app.url', $value),

                    // Mail
                    'mail_host'         => Config::set('mail.mailers.smtp.host', $value),
                    'mail_port'         => Config::set('mail.mailers.smtp.port', $value),
                    'mail_username'     => Config::set('mail.mailers.smtp.username', $value),
                    'mail_password'     => Config::set('mail.mailers.smtp.password', $value),
                    'mail_encryption'   => Config::set('mail.mailers.smtp.encryption', $value),
                    'mail_from_address' => Config::set('mail.from.address', $value),
                    'mail_from_name'    => Config::set('mail.from.name', $value),

                    // Stripe
                    'stripe_key'        => Config::set('services.stripe.key', $value),
                    'stripe_secret'     => Config::set('services.stripe.secret', $value),
                    'stripe_webhook_secret' => Config::set('services.stripe.webhook_secret', $value),

                    // Maps
                    'google_maps_key'   => Config::set('services.google.maps_key', $value),

                    //openrouteservice
                    'ors_key' => Config::set('services.ors.key', $value),
                    default             => null,
                };
            });
        } catch (\Exception $e) {
            // Silently fail if DB isn't ready yet (e.g. during migrations)
        }
    }
}
