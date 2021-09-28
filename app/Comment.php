<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";

    protected $fillable = [
        'content', 'user_id', 'task_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
