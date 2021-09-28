<?php

namespace App\Http\Controllers;

use App\Repositories\Lists\IListsRepository;
use Illuminate\Http\Request;

class ListsController extends BaseController
{
    protected $listsRepository;

    public function __construct(IListsRepository $listsRepository)
    {
        $this->listsRepository = $listsRepository;
        parent::__construct($listsRepository);
    }

    public function index($boardId)
    {
        $result = $this->listsRepository->getLists($boardId);
        if ($result) {
            return response()->json(['data' => $result]);
        }
        return response()->json([], 204);
    }

    public function findOne($id, $listId)
    {
        return parent::findById($listId);
    }

    public function saveList(Request $request, $boardId)
    {
        return parent::create($request, $boardId);
    }

    public function updateList(Request $request, $id, $listId)
    {
        return parent::update($request, $listId);
    }

    public function deleteList($id, $listId)
    {
        return parent::delete($listId);
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['board_id'] = $fieldValue;
        return $data;
    }
}