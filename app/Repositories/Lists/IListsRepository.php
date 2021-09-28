<?php


namespace App\Repositories\Lists;


use App\Repositories\IBaseRepository;

interface IListsRepository extends IBaseRepository
{
    public function getLists($boardId);
}