<?php

namespace App\Models;

use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, AttachmentTrait;

    protected $fillable = [
        'user_id',
        'model_id',
        'model_type',
        'rate',
        'message'
    ];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleteMedia($model);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }
}
