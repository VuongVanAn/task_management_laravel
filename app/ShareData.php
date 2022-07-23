<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareData extends Model
{
    protected $table = "share_data";

    protected $fillable = [
        'user_id', 'task_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
