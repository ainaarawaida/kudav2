<?php

namespace App\Filament\Auth;

use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Actions\ActionGroup;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use App\Http\Responses\Auth\LoginResponse;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Models\Contracts\FilamentUser;

use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Login extends BaseAuth
{
    /**
     * Get the form for the resource.
     */



     public function mount(): void
     {
         if (Filament::auth()->check()) {
             redirect()->intended(Filament::getUrl());
         }
 
         $this->form->fill([
             'email' => 'admin@admin.com',
             'password' => 'admin',
         ]);
     }
     
     public function form(Form $form): Form
     {
         return $form;
     }

    /**
     * Authenticate the user.
     */



    public function hasLogo(): bool
    {
        return true;
    }

    
    protected function getFormActions(): array
    {
        return [
           
            Action::make('Back')
            ->url('/')
            // ->url(url()->previous())
            ->extraAttributes(['style' => 'width:30%;','class' => 'bg-gray-400']),    
            $this->getAuthenticateFormAction()
            ->extraAttributes(['style' => 'width:60%;']),   
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }
}
