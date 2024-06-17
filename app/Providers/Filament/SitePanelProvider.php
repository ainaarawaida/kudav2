<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class SitePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('site')
            ->path('/')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->sidebarCollapsibleOnDesktop(true)
            ->brandLogo(asset('assets/logo.jpg'))
            ->brandLogoHeight('4rem')
            ->favicon(asset('assets/logo.jpg'))
            ->topNavigation()
            ->spa()
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER ,
                function(): string {
                    if(auth()->check()) {

                        $stringhtml = '' ;
                        if(auth()->user()->hasRole('admin')){
                            $stringhtml .= '<a wire:navigate href="'.url('/admin/login').'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
                   
                        <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
                            Admin
                        </span></a>' ;
                        }

                        if(auth()->user()->hasRole('coach')){
                            $stringhtml .= '<a wire:navigate href="'.url('/coach/login').'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
                   
                        <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
                            Coach
                        </span></a>' ;
                        }

                        if(auth()->user()->hasRole('rider')){
                            $stringhtml .= '<a wire:navigate href="'.url('/rider/login').'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
                   
                        <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
                            Rider
                        </span></a>' ;
                        }


                        return $stringhtml;
                    }
                    return '<a wire:navigate href="'.url('/admin/login').'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
                   
                        <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
                            Admin
                        </span></a>
                        <a wire:navigate href="'.url('/coach/login').'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
                   
                        <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
                            Coach
                        </span></a>
                        <a wire:navigate href="'.url('/rider/login').'" class="fi-topbar-item-button flex items-center justify-center gap-x-2 rounded-lg px-3 py-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-50 dark:bg-white/5">
                   
                        <span class="fi-topbar-item-label text-sm font-medium text-primary-600 dark:text-primary-400">
                            Rider
                        </span></a>' ;
                }
            )
            ->discoverResources(in: app_path('Filament/Site/Resources'), for: 'App\\Filament\\Site\\Resources')
            ->discoverPages(in: app_path('Filament/Site/Pages'), for: 'App\\Filament\\Site\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Site/Widgets'), for: 'App\\Filament\\Site\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                // Authenticate::class,
            ])
            ->plugins([
                FilamentFullCalendarPlugin::make()
                    ->selectable(false)
                    ->editable(false)

            ]
                  
            );
    }
}
