<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\User\Entities\Role;
use Auth;
class User extends Authenticatable
{
    use Notifiable;
    protected $appends = [
        'role',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getStatusTextAttribute()
    {
        return $this->role_set;
    }
    public function setPermissionsAttribute(array $permissions) {
        $this->attributes['permissions'] = Permission::prepare($permissions);
    }

    public function getRoleSetAttribute() {
        $role = Role::where('id', $this->role_id)->first();
        if(!empty($role)){
            return array_fill_keys(explode(',', str_replace(['"', ',,'], "", $role->permissions)), true);
        } 
        return [];
    }
    /**
     * Determine if the user has access to the given permissions.
     *
     * @param array|string $permissions
     * @return bool
     */
    public function hasAccess($permissions) {
        return !empty($this->role_set[$permissions]) ? $this->role_set[$permissions] : false;
    }

    /**
     * Determine if the user has access to the any given permissions
     *
     * @param array|string $permissions
     * @return bool
     */
    public function hasAnyAccess($permissions) {
        $permissions = is_array($permissions) ? $permissions : func_get_args();

        return $this->getPermissionsInstance()->hasAnyAccess($permissions);
    }
}
