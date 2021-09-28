<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    protected $table = "checklists";

    protected $fillable = [
        'name', 'list_checklist', 'task_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
