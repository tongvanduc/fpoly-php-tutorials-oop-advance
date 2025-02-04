<?php

namespace App\Models;

use App\Model;

class Category extends Model
{
    protected $tableName = 'categories';

    public function checkExistsNameForCreate($name)
    {
        // Khởi tạo QueryBuilder
        $queryBuilder = $this->connection->createQueryBuilder();

        // Tạo query kiểm tra sự tồn tại của name
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('name = :name')
            ->setParameter('name', $name);

        // Thực thi query và lấy kết quả
        $result = $queryBuilder->fetchOne();

        // Kiểm tra nếu số lượng lớn hơn 0, tức là name đã tồn tại
        return $result > 0;
    }

    public function checkExistsNameForUpdate($id, $name)
    {
        // Khởi tạo QueryBuilder
        $queryBuilder = $this->connection->createQueryBuilder();

        // Tạo query kiểm tra sự tồn tại của name
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('name = :name')
            ->andWhere('id != :id')  // Điều kiện id khác với giá trị id được cung cấp
            ->setParameter('name', $name)
            ->setParameter('id', $id);

        // Thực thi query và lấy kết quả
        $result = $queryBuilder->fetchOne();

        // Kiểm tra nếu số lượng lớn hơn 0, tức là name đã tồn tại
        return $result > 0;
    }
}
