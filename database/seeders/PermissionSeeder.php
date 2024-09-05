<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create_task', 'description' => 'Créer une tâche']);
        Permission::create(['name' => 'view_report', 'description' => 'Voir les rapports']);
        Permission::create(['name' => 'assign_task', 'description' => 'Assigner une tâche']);
        Permission::create(['name' => 'note', 'description' => 'noter une tache']);
        Permission::create(['name' => 'delete_task', 'description' => 'Supprimer une tâche']);
        Permission::create(['name' => 'edit_task', 'description' => 'Modifier une tâche']);
        Permission::create(['name' => 'manage_user', 'description' => 'Gérer les utilisateurs']);
        Permission::create(['name' => 'manage_role', 'description' => 'Gérer les rôles']);
        Permission::create(['name' => 'manage_permission', 'description' => 'Gérer les permissions']);
        Permission::create(['name'=>'edit_direction','description'=>'editer une direction']);
        Permission::create(['name'=>'edit_service','description'=>'editer un service']);
        Permission::create(['name'=>'edit_your_account','description'=>'editer son compte']);
    }
}
