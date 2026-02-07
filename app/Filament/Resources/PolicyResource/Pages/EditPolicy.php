<?php

namespace App\Filament\Resources\PolicyResource\Pages;

use App\Filament\Resources\PolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\Url;

class EditPolicy extends EditRecord
{
    protected static string $resource = PolicyResource::class;

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
