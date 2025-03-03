<?php

namespace App\Providers;

use App\Models\Division;
use App\Models\SystemConten;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            // Fetch all menus with submenus where visibility is 1


            // Fetch all MainContent records once
            // Fetch all MainContent records
            $mainContent = SystemConten::get(['name', 'content', 'media', 'url'])->keyBy('name')->toArray();

            $global = [
                'website_name' => $mainContent['name']['content'] ?? 'Reliance International BD',
                'short_content' => $mainContent['short_content']['content'] ?? 'Reliance International BD',
                'facebook' => $mainContent['facebook']['content'] ?? '',
                'linkedin' => $mainContent['linkedin']['content'] ?? '',
                'youtube' => $mainContent['youtube']['content'] ?? '',
                'twitter' => $mainContent['twitter']['content'] ?? '',
                'email' => $mainContent['email']['content'] ?? '',
                'phone' => $mainContent['phone']['content'] ?? '',
                'address' => $mainContent['address']['content'] ?? '',
                'address_embaded' => $mainContent['address_embaded']['content'] ?? '',
            ];

            // Handle logo and favicon with media or URL fallback
            $global['logo'] = $mainContent['logo']['media'] ?? 'logo.png';

            $global['favicon'] = $mainContent['favicon']['media'] ?? 'favicon.ico';
            $view->with(compact('global'));
        });
    }
}
