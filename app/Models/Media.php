<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'model_id', 'model_type'];
    protected $appends = ['url'];


    protected $hidden = [
        'model_id',
        'model_type',
        'path',
    ];

    public function getUrlAttribute()
    {
        $env = env('APP_ENV');
        if ($env == 'local') {
            return $this->path ? url($this->path) : null;
        }else{
            return $this->path ? url('storage/' . $this->path) : null;
        }
    }

    public function model()
    {
        return $this->morphTo();
    }

}
