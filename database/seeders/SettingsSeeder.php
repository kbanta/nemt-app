<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // database/seeders/SettingsSeeder.php
        Setting::insert([
            // General
            ['group' => 'general', 'key' => 'app_name',        'label' => 'App Name',         'type' => 'text',     'value' => config('app.name'),        'is_encrypted' => false, 'sort_order' => 1],
            ['group' => 'general', 'key' => 'app_url',         'label' => 'App URL',          'type' => 'text',     'value' => config('app.url'),         'is_encrypted' => false, 'sort_order' => 2],

            // Mail
            ['group' => 'mail', 'key' => 'mail_host',          'label' => 'Mail Host',        'type' => 'text',     'value' => config('mail.mailers.smtp.host'),    'is_encrypted' => false, 'sort_order' => 1],
            ['group' => 'mail', 'key' => 'mail_port',          'label' => 'Mail Port',        'type' => 'text',     'value' => config('mail.mailers.smtp.port'),    'is_encrypted' => false, 'sort_order' => 2],
            ['group' => 'mail', 'key' => 'mail_username',      'label' => 'Mail Username',    'type' => 'text',     'value' => config('mail.mailers.smtp.username'), 'is_encrypted' => false, 'sort_order' => 3],
            ['group' => 'mail', 'key' => 'mail_password',      'label' => 'Mail Password',    'type' => 'password', 'value' => null,                               'is_encrypted' => true, 'sort_order' => 4],
            ['group' => 'mail', 'key' => 'mail_encryption',    'label' => 'Mail Encryption',  'type' => 'text',     'value' => 'tls',                              'is_encrypted' => false, 'sort_order' => 5],
            ['group' => 'mail', 'key' => 'mail_from_address',  'label' => 'From Address',     'type' => 'text',     'value' => config('mail.from.address'),         'is_encrypted' => false, 'sort_order' => 6],
            ['group' => 'mail', 'key' => 'mail_from_name',     'label' => 'From Name',        'type' => 'text',     'value' => config('mail.from.name'),            'is_encrypted' => false, 'sort_order' => 7],

            // Stripe
            ['group' => 'stripe', 'key' => 'stripe_key',            'label' => 'Stripe Public Key',    'type' => 'text',     'value' => null, 'is_encrypted' => false, 'sort_order' => 1],
            ['group' => 'stripe', 'key' => 'stripe_secret',         'label' => 'Stripe Secret Key',    'type' => 'password', 'value' => null, 'is_encrypted' => true, 'sort_order' => 2],
            ['group' => 'stripe', 'key' => 'stripe_webhook_secret', 'label' => 'Stripe Webhook Secret', 'type' => 'password', 'value' => null, 'is_encrypted' => true, 'sort_order' => 3],

            // Maps
            ['group' => 'maps', 'key' => 'google_maps_key', 'label' => 'Google Maps API Key', 'type' => 'password', 'value' => null, 'is_encrypted' => true, 'sort_order' => 1],
        ]);
    }
}
