<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Enums\UserTypeEnum;
use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AttachmentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['type_description'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'type'              => 'integer' ,
    ];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleteMedia($model);
        });
    }


    public function getTypeDescriptionAttribute()
    {
        return $this->type ? UserTypeEnum::getDescription($this->type) : null;
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function assignRole($roleId)
    {
        $this->roles()->sync([$roleId]);
    }

    public function getPermissions()
    {
        $permissions = [];

        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }

        return array_unique($permissions);
    }


    public function hasPermissionTo($permissionName)
    {
        $permissions = $this->getPermissions();

        return in_array($permissionName, $permissions);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(\App\Models\Media::class, 'model');
    }
    public function address()
    {
        return $this->morphOne(Address::class, 'model');
    }
}
