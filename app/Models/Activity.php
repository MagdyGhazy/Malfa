<?php

namespace App\Models;

use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\App;

class Activity extends Model
{
    use HasFactory,AttachmentTrait;

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
        $descriptions = [
            'en' => $this->description_en,
            'ar' => $this->description_ar,
        ];

        return $descriptions[App::getLocale()] ?? '';
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    public function features(): MorphToMany
    {
        return $this->morphToMany(Feature::class, 'model', 'featureables');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'model');
    }
}
