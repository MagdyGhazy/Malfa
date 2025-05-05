<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @var string[]
     */
    protected $casts = [
        'type' => 'array',
    ];

    /**
     * @param $query
     * @param $modelType
     * @return mixed
     */
    public function scopeForModel($query, $modelType)
    {
        return $query->whereJsonContains('type', $modelType);
    }

//    /**
//     * @param $value
//     * @return mixed
//     */
//    public function getTypeAttribute($value)
//    {
//        return json_decode($value, true);
//    }
//
//    /**
//     * @param $value
//     * @return void
//     */
//    public function setTypeAttribute($value)
//    {
//        $this->attributes['type'] = json_encode($value);
//    }
}
