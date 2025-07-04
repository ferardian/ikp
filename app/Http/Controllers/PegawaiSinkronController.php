<?php

namespace App\Http\Controllers;

use App\Services\PegawaiSinkronService;
use Illuminate\Http\Request;
use Filament\Notifications\Notification;

class PegawaiSinkronController extends Controller
{
    public function sinkron(Request $request, PegawaiSinkronService $service)
    {
        $nik = $request->get('nik');

        try {
            $user = $service->handle($nik);

            Notification::make()
                ->title("Berhasil Sinkron User {$user->name}")
                ->success()
                ->duration(2000)
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title("Tidak Dapat Melakukan Sinkron User {$nik}")
                ->body($e->getMessage())
                ->danger()
                ->duration(2000)
                ->send();
        }

        return redirect()->back();
    }
}
