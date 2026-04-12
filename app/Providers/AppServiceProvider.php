<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
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
        // Filament / Livewire: signed routes используют UrlGenerator (forceRootUrl).
        // Превью файлов на disk «public» идёт через Storage::url() — там берётся
        // filesystems.disks.public.url из конфига (= APP_URL/storage), без синхронизации
        // с фактическим хостом в браузере превью висит на «Waiting for size».
        if (! $this->app->runningInConsole()) {
            $request = request();
            if ($request && $request->getHost() !== '') {
                $root = $request->getSchemeAndHttpHost();
                URL::forceRootUrl($root);
                config([
                    'app.url' => $root,
                    'filesystems.disks.public.url' => $root.'/storage',
                ]);
            }
        }

        RateLimiter::for('leads', function (Request $request) {
            return Limit::perMinute(8)->by($request->ip());
        });

        RateLimiter::for('quiz', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });
    }
}
