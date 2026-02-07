<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Shield\RoleResource as ShieldRoleResource;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Settings\MailSettings;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\DateTimePicker;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'fluentui-person-28';
    protected static ?string $navigationGroup = 'Access';
    protected static ?string $recordTitleAttribute = 'fullname';
    protected static ?string $navigationLabel = 'Users';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('User Info')
                            ->schema([
                                Forms\Components\TextInput::make('firstname')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('lastname')
                                    ->label('Last Name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('username')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(User::class, 'username', ignoreRecord: true),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(User::class, 'email', ignoreRecord: true),
                                Forms\Components\TextInput::make('telp')
                                    ->label('Phone')
                                    ->tel()
                                    ->maxLength(30),
                                Forms\Components\TextInput::make('kode_unit')
                                    ->label('Unit Code')
                                    ->maxLength(50),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Security')
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->label('Password'),
                                Forms\Components\TextInput::make('password_confirmation')
                                    ->password()
                                    ->revealable()
                                    ->dehydrated(false)
                                    ->same('password')
                                    ->label('Confirm Password')
                                    ->required(fn(string $operation): bool => $operation === 'create'),
                                DateTimePicker::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->seconds(false)
                                    ->nullable(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Roles')
                            ->schema([
                                Forms\Components\Select::make('roles')
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(fn(Role $record): string => ShieldRoleResource::getRoleLabel($record->name)),
                            ]),
                        Forms\Components\Section::make('Avatar')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('avatar')
                                    ->collection('avatars')
                                    ->image()
                                    ->maxSize(1024)
                                    ->imagePreviewHeight('200')
                                    ->panelLayout('compact')
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('400')
                                    ->imageResizeTargetHeight('400')
                                    ->helperText('Recommended size: 400x400px'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('fullname')
                            ->label('Name')
                            ->searchable()
                            ->sortable(),
                        Tables\Columns\TextColumn::make('email')
                            ->searchable()
                            ->sortable(),
                        Tables\Columns\TextColumn::make('username')
                            ->toggleable(isToggledHiddenByDefault: true),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('roles.name')
                            ->label('Roles')
                            ->badge()
                            ->formatStateUsing(function ($state): string {
                                if (is_array($state)) {
                                    return collect($state)
                                        ->map(fn(string $role): string => ShieldRoleResource::getRoleLabel($role))
                                        ->join(', ');
                                }

                                return ShieldRoleResource::getRoleLabel((string) $state);
                            }),
                        Tables\Columns\IconColumn::make('email_verified_at')
                            ->label('Verified')
                            ->boolean()
                            ->alignCenter(),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('created_at')
                            ->label('Created')
                            ->dateTime()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                        Tables\Columns\TextColumn::make('updated_at')
                            ->label('Updated')
                            ->since()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                    ]),
                ]),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('role')
                    ->label('Role')
                    ->options(Role::query()->pluck('name', 'name')->map(fn(string $role) => ShieldRoleResource::getRoleLabel($role))->toArray())
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['value'], function (Builder $query, string $role): Builder {
                            return $query->whereHas('roles', fn(Builder $innerQuery) => $innerQuery->where('name', $role));
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markVerified')
                    ->label('Mark as Verified')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(User $record): bool => empty($record->email_verified_at))
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->update([
                            'email_verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Email marked as verified')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('verifyEmail')
                    ->label('Send Verify Email')
                    ->icon('heroicon-o-envelope')
                    ->visible(fn(User $record): bool => empty($record->email_verified_at))
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $settings = app(MailSettings::class);

                        if (! method_exists($record, 'notify')) {
                            $userClass = $record::class;
                            throw new \Exception("Model [{$userClass}] does not have a [notify()] method.");
                        }

                        if ($settings->isMailSettingsConfigured()) {
                            $notification = new VerifyEmail();
                            $notification->url = Filament::getVerifyEmailUrl($record);

                            $settings->loadMailSettingsToConfig();

                            $record->notify($notification);

                            Notification::make()
                                ->title(__('resource.user.notifications.verify_sent.title'))
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title(__('resource.user.notifications.verify_warning.title'))
                                ->body(__('resource.user.notifications.verify_warning.description'))
                                ->warning()
                                ->send();
                        }
                    }),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && ! $user->isSuperAdmin()) {
            $query->whereDoesntHave('roles', function (Builder $innerQuery) {
                $innerQuery->where('name', config('filament-shield.super_admin.name'));
            });
        }

        return $query;
    }
}
