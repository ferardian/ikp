<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.name', "Insiden Keselamatan Pasien");
        $this->migrator->add('general.about', "Solusi praktis untuk mencatat dan menilai risiko insiden demi meningkatkan keselamatan pasien");
        $this->migrator->add('general.faskes', "RSI PKU Muhammadiyah Pekajangan");
        $this->migrator->add('general.address', "Jl. Raya Ambokembang No.42-44, Cangkring, Ambokembang, Kec. Kedungwuni, Kabupaten Pekalongan, Jawa Tengah 51173");
        $this->migrator->add('general.logo', null);
        $this->migrator->add('general.show_logo', false);
        $this->migrator->add('general.juknis', null);
    }
};
