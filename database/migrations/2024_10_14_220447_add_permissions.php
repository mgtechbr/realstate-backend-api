<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class AddPermissions extends Migration
{
    public function up()
    {
        $permissions = [
            'admin',
            'default',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }

    public function down()
    {
        // Remover todas as permissões criadas
        $permissions = [
            'admin',
            'default'
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
