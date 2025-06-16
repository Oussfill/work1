<?php

namespace App\Filament\user\Pages;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
protected static string $view = 'filament.pages.user-dashboard';
    protected static ?string $slug = 'user-dashboard';

    public static function getNavigationLabel(): string
        {
            return 'آخر المستجدات';
        }

        public function getTitle(): string
        {
            return 'آخر المستجدات';
        }
        public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->is_admin == FALSE;
    }

}
