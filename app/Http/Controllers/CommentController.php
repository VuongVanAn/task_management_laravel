<?php

namespace App\Http\Controllers;

use App\Repositories\Comment\ICommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{
    public function __construct(ICommentRepository $commentRepository)
    {
        parent::__construct($commentRepository);
    }

    public function index($id, $listId, $taskId)
    {
        return parent::findAll('task_id', $taskId);
    }

    public function findOne($id, $listId, $taskId, $commentId)
    {
        return parent::findById($commentId);
    }

    public function saveComment(Request $request, $id, $listId, $taskId)
    {
        return parent::create($request, $taskId);
    }

    public function updateComment(Request $request, $id, $listId, $taskId, $commentId)
    {
        return parent::update($request, $commentId);
    }

    public function deleteComment($id, $listId, $taskId, $commentId)
    {
        return parent::delete($commentId);
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['task_id'] = $fieldValue;
        $data['user_id'] = Auth::user()->id;
        return $data;
    }
}
