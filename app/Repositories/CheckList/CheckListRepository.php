<?php


namespace App\Repositories\CheckList;


use App\CheckList;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class CheckListRepository extends BaseRepository implements ICheckListRepository
{

    public function getModel()
    {
        return CheckList::class;
    }

    public function updateCheckList(Request $request, $id)
    {
        $checklist = $this->model->find($id);
        $checklist->name = $request->name;
        $checklist->list_checklist = json_encode($request->list_checklist);
        return $checklist->save();
    }
}