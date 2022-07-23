<?php

namespace App\Http\Controllers;

use App\Repositories\ShareData\IShareDataRepository;
use Illuminate\Http\Request;

class ShareDataController extends BaseController
{
    public function __construct(IShareDataRepository $shareDataRepository)
    {
        parent::__construct($shareDataRepository);
    }

    public function index($taskId)
    {
        return parent::findAll('task_id', $taskId);
    }

    public function saveShareData(Request $request, $taskId)
    {
        return parent::create($request, $taskId);
    }

    public function deleteShareData($taskId)
    {
        return parent::delete($taskId);
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['task_id'] = $fieldValue;
        return $data;
    }
}