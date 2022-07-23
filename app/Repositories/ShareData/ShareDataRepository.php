<?php


namespace App\Repositories\ShareData;


use App\Repositories\BaseRepository;
use App\ShareData;

class ShareDataRepository extends BaseRepository implements IShareDataRepository
{

    public function getModel()
    {
        return ShareData::class;
    }
}