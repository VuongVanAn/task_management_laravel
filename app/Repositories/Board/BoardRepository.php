<?php


namespace App\Repositories\Board;


use App\Board;
use App\Repositories\BaseRepository;
use App\User;
use Illuminate\Support\Facades\DB;

class BoardRepository extends BaseRepository implements IBoardRepository
{

    public function getModel()
    {
        return Board::class;
    }

    public function customFunc($id, $fieldCustom)
    {
        parent::customFunc($id, $fieldCustom);
        $board = $this->model->find($id);

        if ($fieldCustom == 'productivity') {
            $board->users = User::select('id', 'name')->get();

            $board->tasks = DB::table("boards")
                ->join('lists', 'boards.id', '=', 'lists.board_id')
                ->join('tasks', 'lists.id', '=', 'tasks.lists_id')
                ->join('share_data', 'tasks.id', '=', 'share_data.task_id')
                ->select('share_data.user_id', 'tasks.status')
                ->where('boards.id', '=', $id)
                ->get();
        } else {
            $board->tasks = DB::table("boards")
                ->join('lists', 'boards.id', '=', 'lists.board_id')
                ->join('tasks', 'lists.id', '=', 'tasks.lists_id')
                ->select('tasks.title', 'tasks.expected_date', 'tasks.dead_line', 'tasks.status')
                ->where('boards.id', '=', $id)
                ->get();
        }

        return $board;
    }
}