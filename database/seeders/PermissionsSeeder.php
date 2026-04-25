<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1. Definimos los permisos
        Permission::create(['name' => 'ver articulos']);
        Permission::create(['name' => 'crear articulos']);
        Permission::create(['name' => 'editar articulos']);
        Permission::create(['name' => 'eliminar articulos']);

        // 2. Creamos los roles y asignamos permisos
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo(Permission::all()); // El admin hace todo

        $roleEscritor = Role::create(['name' => 'Escritor']);
        $roleEscritor->givePermissionTo(['ver articulos', 'crear articulos', 'editar articulos']);

        // 3. Creamos usuarios de prueba y les asignamos el rol
        $admin = User::create([
            'name' => 'Juan Administrador',
            'email' => 'admin@ejemplo.com',
            'password' => bcrypt('password123')
        ]);
        $admin->assignRole($roleAdmin);

        $escritor = User::create([
            'name' => 'Alumno Escritor',
            'email' => 'escritor@ejemplo.com',
            'password' => bcrypt('password123')
        ]);
        $escritor->assignRole($roleEscritor);
    }
}
