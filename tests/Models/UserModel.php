<?php

namespace Dorvidas\QueryBuilder\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $guarded = [];

    protected $table = 'users';

    public function posts(){
        return $this->hasMany(PostModel::class, 'user_id');
    }
}