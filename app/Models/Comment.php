<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;


class Comment extends Model
{
    use HasFactory;

    public function article()
    {
        return $this->belongsTo(Article::class);
    }


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    //By default, Eloquent expects created_at and updated_at columns to exist on your model's corresponding database table. to avoid these columns to be automatically managed by Eloquent,

    public $timestamps = false;

    protected $fillable = ['owner','content','article_id'];
}
