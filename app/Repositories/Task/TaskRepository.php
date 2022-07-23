<?php


namespace App\Repositories\Task;


use App\Attachment;
use App\CheckList;
use App\Comment;
use App\Repositories\BaseRepository;
use App\Task;
use App\User;

class TaskRepository extends BaseRepository implements ITaskRepository
{

    public function getModel()
    {
        return Task::class;
    }

    public function getOne($id)
    {
        $card = $this->model->find($id);

        $card->members = User::where('id', '=', $card->user_id)
            ->select('name')->get();

        $card->check_lists = CheckList::where('task_id', '=', $id)
            ->select('id', 'list_checklist', 'name')->get();

        $card->comments = Comment::where('task_id', '=', $id)
            ->select('*')->get();

        $card->attachment = Attachment::where('card_id', '=', $id)
            ->select('id', 'content')->get();

        return $card;
    }
}