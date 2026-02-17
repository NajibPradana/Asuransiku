<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaimResource\Pages;
use App\Models\Claim;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class ClaimResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Claim::class;
    protected static ?string $navigationIcon = 'fluentui-document-ribbon-24-o';
    protected static ?string $navigationLabel = 'Klaim';
    protected static ?string $pluralModelLabel = 'Klaim';
    protected static ?string $label = 'Klaim';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 30;
    protected static ?string $recordTitleAttribute = 'claim_number';

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
                Forms\Components\Section::make('Informasi Klaim')
                    ->schema([
                        Forms\Components\TextInput::make('claim_number')
                            ->label('Nomor Klaim')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('user_id')
                            ->label('Nasabah')
                            ->relationship('user', 'fullname')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('policy_id')
                            ->label('Polis')
                            ->relationship('policy', 'policy_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('incident_date')
                            ->label('Tanggal Kejadian')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('amount_claimed')
                            ->label('Nominal Klaim')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('amount_approved')
                            ->label('Nominal Disetujui')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Rp'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(self::getStatusOptions())
                            ->required(),
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Catatan Penolakan')
                            ->rows(4)
                            ->maxLength(1000)
                            ->visible(fn(Forms\Get $get): bool => $get('status') === 'rejected')
                            ->helperText('Isi catatan jika klaim ditolak.'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('claim_number')
                    ->label('No Klaim')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.fullname')
                    ->label('Nasabah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policy.policy_number')
                    ->label('No Polis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policy.product.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_claimed')
                    ->label('Nominal Klaim')
                    ->alignRight()
                    ->formatStateUsing(fn($state): string => number_format((float) $state, 2, '.', ','))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'review' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'paid' => 'gray',
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
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Tanggal Dibayar')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('incident_date')
                    ->label('Kejadian')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Claim $record): bool => in_array($record->status, ['pending', 'review'], true))
                    ->form(function (Claim $record): array {
                        return [
                            Forms\Components\Section::make('Preview Pengajuan Klaim')
                                ->schema([
                                    Forms\Components\Placeholder::make('claim_number')
                                        ->label('Nomor Klaim')
                                        ->content($record->claim_number ?? '-'),
                                    Forms\Components\Placeholder::make('nasabah')
                                        ->label('Nasabah')
                                        ->content($record->user?->fullname ?? '-'),
                                    Forms\Components\Placeholder::make('policy')
                                        ->label('No Polis')
                                        ->content($record->policy?->policy_number ?? '-'),
                                    Forms\Components\Placeholder::make('product')
                                        ->label('Produk')
                                        ->content($record->policy?->product?->name ?? '-'),
                                    Forms\Components\Placeholder::make('incident_date')
                                        ->label('Tanggal Kejadian')
                                        ->content($record->incident_date
                                            ? $record->incident_date->format('d M Y')
                                            : '-'),
                                    Forms\Components\Placeholder::make('amount_claimed')
                                        ->label('Nominal Klaim')
                                        ->content($record->amount_claimed !== null
                                            ? 'Rp' . number_format((float) $record->amount_claimed, 2, '.', ',')
                                            : '-'),
                                    Forms\Components\Placeholder::make('description')
                                        ->label('Deskripsi')
                                        ->content($record->description ?: '-'),
                                ])
                                ->columns(2),
                            Forms\Components\TextInput::make('amount_approved')
                                ->label('Nominal Disetujui')
                                ->numeric()
                                ->minValue(0)
                                ->prefix('Rp')
                                ->required(),
                        ];
                    })
                    ->action(function (Claim $record, array $data): void {
                        $record->update([
                            'status' => 'approved',
                            'amount_approved' => $data['amount_approved'],
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                            'rejection_reason' => null,
                        ]);

                        Notification::make()
                            ->title('Klaim disetujui')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn(Claim $record): bool => in_array($record->status, ['pending', 'review'], true))
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Catatan Penolakan')
                            ->rows(4)
                            ->required()
                            ->maxLength(1000),
                    ])
                    ->action(function (Claim $record, array $data): void {
                        $record->update([
                            'status' => 'rejected',
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                            'rejection_reason' => $data['rejection_reason'],
                            'amount_approved' => null,
                        ]);

                        Notification::make()
                            ->title('Klaim ditolak')
                            ->danger()
                            ->send();
                    }),
                Tables\Actions\Action::make('markAsPaid')
                    ->label('Tandai Dibayar')
                    ->icon('heroicon-o-banknotes')
                    ->color('info')
                    ->visible(fn(Claim $record): bool => $record->status === 'approved')
                    ->action(function (Claim $record): void {
                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Klaim ditandai sebagai dibayar')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
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
                Infolists\Components\Section::make('Informasi Klaim')
                    ->schema([
                        Infolists\Components\TextEntry::make('claim_number')
                            ->label('Nomor Klaim'),
                        Infolists\Components\TextEntry::make('user.fullname')
                            ->label('Nasabah'),
                        Infolists\Components\TextEntry::make('policy.policy_number')
                            ->label('No Polis'),
                        Infolists\Components\TextEntry::make('policy.product.name')
                            ->label('Produk'),
                        Infolists\Components\TextEntry::make('amount_claimed')
                            ->label('Nominal Klaim')
                            ->formatStateUsing(fn($state): string => number_format((float) $state, 2, '.', ',')),
                        Infolists\Components\TextEntry::make('amount_approved')
                            ->label('Nominal Disetujui')
                            ->formatStateUsing(fn($state): string => number_format((float) $state, 2, '.', ','))
                            ->default('-'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                        Infolists\Components\TextEntry::make('approvedBy.fullname')
                            ->label('Approve By')
                            ->default('-'),
                        Infolists\Components\TextEntry::make('approved_at')
                            ->label('Approve At')
                            ->formatStateUsing(function ($state): string {
                                if (empty($state)) {
                                    return '-';
                                }

                                return \Illuminate\Support\Carbon::parse($state)->format('d M Y H:i');
                            }),
                        Infolists\Components\TextEntry::make('paid_at')
                            ->label('Tanggal Dibayar')
                            ->formatStateUsing(function ($state): string {
                                if (empty($state)) {
                                    return '-';
                                }

                                return \Illuminate\Support\Carbon::parse($state)->format('d M Y H:i');
                            }),
                        Infolists\Components\TextEntry::make('rejection_reason')
                            ->label('Catatan Penolakan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('incident_date')
                            ->label('Tanggal Kejadian')
                            ->formatStateUsing(function ($state): string {
                                if (empty($state)) {
                                    return '-';
                                }

                                return \Illuminate\Support\Carbon::parse($state)->format('d M Y');
                            }),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('Dokumen Pendukung')
                    ->schema([
                        Infolists\Components\TextEntry::make('evidence_files')
                            ->label('File')
                            ->getStateUsing(function ($record) {
                                return $record->evidence_files;
                            })
                            ->html()
                            ->formatStateUsing(function ($state): string {
                                if ($state instanceof \Illuminate\Support\Collection) {
                                    $files = $state->all();
                                } elseif (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    if (json_last_error() === JSON_ERROR_NONE) {
                                        $files = is_array($decoded) ? $decoded : [];
                                    } else {
                                        $files = [$state];
                                    }
                                } else {
                                    $files = is_array($state) ? $state : [];
                                }

                                if (count($files) === 0) {
                                    return '<span class="text-slate-500">-</span>';
                                }

                                $items = array_map(function ($path): string {
                                    $url = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
                                        ? $path
                                        : Storage::disk('public')->url($path);
                                    $name = e(basename($path));
                                    $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
                                    $isPdf = $extension === 'pdf';

                                    if ($isImage) {
                                        $preview = "<img class=\"mt-2 max-h-64 rounded-xl border border-slate-200\" src=\"{$url}\" alt=\"{$name}\" />";

                                        return "<li><a class=\"text-primary-600 underline\" href=\"{$url}\" target=\"_blank\" rel=\"noopener\">{$name}</a>{$preview}</li>";
                                    }

                                    if ($isPdf) {
                                        $preview = "<iframe class=\"mt-2 h-80 w-full rounded-xl border border-slate-200\" src=\"{$url}\" title=\"{$name}\"></iframe>";

                                        return "<li><a class=\"text-primary-600 underline\" href=\"{$url}\" target=\"_blank\" rel=\"noopener\">{$name}</a>{$preview}</li>";
                                    }

                                    return "<li><a class=\"text-primary-600 underline\" href=\"{$url}\" target=\"_blank\" rel=\"noopener\">{$name}</a></li>";
                                }, $files);

                                return '<ul class="list-disc pl-4 space-y-1">' . implode('', $items) . '</ul>';
                            }),
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
            'index' => Pages\ListClaims::route('/'),
            'view' => Pages\ViewClaim::route('/{record}'),
            'edit' => Pages\EditClaim::route('/{record}/edit'),
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'review' => 'Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'paid' => 'Paid',
        ];
    }
}
