<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Feature extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'type'
    ];

    protected $appends = ['translated_name'];

    protected $casts = [
        'type' => 'array',
    ];

    public function getTranslatedNameAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->name_en : $this->name_ar;
    }

    public function scopeForModel($query, $modelType)
    {
        return $query->whereJsonContains('type', $modelType);
    }

    public function getTypeAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = json_encode($value);
    }
}
