<?php

namespace App\Models;

use App\Http\Enums\StatusEnum;
use App\Http\Enums\UnitTypeEnum;
use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Unit extends Model
{
    use HasFactory,AttachmentTrait;

    protected $fillable = [
        'user_id',
        'name',
        'description_en',
        'description_ar',
        'type',
        'rating',
        'status',
        'available_rooms',
    ];
    protected $casts = [
        'available_rooms' => 'array',
    ];
    protected $appends = ['status_description', 'type_description','translated_description'];
    public function getTranslatedDescriptionAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleteMedia($model);
            if ($model->address){
                $model->address()->delete();
            }
        });
    }

    public function getTypeDescriptionAttribute()
    {
        return UnitTypeEnum::getDescription($this->type);
    }
    public function getStatusDescriptionAttribute()
    {
        return $this->status !== null ? StatusEnum::getDescription($this->status) : __('translate.unknown');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'model');
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }
    public function features()
    {
        return $this->morphToMany(Feature::class, 'model');
    }
}
