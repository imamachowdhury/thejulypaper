<?php

namespace App\Filament\Resources\MenuLinks\Pages;

use App\Filament\Resources\MenuLinks\MenuLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMenuLinks extends ManageRecords
{
    protected static string $resource = MenuLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
