<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des permissions
        $permissions = [
            'server.delete' => 'Supprimer un serveur',
            'server.manage' => 'Gérer un serveur',
            'admin.access' => 'Accéder au panel admin',
            'users.manage' => 'Gérer les utilisateurs',
            'servers.manage' => 'Gérer tous les serveurs',
            'billing.manage' => 'Gérer la facturation',
            'nodes.manage' => 'Gérer les nodes',
            'locations.manage' => 'Gérer les locations',
            'plans.manage' => 'Gérer les plans',
            'support.access' => 'Accéder au panel support',
            'support.assign' => 'Attribuer des tickets support',
        ];

        foreach ($permissions as $slug => $name) {
            Permission::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // Création des rôles
        $adminRole = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Administrateur']);
        $supportRole = Role::firstOrCreate(['slug' => 'support'], ['name' => 'Support']);
        $userRole = Role::firstOrCreate(['slug' => 'user'], ['name' => 'Utilisateur']);

        // Assigner toutes les permissions au rôle admin
        $adminRole->permissions()->sync(Permission::all());

        // Assigner les permissions au rôle support
        $supportPermissions = Permission::whereIn('slug', ['support.access', 'support.assign'])->get();
        $supportRole->permissions()->sync($supportPermissions);

        // Le rôle user n'a pas de permissions administratives par défaut dans ce cas
    }
}
