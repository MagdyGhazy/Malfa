<?php

namespace App\Models;

use App\Http\Enums\AvailableEnum;
use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class RestaurantTable extends Model
{
    use HasFactory, AttachmentTrait;

    protected $fillable = [
        'restaurant_id',
        'capacity',
        'description_en',
        'description_ar',
        'is_available',
    ];
    protected $appends = ['available_description','translated_description'];
    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleteMedia($model);
            if ($model->features) {
                $model->features()->detach();
            }
        });
    }

    public function getTranslatedDescriptionAttribute(): ?string
    {
        return App::getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }
    public function getAvailableDescriptionAttribute()
    {
        return  AvailableEnum::getDescription($this->is_available);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }
    public function features()
    {
        return $this->morphToMany(Feature::class, 'model', 'featureables');
    }


}
