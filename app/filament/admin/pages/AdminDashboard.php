<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static string $view = 'filament.pages.admin-dashboard';

    protected static ?string $navigationLabel = 'لوحة تحكم المشرف';
    protected static ?string $title = 'لوحة تحكم المشرف';
    protected static ?string $slug = 'admin-dashboard';

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->is_admin;
    }
}
