<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\Url;

class EditClaim extends EditRecord
{
    protected static string $resource = ClaimResource::class;

    #[Url]
    public ?string $page = null;

    #[Url]
    public ?array $tableFilters = null;

    #[Url]
    public ?string $tableSearch = null;

    public function getFormActions(): array
    {
        return [
            parent::getSaveFormAction()
                ->label('Simpan Perubahan')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            Actions\Action::make('list')
                ->label('Kembali')
                ->color('gray')
                ->icon('heroicon-o-chevron-left')
                ->url(fn(): string => static::getResource()::getUrl('index', [
                    'page' => $this->page,
                    'tableFilters' => $this->tableFilters,
                    'tableSearch' => $this->tableSearch,
                ])),
        ];
    }
}
