<?php

namespace App\Models;

use App\Http\Enums\StatusEnum;
use App\Http\Enums\UnitTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

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
    protected $appends = ['status_description', 'type_description'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getTypeDescriptionAttribute()
    {
        return UnitTypeEnum::getDescription($this->type);
    }
    public function getStatusDescriptionAttribute()
    {
        return $this->status !== null ? StatusEnum::getDescription($this->status) : __('translate.unknown');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'model');
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }


}
