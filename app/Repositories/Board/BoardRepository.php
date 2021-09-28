<?php


namespace App\Repositories\Board;


use App\Board;
use App\Repositories\BaseRepository;

class BoardRepository extends BaseRepository implements IBoardRepository
{

    public function getModel()
    {
        return Board::class;
    }
}