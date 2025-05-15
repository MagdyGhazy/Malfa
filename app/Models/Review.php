<?php

namespace App\Models;

use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, AttachmentTrait;

    protected $casts = [
        'model_type' => 'string',
    ];

    protected $fillable = [
        'user_id',
        'model_id',
        'model_type',
        'rate',
        'message'
    ];

    public function setModelTypeAttribute($value)
    {
        $map = [
            'unit'          => \App\Models\Unit::class,
            'room'          => \App\Models\Room::class,
            'restaurant'    => \App\Models\Restaurant::class,
            'activity'      => \App\Models\Activity::class,
            'table'         => \App\Models\RestaurantTable::class
        ];

        $this->attributes['model_type'] = $map[strtolower($value)] ?? $value;
    }

    public function getModelTypeAttribute($value)
    {
        $reverseMap = [
            \App\Models\Unit::class            => 'unit',
            \App\Models\Room::class            => 'room',
            \App\Models\Restaurant::class      => 'restaurant',
            \App\Models\Activity::class        => 'activity',
            \App\Models\RestaurantTable::class => 'table'
        ];
        return $reverseMap[$value] ?? $value;
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }
}
