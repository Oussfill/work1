<?php

namespace App\Http\Responses;


use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Filament::auth()->user();
        if($user->is_admin){
$redirectUrl = '/admin' ;
        }else{
          $redirectUrl = '/admin/user-dashboard' ;

        }

      

        // 🔴 هنا نبني RedirectResponse بشكل يدوي مضمون
        
        return redirect()->intended($redirectUrl);
    }
}
