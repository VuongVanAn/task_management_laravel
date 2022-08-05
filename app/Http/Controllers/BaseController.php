<?php

namespace App\Http\Controllers;

use App\Repositories\IBaseRepository;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $baseRepository;

    public function __construct(IBaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function findAll($fieldName, $fieldValue)
    {
        $data = $this->baseRepository->findAll($fieldName, $fieldValue);
        if ($data) {
            return response()->json(['data' => $data]);
        }
        return response()->json([], 204);
    }

    public function findById($id)
    {
        $data = $this->baseRepository->findOne($id);
        if ($data) {
            return response()->json(['data' => $data]);
        }
        return response()->json([], 204);
    }

    public function create(Request $request, $fieldValue = null)
    {
        $data = $this->beforeSave($request, $fieldValue);
        $result = $this->baseRepository->create($data);
        if ($result) {
            return response()->json(['data' => $result], 201);
        }
        return response()->json(['message' => 'Có lỗi xảy ra'], 400);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        //Validation here...
        $result = $this->baseRepository->update($id, $data);

        if ($result) {
            return response()->json(['data' => $result]);
        }
        return response()->json(['message' => 'Có lỗi xảy ra'], 400);
    }

    public function delete($id)
    {
        $result = $this->baseRepository->delete($id);
        if ($result) {
            return response()->json(['message' => 'Xóa thành công']);
        }
        return response()->json(['message' => 'Có lỗi xảy ra'], 400);
    }

    abstract protected function beforeSave(Request $request, $fieldValue);

    public function customFunc($id, $fieldCustom)
    {
        $result = $this->baseRepository->customFunc($id, $fieldCustom);
        if ($result) {
            return response()->json(['data' => $result]);
        }
        return response()->json(['message' => 'Có lỗi xảy ra'], 400);
    }
}