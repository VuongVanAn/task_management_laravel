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

    /**
     * @param $fieldName
     * @param $fieldValue
     * @return mixed
     * Lấy dữ liệu theo field
     */
    public function findAll($fieldName, $fieldValue)
    {
        return $this->model->select('*')
            ->where($fieldName, '=', $fieldValue)
            ->get();
    }

    /**
     * @param $id
     * @return mixed
     * Lấy lên dữ liệu bản ghi
     */
    public function findOne($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $attributes
     * @return mixed
     * Khởi tạo model
     */
    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @return false
     * Cập nhật dữ liệu
     */
    public function update($id, $attributes = [])
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     * Xóa dữ liệu
     */
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