<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'address_line_en',
        'address_line_ar',
        'city_id',
        'lat',
        'long',
        'zip_code',
    ];

    public function model()
    {
        return $this->morphTo();
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }




}
