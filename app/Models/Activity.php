<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    protected $appends = ['translated_name', 'translated_description'];

    public function getTranslatedNameAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->name_en : $this->name_ar;
    }

    public function getTranslatedDescriptionAttribute(): string
    {
        if (App::getLocale() === 'en') {
            return $this->description_en ?? '';
        }
        return $this->description_ar ?? '';
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

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'model');
    }
}
