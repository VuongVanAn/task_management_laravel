<?php

namespace App\Http\Controllers;

use App\Repositories\Board\IBoardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends BaseController
{
    public function __construct(IBoardRepository $boardRepository)
    {
        parent::__construct($boardRepository);
    }

    public function index()
    {
        $userId = $this->getUserId();
        return parent::findAll('user_id', $userId);
    }

    public function findOne($id)
    {
        return parent::findById($id);
    }

    public function saveBoard(Request $request)
    {
        return parent::create($request);
    }

    public function updateBoard(Request $request, $id)
    {
        return parent::update($request, $id);
    }

    public function deleteBoard($id)
    {
        return parent::delete($id);
    }

    public function productivityBoard(Request $request) {
        return parent::customFunc($request->id, 'productivity');
    }

    public function progressBoard(Request $request) {
        return parent::customFunc($request->id, 'progress');
    }

    protected function beforeSave(Request $request, $fieldValue)
    {
        $data = $request->all();
        $data['user_id'] = $this->getUserId();
        return $data;
    }

    private function getUserId()
    {
        return Auth::user()->id;
    }
}