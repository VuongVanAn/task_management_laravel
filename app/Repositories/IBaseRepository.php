<?php


namespace App\Repositories;


interface IBaseRepository
{
    /**
     * Lấy lên tất cả dữ liệu
     */
    public function findAll($fieldName, $fieldValue);

    /**
     * @param $id
     * Lấy lên chi tiết dữ liệu
     */
    public function findOne($id);

    /**
     * @param array $attributes
     * Thêm mới dữ liệu
     */
    public function create($attributes = []);

    /**
     * @param $id
     * @param array $attributes
     * Cập nhật dữ liệu
     */
    public function update($id, $attributes = []);

    /**
     * @param $id
     * Xóa dữ liệu
     */
    public function delete($id);
}