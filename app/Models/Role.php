<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name_en', 'name_ar'];

    protected $appends = ['translated_name'];


    public function getTranslatedNameAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->name_en : $this->name_ar;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }


    public function syncPermissions($permissionIds)
    {
        $this->permissions()->sync($permissionIds);
    }

}
