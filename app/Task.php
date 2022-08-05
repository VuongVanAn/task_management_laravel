<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";

    protected $fillable = [
        'title', 'description', 'attachment',
        'dead_line', 'lists_id', 'status', 'expected_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function list()
    {
        return $this->belongsTo(Lists::class);
    }

}
