<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];

    protected $appends = ['translated_name'];

    public function getTranslatedNameAttribute(): string
    {
        $name = $this->attributes['name'];

        $first = Str::of($name)->before(' ');
        $remaining = Str::of($name)->after(' ');

        $first_translated = __('translate.' . $first);
        $remaining_translated = $remaining !== $name ? __('translate.' . $remaining) : '';

        return trim("{$first_translated} {$remaining_translated}");
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

}
