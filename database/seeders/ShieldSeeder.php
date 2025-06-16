<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_jabatan","view_any_jabatan","create_jabatan","update_jabatan","restore_jabatan","restore_any_jabatan","replicate_jabatan","reorder_jabatan","delete_jabatan","delete_any_jabatan","force_delete_jabatan","force_delete_any_jabatan","view_jenis::insiden","view_any_jenis::insiden","create_jenis::insiden","update_jenis::insiden","restore_jenis::insiden","restore_any_jenis::insiden","replicate_jenis::insiden","reorder_jenis::insiden","delete_jenis::insiden","delete_any_jenis::insiden","force_delete_jenis::insiden","force_delete_any_jenis::insiden","view_pasien","view_any_pasien","create_pasien","update_pasien","restore_pasien","restore_any_pasien","replicate_pasien","reorder_pasien","delete_pasien","delete_any_pasien","force_delete_pasien","force_delete_any_pasien","view_pegawai","view_any_pegawai","create_pegawai","update_pegawai","restore_pegawai","restore_any_pegawai","replicate_pegawai","reorder_pegawai","delete_pegawai","delete_any_pegawai","force_delete_pegawai","force_delete_any_pegawai","view_penanggung::biaya","view_any_penanggung::biaya","create_penanggung::biaya","update_penanggung::biaya","restore_penanggung::biaya","restore_any_penanggung::biaya","replicate_penanggung::biaya","reorder_penanggung::biaya","delete_penanggung::biaya","delete_any_penanggung::biaya","force_delete_penanggung::biaya","force_delete_any_penanggung::biaya","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_unit","view_any_unit","create_unit","update_unit","restore_unit","restore_any_unit","replicate_unit","reorder_unit","delete_unit","delete_any_unit","force_delete_unit","force_delete_any_unit","change_role_pegawai","change_password_pegawai","view_insiden","view_any_insiden","create_insiden","update_insiden","restore_insiden","restore_any_insiden","delete_insiden","delete_any_insiden","force_delete_insiden","force_delete_any_insiden","view_root::cause::analysis","view_any_root::cause::analysis","create_root::cause::analysis","update_root::cause::analysis","restore_root::cause::analysis","restore_any_root::cause::analysis","delete_root::cause::analysis","delete_any_root::cause::analysis","force_delete_root::cause::analysis","force_delete_any_root::cause::analysis","replicate_insiden","reorder_insiden","replicate_root::cause::analysis","reorder_root::cause::analysis","widget_InsidenBulananChart","widget_InsidenGradingOverview","widget_InsidenJenisOverview","widget_InsidenOverview"]},{"name":"komite_mutu","guard_name":"web","permissions":["view_jabatan","view_any_jabatan","view_jenis::insiden","view_any_jenis::insiden","update_jenis::insiden","view_pasien","view_any_pasien","create_pasien","update_pasien","restore_pasien","restore_any_pasien","delete_pasien","delete_any_pasien","force_delete_pasien","force_delete_any_pasien","view_pegawai","view_any_pegawai","view_penanggung::biaya","view_any_penanggung::biaya","create_penanggung::biaya","update_penanggung::biaya","restore_penanggung::biaya","restore_any_penanggung::biaya","delete_penanggung::biaya","delete_any_penanggung::biaya","view_unit","view_any_unit","view_insiden","view_any_insiden","create_insiden","update_insiden","restore_insiden","restore_any_insiden","delete_insiden","delete_any_insiden","force_delete_insiden","force_delete_any_insiden","view_root::cause::analysis","view_any_root::cause::analysis","create_root::cause::analysis","update_root::cause::analysis","restore_root::cause::analysis","restore_any_root::cause::analysis","delete_root::cause::analysis","delete_any_root::cause::analysis","force_delete_root::cause::analysis","force_delete_any_root::cause::analysis","replicate_insiden","reorder_insiden"]},{"name":"admin","guard_name":"web","permissions":["view_jabatan","view_any_jabatan","create_jabatan","update_jabatan","restore_jabatan","restore_any_jabatan","replicate_jabatan","reorder_jabatan","delete_jabatan","delete_any_jabatan","force_delete_jabatan","force_delete_any_jabatan","view_jenis::insiden","view_any_jenis::insiden","create_jenis::insiden","update_jenis::insiden","restore_jenis::insiden","restore_any_jenis::insiden","replicate_jenis::insiden","reorder_jenis::insiden","delete_jenis::insiden","delete_any_jenis::insiden","force_delete_jenis::insiden","force_delete_any_jenis::insiden","view_pasien","view_any_pasien","create_pasien","update_pasien","restore_pasien","restore_any_pasien","replicate_pasien","reorder_pasien","delete_pasien","delete_any_pasien","force_delete_pasien","force_delete_any_pasien","view_pegawai","view_any_pegawai","create_pegawai","update_pegawai","restore_pegawai","restore_any_pegawai","replicate_pegawai","reorder_pegawai","delete_pegawai","delete_any_pegawai","force_delete_pegawai","force_delete_any_pegawai","view_penanggung::biaya","view_any_penanggung::biaya","create_penanggung::biaya","update_penanggung::biaya","restore_penanggung::biaya","restore_any_penanggung::biaya","replicate_penanggung::biaya","reorder_penanggung::biaya","delete_penanggung::biaya","delete_any_penanggung::biaya","force_delete_penanggung::biaya","force_delete_any_penanggung::biaya","view_unit","view_any_unit","create_unit","update_unit","restore_unit","restore_any_unit","replicate_unit","reorder_unit","delete_unit","delete_any_unit","force_delete_unit","force_delete_any_unit","change_role_pegawai","change_password_pegawai","view_insiden","view_any_insiden","create_insiden","update_insiden","restore_insiden","restore_any_insiden","delete_insiden","delete_any_insiden","force_delete_insiden","force_delete_any_insiden","view_root::cause::analysis","view_any_root::cause::analysis","create_root::cause::analysis","update_root::cause::analysis","restore_root::cause::analysis","restore_any_root::cause::analysis","delete_root::cause::analysis","delete_any_root::cause::analysis","force_delete_root::cause::analysis","force_delete_any_root::cause::analysis","replicate_insiden","reorder_insiden","replicate_root::cause::analysis","reorder_root::cause::analysis","widget_InsidenBulananChart","widget_InsidenGradingOverview","widget_InsidenJenisOverview","widget_InsidenOverview"]},{"name":"pegawai","guard_name":"web","permissions":["view_jabatan","view_any_jabatan","view_jenis::insiden","view_any_jenis::insiden","view_pasien","view_any_pasien","create_pasien","update_pasien","restore_pasien","restore_any_pasien","delete_pasien","delete_any_pasien","view_penanggung::biaya","view_any_penanggung::biaya","create_penanggung::biaya","update_penanggung::biaya","view_unit","view_any_unit","create_unit","update_unit","restore_unit","delete_unit","delete_any_unit","view_insiden","view_any_insiden","create_insiden","update_insiden","delete_insiden","delete_any_insiden","view_root::cause::analysis","view_any_root::cause::analysis","create_root::cause::analysis","update_root::cause::analysis","view_only_unit_insiden"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
