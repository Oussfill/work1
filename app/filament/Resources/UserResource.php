<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Table;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('بيانات المستخدم')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('الاسم')
                                ->required(),

                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->email()
                                ->required(),
                        ]),

                    TextInput::make('password')
                        ->label('كلمة المرور')
                        ->password()
                        ->required(fn(string $context) => $context === 'create')
                        ->dehydrated(fn($state) => filled($state))
                        ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                ])
                ->columns(1),

            Section::make()
                ->schema([
                    Toggle::make('is_admin')
                        ->label('مشرف؟')
                        ->inline(false)
                        ->helperText('تفعيل هذا الخيار يجعل المستخدم مشرفاً (بحد أقصى 4)')
                        ->afterStateUpdated(function ($state, $set) {
                            if ($state && \App\Models\User::where('is_admin', true)->count() >= 4) {
                                $set('is_admin', false);
                                Notification::make()
                                    ->title('لا يمكن تعيين أكثر من 4 مشرفين')
                                    ->danger()
                                    ->send();
                            }
                        }),
                ])
                ->columns(1)
                ->columnSpanFull()
                ->extraAttributes(['style' => 'margin-top: 30px']),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
          ->columns([
    Tables\Columns\TextColumn::make('name'),
    Tables\Columns\TextColumn::make('email'),
    Tables\Columns\IconColumn::make('is_admin')
        ->boolean()
        ->label('مشرف'),
])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
