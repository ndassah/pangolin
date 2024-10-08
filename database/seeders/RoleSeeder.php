<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrateur = Role::create(['name' =>'admin','description' => 'Administrateur']);
        $directeur = Role::create(['name' =>'directeur','description' =>'Directeur']);
        $superviseur = Role::create(['name' => 'superviseur', 'description' => 'Superviseur']);
        $stagiaire = Role::create(['name' =>'stagiaire', 'description' => 'Stagiaire']);

        $superviseur->givePermissionTo(['assign_task','edit_your_account','note']);

        $administrateur->givePermissionTo([
            'assign_task','edit_your_account','manage_user','edit_direction','edit_service','edit_task'
        ]);
        $directeur->givenPermission(['assign_task','edit_task','assign_stagiaire',]);
    
        $stagiaire->givePermissionTo(['edit_your_account',]);
    }
}
