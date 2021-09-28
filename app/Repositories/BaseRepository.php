<?php


namespace App\Repositories;


abstract class BaseRepository implements IBaseRepository
{
    /**
     * Model muốn tương tác
     */
    protected $model;

    /**
     * Khởi tạo
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Lấy model tương ứng
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function findAll($fieldName, $fieldValue)
    {
        return $this->model->select('*')
            ->where($fieldName, '=', $fieldValue)
            ->get();
    }

    public function findOne($id)
    {
        return $this->model->find($id);
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    public function delete($id)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->delete($id);
            return true;
        }
        return false;
    }
}