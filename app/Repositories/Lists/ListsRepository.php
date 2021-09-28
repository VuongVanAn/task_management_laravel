<?php


namespace App\Repositories\Lists;


use App\Lists;
use App\Repositories\BaseRepository;
use App\Task;

class ListsRepository extends BaseRepository implements IListsRepository
{

    public function getModel()
    {
        return Lists::class;
    }

    public function getLists($boardId)
    {
        $list = $this->model->select('id', 'title', 'board_id')
            ->where('board_id', '=', $boardId)
            ->get();

        for ($i = 0; $i < count($list); $i++) {
            $list_id = $list[$i]->id;
            $list[$i]->card = Task::where('lists_id', '=', $list_id)
                ->select('id', 'title', 'dead_line', 'status')
                ->get();
        }
        return $list;
    }
}