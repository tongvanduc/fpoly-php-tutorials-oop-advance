<?php

namespace App\Models;

use App\Model;

class User extends Model
{
    protected $tableName = 'users';

    public function checkExistsEmailForCreate($email)
    {
        // Khởi tạo QueryBuilder
        $queryBuilder = $this->connection->createQueryBuilder();

        // Tạo query kiểm tra sự tồn tại của email
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('email = :email')
            ->setParameter('email', $email);

        // Thực thi query và lấy kết quả
        $result = $queryBuilder->fetchOne();

        // Kiểm tra nếu số lượng lớn hơn 0, tức là email đã tồn tại
        return $result > 0;
    }

    public function checkExistsEmailForUpdate($id, $email)
    {
        // Khởi tạo QueryBuilder
        $queryBuilder = $this->connection->createQueryBuilder();

        // Tạo query kiểm tra sự tồn tại của email
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('email = :email')
            ->andWhere('id != :id')  // Điều kiện id khác với giá trị id được cung cấp
            ->setParameter('email', $email)
            ->setParameter('id', $id);

        // Thực thi query và lấy kết quả
        $result = $queryBuilder->fetchOne();

        // Kiểm tra nếu số lượng lớn hơn 0, tức là email đã tồn tại
        return $result > 0;
    }

    public function getUserByEmail($email)
    {
        // Khởi tạo QueryBuilder
        $queryBuilder = $this->connection->createQueryBuilder();

        // Tạo query kiểm tra sự tồn tại của email
        $queryBuilder->select('*')
            ->from($this->tableName)
            ->where('email = :email')
            ->setParameter('email', $email);

        // Thực thi query và lấy kết quả
        $result = $queryBuilder->fetchAssociative();

        return $result;
    }
}
