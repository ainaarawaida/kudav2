<?php

namespace App\Providers;

use Filament\Pages\Dashboard;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            function(){
                return "<script>
             
                document.addEventListener('alpine:init', function() {
                    // console.log(window.Alpine.store('sidebar').close());
                    window.Alpine.store('sidebar').close();
                 
                   
                  });
                  </script>";
             
            },
            scopes: [
                Dashboard::class,
            ]
        );

        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::GLOBAL_SEARCH_AFTER,
        //     function(): string {
        //         $urlParts = explode('/', url()->current());
        //         if(count($urlParts) >= 5 && $urlParts[3] == 'web') {
        //             return '<a wire:navigate href="'.url('/client/login?company='.$urlParts[4]).'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
               
        //             <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
        //                 Login
        //             </span></a>' ;
        //         }
        //         return '<a wire:navigate href="'.url('/app/login').'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
               
        //             <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
        //                 Login
        //             </span></a>' ;
        //     },
          
        // );

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn () => view('customFooter'),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
