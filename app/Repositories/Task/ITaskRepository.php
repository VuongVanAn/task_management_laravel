<?php


namespace App\Repositories\Task;


use App\Repositories\IBaseRepository;

interface ITaskRepository extends IBaseRepository
{
    public function getOne($id);
}