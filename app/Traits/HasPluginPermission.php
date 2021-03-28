<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use InvalidArgumentException;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Facades\DB;

trait HasPluginPermission
{

    public function getPermissionUsers($permissionId, $plugin)
    {
        $query = DB::connection(config('roles.connection'))->table('permission_user_plugin');

        $query->where('permission_id', '=', $permissionId)->where('plugin_id', '=', $plugin->id);

        return $query->get();
    }


    public function allowedPlugin($providedPermission, Model $entity, $owner = true, $ownerColumn = 'user_id')
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('allowed');
        }

        if ($owner === true && $entity->{$ownerColumn} == $this->id) {
            return true;
        }
        $perm = Permission::where('slug', '=', $providedPermission)->first();
        if (is_null($perm)){
            return false;
        }
        if ($this->getPermissionUsers($perm->id, $entity)->count() == 0)
        {
            return false;
        }
        return true;
    }

}
