<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use jeremykenedy\LaravelRoles\Models\Permission;

class TablePermissionsAddDefaultPermissions extends Migration
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
                'name'        => 'Can View Plugins',
                'slug'        => 'view.plugins',
                'description' => 'Can view plugins',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Own Plugins',
                'slug'        => 'view.ownplugins',
                'description' => 'Can view own plugins',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View API',
                'slug'        => 'view.api',
                'description' => 'Can view API',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Users',
                'slug'        => 'view.users',
                'description' => 'Can view users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Activity',
                'slug'        => 'view.activity',
                'description' => 'Can view activity',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create APIKey',
                'slug'        => 'create.apikey',
                'description' => 'Can create apikey',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create Plugin',
                'slug'        => 'create.plugin',
                'description' => 'Can create plugin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Plugin',
                'slug'        => 'edit.plugin',
                'description' => 'Can edit plugin',
                'model'       => 'App\Plugin',
            ],
            [
                'name'        => 'Can Edit Plugin As Admin',
                'slug'        => 'edit.plugin.admin',
                'description' => 'Can edit plugin as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Plugin As Admin',
                'slug'        => 'edit.plugin.admin',
                'description' => 'Can edit plugin as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Member',
                'slug'        => 'delete.member',
                'description' => 'Can delete member',
                'model'       => 'App\Plugin',
            ],
            [
                'name'        => 'Can Delete Member As Admin',
                'slug'        => 'delete.member.admin',
                'description' => 'Can delete member as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Add Member',
                'slug'        => 'add.member',
                'description' => 'Can add member',
                'model'       => 'App\Plugin',
            ],
            [
                'name'        => 'Can add Member As Admin',
                'slug'        => 'add.member.admin',
                'description' => 'Can add member as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Upload File',
                'slug'        => 'upload.file',
                'description' => 'Can upload file',
                'model'       => 'App\Plugin',
            ],
            [
                'name'        => 'Can Uplaod File As Admin',
                'slug'        => 'upload.file.admin',
                'description' => 'Can upload file as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete APIKey',
                'slug'        => 'delete.apikey',
                'description' => 'Can delete APIKey',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Plugin',
                'slug'        => 'delete.plugin',
                'description' => 'Can delete plugin',
                'model'       => 'App\Plugin',
            ],
            [
                'name'        => 'Can Delete Plugin As Admin',
                'slug'        => 'delete.plugin.admin',
                'description' => 'Can delete plugin as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete File',
                'slug'        => 'delete.file',
                'description' => 'Can delete file',
                'model'       => 'App\Plugin',
            ],
            [
                'name'        => 'Can Delete File As Admin',
                'slug'        => 'delete.file.admin',
                'description' => 'Can delete file as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit File',
                'slug'        => 'edit.file',
                'description' => 'Can edit file',
                'model'       => 'App\Plugin',
            ],
            [
                'name'        => 'Can Edit File As Admin',
                'slug'        => 'edit.file.admin',
                'description' => 'Can edit file as admin',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit File As Admin',
                'slug'        => 'edit.file.admin',
                'description' => 'Can edit file as admin',
                'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                Permission::create([
                        'name'          => $Permissionitem['name'],
                        'slug'          => $Permissionitem['slug'],
                        'description'   => $Permissionitem['description'],
                        'model'         => $Permissionitem['model'],
                ]);
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
