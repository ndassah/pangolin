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
    }
}
