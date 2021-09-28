<?php


namespace App\Repositories\CheckList;


use App\Repositories\IBaseRepository;
use Illuminate\Http\Request;

interface ICheckListRepository extends IBaseRepository
{
    public function updateCheckList(Request $request, $id);
}