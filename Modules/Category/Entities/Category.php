<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [];

    public $translatable = ['name', 'description'];

    // protected static function newFactory()
    // {
    //     return \Modules\Category\Database\factories\CategoryFactory::new();
    // }
}
