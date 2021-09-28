<?php

namespace App\Http\Controllers;

use App\Repositories\Task\ITaskRepository;
use Illuminate\Http\Request;

class TaskController extends BaseController
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
        parent::__construct($taskRepository);
    }

    public function index($id, $listId)
    {
        return parent::findAll('lists_id', $listId);
    }

    public function findOne($id, $listId, $taskId)
    {
        $result = $this->taskRepository->getOne($taskId);
        if ($result) {
            return response()->json(['data' => $result]);
        }
        return response()->json([], 204);
    }

    public function saveCard(Request $request, $id, $listId)
    {
        return parent::create($request, $listId);
    }

    public function updateCard(Request $request, $id, $listId, $taskId)
    {
        return parent::update($request, $taskId);
    }

    public function deleteCard($id, $listId, $taskId)
    {
        return parent::delete($taskId);
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['lists_id'] = $fieldValue;
        return $data;
    }
}