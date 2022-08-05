<?php

namespace App\Http\Controllers;

use App\Repositories\ShareData\IShareDataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function deleteShareData(Request $request, $taskId)
    {
        $result = DB::table('share_data')->where('user_id', $request->user_id)
                    ->where('task_id', $taskId)
                    ->delete();
        if ($result) {
            return response()->json(['message' => 'Xóa thành công']);
        }
        return response()->json(['message' => 'Có lỗi xảy ra'], 400);
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['task_id'] = $fieldValue;
        return $data;
    }
}