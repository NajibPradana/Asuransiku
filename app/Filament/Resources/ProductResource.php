<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Support\NumberFormatter;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;

class ProductResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'fluentui-shopping-bag-20-o';
    protected static ?string $navigationLabel = 'Produk Asuransi';
    protected static ?string $pluralModelLabel = 'Produk Asuransi';
    protected static ?string $label = 'Produk';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 10;

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
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) =>
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'slug', ignoreRecord: true)
                            ->helperText('URL-friendly name. Will be auto-generated from the name if left empty.')
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('editSlug')
                                    ->modal()
                                    ->icon('heroicon-o-pencil-square')
                                    ->modalHeading('Edit Slug')
                                    ->modalDescription('Use lowercase letters, numbers, and hyphens only.')
                                    ->modalIcon('heroicon-o-link')
                                    ->modalSubmitActionLabel('Update Slug')
                                    ->form([
                                        Forms\Components\TextInput::make('new_slug')
                                            ->hiddenLabel()
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(Product::class, 'slug', ignoreRecord: true)
                                            ->helperText('The slug will be automatically formatted as you type.')
                                    ])
                                    ->fillForm(fn(Get $get): array => [
                                        'new_slug' => $get('slug'),
                                    ])
                                    ->action(function (Forms\Components\Actions\Action $action, array $data, Set $set) {
                                        if (empty($data['new_slug']) || !preg_match('/^[a-z0-9-]+$/', $data['new_slug'])) {
                                            Notification::make()
                                                ->title('Slug Update Failed')
                                                ->body('The slug must contain only lowercase letters, numbers, and hyphens.')
                                                ->danger()
                                                ->send();

                                            $action->halt();
                                        }

                                        $set('slug', $data['new_slug']);
                                    })
                            ),

                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'kesehatan' => 'Kesehatan',
                                'perjalanan' => 'Perjalanan',
                                'jiwa' => 'Jiwa',
                                'kendaraan' => 'Kendaraan',
                                'properti' => 'Properti',
                                'usaha' => 'Usaha',
                            ])
                            ->required()
                            ->searchable()
                            ->native(false),

                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Deskripsi')
                            ->maxLength(2000)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('base_premium')
                            ->label('Base Premium')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->prefix('Rp'),

                        Forms\Components\TextInput::make('coverage_amount')
                            ->label('Coverage Amount')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->prefix('Rp'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('base_premium')
                    ->label('Base Premium')
                    ->sortable()
                    ->alignRight()
                    ->formatStateUsing(fn($state): string => NumberFormatter::formatNumber($state, 2))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('coverage_amount')
                    ->label('Coverage Amount')
                    ->sortable()
                    ->alignRight()
                    ->formatStateUsing(fn($state): string => NumberFormatter::formatNumber($state, 2))
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'kesehatan' => 'Kesehatan',
                        'perjalanan' => 'Perjalanan',
                        'jiwa' => 'Jiwa',
                        'kendaraan' => 'Kendaraan',
                        'properti' => 'Properti',
                        'usaha' => 'Usaha',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Produk')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nama Produk')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),
                        Infolists\Components\TextEntry::make('category')
                            ->label('Kategori')
                            ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                        Infolists\Components\TextEntry::make('slug')
                            ->label('Slug'),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Deskripsi')
                            ->markdown(),
                        Infolists\Components\TextEntry::make('base_premium')
                            ->label('Base Premium')
                            ->formatStateUsing(fn($state): string => NumberFormatter::formatNumber($state, 2)),
                        Infolists\Components\TextEntry::make('coverage_amount')
                            ->label('Coverage Amount')
                            ->formatStateUsing(fn($state): string => NumberFormatter::formatNumber($state, 2)),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Aktif')
                            ->boolean(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
