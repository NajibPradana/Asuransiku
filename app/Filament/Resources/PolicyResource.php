<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyResource\Pages;
use App\Models\Policy;
use App\Models\Product;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PolicyResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Policy::class;
    protected static ?string $navigationIcon = 'fluentui-document-checkmark-24-o';
    protected static ?string $navigationLabel = 'Polis';
    protected static ?string $pluralModelLabel = 'Polis';
    protected static ?string $label = 'Polis';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 20;
    protected static ?string $recordTitleAttribute = 'policy_number';

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
                Forms\Components\Section::make('Informasi Polis')
                    ->schema([
                        Forms\Components\TextInput::make('policy_number')
                            ->label('Nomor Polis')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('user_id')
                            ->label('Nasabah')
                            ->relationship('user', 'fullname')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Mulai')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Berakhir')
                            ->required()
                            ->afterOrEqual('start_date'),
                        Forms\Components\TextInput::make('premium_paid')
                            ->label('Premi Dibayar')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->prefix('Rp'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(self::getStatusOptions())
                            ->required(),
                        Forms\Components\Textarea::make('rejection_note')
                            ->label('Catatan Penolakan')
                            ->rows(4)
                            ->maxLength(1000)
                            ->visible(fn(Forms\Get $get): bool => $get('status') === 'cancelled')
                            ->helperText('Isi catatan jika polis ditolak.'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('policy_number')
                    ->label('No Polis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.fullname')
                    ->label('Nasabah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn(?string $state): string => $state ? ucfirst($state) : '-')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('premium_paid')
                    ->label('Premi')
                    ->alignRight()
                    ->sortable()
                    ->formatStateUsing(fn($state): string => number_format((float) $state, 2, '.', ',')),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'active' => 'success',
                        'expired' => 'gray',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('approvedBy.fullname')
                    ->label('Approve By')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label('Approve At')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Berakhir')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::getStatusOptions()),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Policy $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Policy $record): void {
                        $record->update([
                            'status' => 'active',
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                            'rejection_note' => null,
                        ]);

                        Notification::make()
                            ->title('Polis disetujui')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn(Policy $record): bool => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('rejection_note')
                            ->label('Catatan Penolakan')
                            ->rows(4)
                            ->required()
                            ->maxLength(1000),
                    ])
                    ->action(function (Policy $record, array $data): void {
                        $record->update([
                            'status' => 'cancelled',
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                            'rejection_note' => $data['rejection_note'],
                        ]);

                        Notification::make()
                            ->title('Polis ditolak')
                            ->danger()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Polis')
                    ->schema([
                        Infolists\Components\TextEntry::make('policy_number')
                            ->label('Nomor Polis'),
                        Infolists\Components\TextEntry::make('user.fullname')
                            ->label('Nasabah'),
                        Infolists\Components\TextEntry::make('product.name')
                            ->label('Produk'),
                        Infolists\Components\TextEntry::make('product.category')
                            ->label('Kategori')
                            ->formatStateUsing(fn(?string $state): string => $state ? ucfirst($state) : '-'),
                        Infolists\Components\TextEntry::make('premium_paid')
                            ->label('Premi')
                            ->formatStateUsing(fn($state): string => number_format((float) $state, 2, '.', ',')),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                        Infolists\Components\TextEntry::make('approvedBy.fullname')
                            ->label('Approve By')
                            ->default('-'),
                        Infolists\Components\TextEntry::make('approved_at')
                            ->label('Approve At')
                            ->dateTime()
                            ->default('-'),
                        Infolists\Components\TextEntry::make('rejection_note')
                            ->label('Catatan Penolakan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('start_date')
                            ->label('Mulai')
                            ->date(),
                        Infolists\Components\TextEntry::make('end_date')
                            ->label('Berakhir')
                            ->date(),
                    ])
                    ->columns(2),
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
            'index' => Pages\ListPolicies::route('/'),
            'edit' => Pages\EditPolicy::route('/{record}/edit'),
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'active' => 'Active',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
        ];
    }
}
