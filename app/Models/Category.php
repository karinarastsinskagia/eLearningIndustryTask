<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */

    protected $table = 'categories';

    public $timestamps = false;

    public function articles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Article::class);
    }
}
