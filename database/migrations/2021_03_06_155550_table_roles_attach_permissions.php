<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use jeremykenedy\LaravelRoles\Models\Role;

class TableRolesAttachPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            [
                'slug'        => 'view.plugins',
                'roles'       => array('user'),
            ],
            [
                'slug'        => 'view.ownplugins',
                'roles'       => array('user'),
            ],
            [
                'slug'        => 'view.api',
                'roles'       => array('user'),
            ],
            [
                'slug'        => 'view.users',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'view.activity',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'create.apikey',
                'roles'       => array('user'),
            ],
            [
                'slug'        => 'create.plugin',
                'roles'       => array('user'),
            ],
            [
                'slug'        => 'edit.plugin.admin',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'edit.plugin.admin',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'add.member.admin',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'upload.file.admin',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'delete.apikey',
                'roles'       => array('user'),
            ],
            [
                'slug'        => 'delete.plugin.admin',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'delete.file.admin',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'edit.file.admin',
                'roles'       => array('admin'),
            ],
            [
                'slug'        => 'edit.file.admin',
                'roles'       => array('admin'),
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem != null) {
                foreach($Permissionitem['roles'] as $role){
                    $rolea = Role::where('slug', '=', $role)->first();
                    if ($rolea != null){
                        $rolea->attachPermission($newPermissionitem);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
