<?php

namespace App\Http\Controllers;

use App\Repositories\CheckList\ICheckListRepository;
use Illuminate\Http\Request;

class CheckListController extends BaseController
{
    protected $checkListRepository;

    public function __construct(ICheckListRepository $checkListRepository)
    {
        $this->checkListRepository = $checkListRepository;
        parent::__construct($checkListRepository);
    }

    public function index($id, $listId, $taskId)
    {
        return parent::findAll('task_id', $taskId);
    }

    public function saveCheckList(Request $request, $id, $listId, $taskId)
    {
        return parent::create($request, $taskId);
    }

    public function findOne($id, $listId, $taskId, $checkListId)
    {
        return parent::findById($checkListId);
    }

    public function updateCheckList(Request $request, $id, $listId, $taskId, $checkListId)
    {
        $result = $this->checkListRepository->updateCheckList($request, $checkListId);
        if ($result) {
            return response()->json(['message' => 'Cập nhật thành công']);
        }
        return response()->json(['message' => 'Có lỗi xảy ra'], 400);
    }

    public function deleteCheckList($id, $listId, $taskId, $checkListId)
    {
        return parent::delete($checkListId);
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['task_id'] = $fieldValue;
        return $data;
    }
}
