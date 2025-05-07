<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'from',
        'to',
        'price',
    ];

    public function getTranslatedNameAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->name_en : $this->name_ar;
    }

    public function getTranslatedDescriptionAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'model');
    }

    public function features()
    {
        return $this->morphToMany(Feature::class, 'model', 'featureables');
    }
}
