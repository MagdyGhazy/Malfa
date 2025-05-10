<?php

namespace App\Models;

use App\Http\Enums\AvailableEnum;
use App\Http\Enums\RoomTypeEnum;
use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Room extends Model
{
    use HasFactory,AttachmentTrait;

    protected $fillable = [
        'unit_id',
        'room_type',
        'price_per_night',
        'capacity',
        'description_en',
        'description_ar',
        'rules_en',
        'rules_ar',
        'is_available',
        ];

    protected $appends = ['available_description', 'room_type_description','translated_description','translated_rules'];
    public function getTranslatedDescriptionAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }
    public function getTranslatedRulesAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->rules_en : $this->rules_ar;
    }

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleteMedia($model);
        });
    }
    public function getRoomTypeDescriptionAttribute()
    {
        return RoomTypeEnum::getDescription($this->room_type);
    }
    public function getAvailableDescriptionAttribute()
    {
        return  AvailableEnum::getDescription($this->is_available);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'model');
    }
}
