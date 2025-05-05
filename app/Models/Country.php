<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'native', 'iso_code'];
    public function states()
    {
        return $this->hasMany(State::class);
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }


}
