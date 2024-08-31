<?php

namespace App\Filament\Resources\InstitutionResource\Pages;

use App\Filament\Resources\InstitutionResource;
use App\Models\Institution;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInstitution extends CreateRecord
{
    protected static string $resource = InstitutionResource::class;

    protected function handleRecordCreation(array $data): Institution
    {
        $data['user_id'] = auth()->user()->id;
        $data['qr_content'] = 'random ahh qr content random ahh qr content random ahh qr content';

        return static::getModel()::create($data);
    }
}
