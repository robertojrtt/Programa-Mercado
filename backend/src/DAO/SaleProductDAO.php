<?php

namespace App\DAO;

use App\Config\Connection;
use App\DTO\SaleProductDTO;

class SaleProductDAO
{
    static function create(SaleProductDTO $saleProduct)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("INSERT INTO sales_products (sale_id, product_id, quantity) VALUES (?,?,?)");
        $stmt->bindValue(1, $saleProduct->getSaleId(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $saleProduct->getProductId(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $saleProduct->getQuantity(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    static function update(SaleProductDTO $saleProduct)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("UPDATE sales_products SET product_id=?, quantity=? where id=? LIMIT 1");
        $stmt->bindValue(1, $saleProduct->getProductId(), \PDO::PARAM_STR);
        $stmt->bindValue(2, $saleProduct->getQuantity(), \PDO::PARAM_STR);
        $stmt->bindValue(3, $saleProduct->getId(), \PDO::PARAM_STR);
        $stmt->execute();
    }

    static function delete($saleProductID)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("DELETE FROM sales_products WHERE id=? LIMIT 1");
        $stmt->bindValue(1, $saleProductID, \PDO::PARAM_INT);
        $stmt->execute();
    }

    static function getAll()
    {
        $db = Connection::getConnection();
        $str = "SELECT 
                sales_products.id,
                sales_products.quantity,
                sales.id as sales_id, 
                sales.date as sales_date,
                sales.amount as sales_amount,
                sales.amount as sales_tax_amount,
                products.id as products_id,
                products.title as products_title,
                products.description as products_description,
                products.price as products_price,
                categories.title as categories_title,
                categories.tax as categories_tax
            FROM sales_products
            INNER JOIN products on products.id = sales_products.product_id
            INNER JOIN sales on sales.id = sales_products.sale_id
            LEFT JOIN categories on categories.id = products.category_id
    
            ";
        $stmt = $db->query($str);
        $stmt->setFetchMode(\PDO::FETCH_NAMED);
        $saleProducts = $stmt->fetchAll();

        return $saleProducts;
    }

    static function getOnly($id)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare("SELECT 
            sales_products.id,
            sales_products.quantity,
            sales.id as sales_id, 
            sales.date as sales_date,
            sales.amount as sales_amount,
            sales.amount as sales_tax_amount,
            products.id as products_id,
            products.title as products_title,
            products.description as products_description,
            products.price as products_price,
            categories.title as categories_title,
            categories.tax as categories_tax
            FROM sales_products
            INNER JOIN products on products.id = sales_products.product_id
            INNER JOIN sales on sales.id = sales_products.sale_id
            LEFT JOIN categories on categories.id = products.category_id
            WHERE sales_products.sale_id = ?");
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_NAMED);
        $saleProducts = $stmt->fetchAll();

        return $saleProducts;
    }
}
