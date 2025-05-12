<?php

namespace App\Models;

use App\Http\Enums\StatusEnum;
use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\App;

class Restaurant extends Model
{
    use HasFactory,AttachmentTrait;

    protected $fillable = [
        'user_id',
        'name',
        'description_en',
        'description_ar',
        'rating',
        'opening_time',
        'closing_time',
        'available_tables',
        'status',
    ];
    protected $casts = [
        'available_tables' => 'array',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];
    protected $appends = ['status_description','translated_description'];
    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleteMedia($model);
            if ($model->address) {
                $model->address()->delete();
            }
            if ($model->features) {
                $model->features()->detach();
            }
        });
    }
    public function getTranslatedDescriptionAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }
    public function getStatusDescriptionAttribute()
    {
        return StatusEnum::getDescription($this->status);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function address(): MorphOne

    {
        return $this->morphOne(Address::class, 'model');
    }

    public function media(): MorphMany

    {
        return $this->morphMany(Media::class, 'model');
    }

    public function features(): MorphToMany

    {
        return $this->morphToMany(Feature::class, 'model', 'featureables');
    }

    public function tables(): HasMany
    {
        return $this->hasMany(RestaurantTable::class,'restaurant_id');
    }

}
