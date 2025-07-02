<?php

namespace App\Filament\Resources\Master\UserResource\Pages;

use App\Filament\Resources\Master\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
