<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call(PermissionSeeder::class);

        
        $role = Role::firstOrCreate(['name' => 'admin']);

        
        $adminUser = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'), 
			'permission_id' => 1,
        ]);

        
        $adminUser->assignRole($role);

        $adminUser->givePermissionTo(['admin', 'default']); 

        
        $this->call(StatesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PropertySeeder::class);
    }
}
