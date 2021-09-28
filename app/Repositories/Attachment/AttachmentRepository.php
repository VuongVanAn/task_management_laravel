<?php


namespace App\Repositories\Attachment;


use App\Attachment;
use App\Repositories\BaseRepository;

class AttachmentRepository extends BaseRepository implements IAttachmentRepository
{

    public function getModel()
    {
        return Attachment::class;
    }
}