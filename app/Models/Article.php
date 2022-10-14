<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Article extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    public $timestamps = false;

    protected $with = ['category','user'];

    protected $fillable = ['title','content','category'];

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query){

        if(request('search')){

            $query
                ->where('title','like','%'.request('search').'%');
        }
    }



}
