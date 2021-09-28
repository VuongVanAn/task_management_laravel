<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = "attachments";

    protected $fillable = [
        'content', 'card_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
