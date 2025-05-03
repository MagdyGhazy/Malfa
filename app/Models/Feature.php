<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'model_id' => 'integer',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'name_en',
        'name_ar'
    ];

    /**
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
