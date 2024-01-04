<?php

namespace App\DAO;

use App\Config\Connection;
use App\DTO\SaleDTO;

class SaleDAO
{
    static function create(SaleDTO $sale)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("INSERT INTO sales (date) VALUES (?)");
        $stmt->bindValue(1, $sale->getDate(), \PDO::PARAM_STR);
        $stmt->execute();
        return $db->lastInsertId();
    }

    static function update(SaleDTO $sale)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("UPDATE sales SET amount=?, tax_amount=? where id=? LIMIT 1");
        $stmt->bindValue(1, $sale->getAmount(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $sale->getTaxAmount(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $sale->getId(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    static function delete($saleID)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("DELETE FROM sales WHERE id=? LIMIT 1");
        $stmt->bindValue(1, $saleID, \PDO::PARAM_INT);
        $stmt->execute();
    }

    static function getAll()
    {
        $db = Connection::getConnection();
        $str = "SELECT * FROM sales";
        $stmt = $db->query($str);
        $stmt->setFetchMode(\PDO::FETCH_NAMED);
        $sales = $stmt->fetchAll();
        return $sales;
    }

    static function getOnly($id)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("SELECT * FROM sales WHERE id = ?");
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\DTO\SaleDTO');
        $sale = $stmt->fetch();

        return $sale;
    }
}
