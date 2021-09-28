<?php

namespace App\Http\Controllers;

use App\Repositories\Attachment\IAttachmentRepository;
use Illuminate\Http\Request;

class AttachmentController extends BaseController
{
    public function __construct(IAttachmentRepository $attachmentRepository)
    {
        parent::__construct($attachmentRepository);
    }

    public function index($id, $listId, $cardId)
    {
        return parent::findAll('card_id', $cardId);
    }

    public function findOne($id, $listId, $taskId, $attachmentId)
    {
        return parent::findById($attachmentId);
    }

    public function saveAttachment(Request $request, $id, $listId, $cardId)
    {
        return parent::create($request, $cardId);
    }

    public function updateAttachment(Request $request, $id, $listId, $taskId, $attachmentId)
    {
        return parent::update($request, $attachmentId);
    }

    public function deleteAttachment($id, $listId, $taskId, $attachmentId)
    {
        return parent::delete($attachmentId);
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['card_id'] = $fieldValue;
        return $data;
    }
}