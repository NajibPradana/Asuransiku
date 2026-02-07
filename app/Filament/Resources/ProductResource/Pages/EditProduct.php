<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\Url;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

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
            Actions\Action::make('create')
                ->label('Tambah Baru')
                ->color('primary')
                ->icon('heroicon-o-plus-circle')
                ->authorize('create', static::getModel())
                ->url(fn(): string => static::getResource()::getUrl('create')),
            Actions\Action::make('list')
                ->label('Kembali')
                ->color('gray')
                ->icon('heroicon-o-chevron-left')
                ->url(fn(): string => static::getResource()::getUrl('index', [
                    'page' => $this->page,
                    'tableFilters' => $this->tableFilters,
                    'tableSearch' => $this->tableSearch,
                ])),
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->icon('heroicon-o-trash'),
        ];
    }
}
