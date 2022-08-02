<?php


namespace App\Repositories\Task;


use App\Attachment;
use App\CheckList;
use App\Comment;
use App\Repositories\BaseRepository;
use App\ShareData;
use App\Task;
use App\User;
use Illuminate\Support\Facades\DB;

class TaskRepository extends BaseRepository implements ITaskRepository
{

    public function getModel()
    {
        return Task::class;
    }

    public function getOne($id)
    {
        $card = $this->model->find($id);

        $card->members = User::select('id', 'name', 'email')->get();

        $card->check_lists = CheckList::where('task_id', '=', $id)
            ->select('id', 'list_checklist', 'name')->get();

        $card->comments = Comment::where('task_id', '=', $id)
            ->select('*')->get();

        $card->attachment = Attachment::where('card_id', '=', $id)
            ->select('id', 'content')->get();

        $card->users = DB::table("share_data")
            ->join('users', 'users.id', '=', 'share_data.user_id')
            ->select('share_data.id', 'share_data.user_id', 'users.name')
            ->where('share_data.task_id', '=', $id)
            ->get();

        return $card;
    }
}