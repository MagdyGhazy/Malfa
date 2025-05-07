<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Landing extends Model
{
    use HasFactory;

    protected $fillable = ['description_en','description_ar'];
    protected $appends = ['translated_description'];

    public function getTranslatedDescriptionAttribute(): string
    {
        return App::getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }

}
