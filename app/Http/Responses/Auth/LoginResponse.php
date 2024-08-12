<?php

namespace App\Http\Responses\Auth;

use App\Models\Team;
use Filament\Facades\Filament;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportRedirects\Redirector;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse | Redirector
    {
    //    dd(Filament::getUrl());
    //    return redirect(Filament::getUrl()) ;
    
        if(in_array('admin', auth()->user()->roles->pluck('name')->toArray())){
            return redirect(url('/admin'));
        }else if(in_array('coach', auth()->user()->roles->pluck('name')->toArray())){
            return redirect(url('/coach'));
        }else if(in_array('rider', auth()->user()->roles->pluck('name')->toArray())){
            return redirect(url('/rider'));
        }else{
            return redirect()->intended(Filament::getUrl());
        }
      
    }
}