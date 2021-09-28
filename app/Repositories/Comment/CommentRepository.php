<?php


namespace App\Repositories\Comment;


use App\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements ICommentRepository
{

    public function getModel()
    {
        return Comment::class;
    }
}