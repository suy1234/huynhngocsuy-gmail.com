<?php

namespace Modules\User\Entities;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
class User extends Model{
    use Authenticatable;

    protected $fillable = [
        'parent_id',
        'position_id',
        'department_id',
        'employee_id',
        'block_id',
        'role_id',
        'username',
        'password',
        'email',
        'facebook',
        'google',
        'status',
        'remember_token',
        'permissions',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_login'];

    public function childs() {
        return $this->hasMany('Modules\User\Entities\User', 'parent_id', 'id')->with('childs');
    }

    public static function registered($email) {
        return static::where('email', $email)->exists();
    }

    public static function findByEmail($email) {
        return static::where('email', $email)->first();
    }

    public static function totalCustomers() {
        return Role::findOrNew(setting('customer_role'))->users()->count();
    }

    /**
     * Login the user.
     *
     * @return $this|bool
     */
    public function login() {
        return auth()->login($this);
    }

    /**
     * Determine if the user is a customer.
     *
     * @return bool
     */
    public function isCustomer() {
        if ($this->hasRoleName('admin')) {
            return false;
        }

        return $this->hasRoleId(setting('customer_role'));
    }

    /**
     * Determine if the user is a customer.
     *
     * @return bool
     */
    public function isSale() {

        return config('im.module.user.config.department.' . $this->department_id . '.slug') == 'sale';
    }

    /**
     * Determine if the user is a customer.
     *
     * @return bool
     */
    public function isLead() {
        return $this->childs->count() > 0;
    }

    public function isSaleLead() {
        return $this->isSale() && $this->isLead();
    }

    public function getSaleStaffIds() {
        $ids = collect();
        if ($this->isSale()) {
            $ids->push($this->id);
        }
        if ($this->isSaleLead()) {
            $ids = $ids->merge($this->childs->pluck('fullname', 'id')->keys());
            foreach ($this->childs as $user) {
                $ids = $ids->merge($user->childs->pluck('fullname', 'id')->keys());
            }

        }
        return $ids->all();
    }

    /**
     * Checks if a user belongs to the given Role ID.
     *
     * @param int $roleId
     * @return bool
     */
    public function hasRoleId($roleId) {
        return $this->roles()->whereId($roleId)->count() !== 0;
    }

    /**
     * Checks if a user belongs to the given Role Slug.
     *
     * @param string $slug
     * @return bool
     */
    public function hasRoleSlug($slug) {
        return $this->roles()->whereSlug($slug)->count() !== 0;
    }

    /**
     * Checks if a user belongs to the given Role Name.
     *
     * @param string $name
     * @return bool
     */
    public function hasRoleName($name) {
        return $this->roles()->whereTranslation('name', $name)->count() !== 0;
    }

    /**
     * Check if the current user is activated.
     *
     * @return bool
     */
    public function isActivated() {
        return true;
        return Activation::completed($this);
    }

    /**
     * Get the recent orders of the user.
     *
     * @param int $take
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function recentOrders($take) {
        return $this->orders()->latest()->take($take)->get();
    }

    public function scopeActive($query) {
        return $query->where('active', 1);
    }

    /**
     * Get the roles of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    public function getRoleSetAttribute() {
        $role = Role::where('id', $this->role_id)->first();
        if(!empty($role)){
            return array_fill_keys(explode(',', $role->permissions), true);
        } 
        return [];
    }
    /**
     * Get the orders of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class, 'customer_id');
    }

    // /**
    //  * Get the full name of the user.
    //  *
    //  * @return string
    //  */
    // public function getFullNameAttribute()
    // {
    //     return "{$this->first_name} {$this->last_name}";
    // }

    public function getFullNameEmailAttribute() {
        return "{$this->fullname} - {$this->email}";
    }

    public function getFullNamePhoneAttribute() {
        return "{$this->fullname} - {$this->phone}";
    }

    /**
     * Get the department of the user.
     *
     * @return string
     */
    public function getDepartmentAttribute() {
        return config('im.module.user.config.department.' . $this->department_id)['title'] ?? '';
    }

    /**
     * Set user's permissions.
     *
     * @param array $permissions
     * @return void
     */
    public function setPermissionsAttribute(array $permissions) {
        $this->attributes['permissions'] = Permission::prepare($permissions);
    }

    /**
     * Determine if the user has access to the given permissions.
     *
     * @param array|string $permissions
     * @return bool
     */
    public function hasAccess($permissions) {
        $permissions = is_array($permissions) ? $permissions : func_get_args();
        return $this->getPermissionsInstance()->hasAccess($permissions);
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

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table() {
        return new UserTable($this->newQuery());
    }

    public function scopeSales($query) {
        $department_sale_id = collect(config('im.module.user.config.department'))->firstWhere('slug', 'sale')['id'];
        return $query->where('department_id', $department_sale_id);
    }

    protected static function boot() {
        parent::boot();
        static::created(function (self $user) {
        });
    }
}
