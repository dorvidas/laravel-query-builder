<?php

namespace Dorvidas\QueryBuilder\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = 'posts';

    protected $guarded = [];

    public function comments(){
        return $this->morphMany(CommentModel::class, 'commentable');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
}