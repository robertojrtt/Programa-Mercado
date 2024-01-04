<?php

namespace App\Service;

use App\DAO\SaleDAO;
use App\DAO\SaleProductDAO;
use App\DTO\SaleDTO;
use App\DTO\SaleProductDTO;
use App\Service\InterfaceService;
use DateTime;

class SaleService implements InterfaceService
{
    static function getAll()
    {
        $sales = SaleProductDAO::getAll();

        if (empty($sales)) return [];

        $sales = self::formatDataSales($sales);

        return json_encode($sales);
    }

    static function getOnly(string $id)
    {
        $sales = SaleProductDAO::getOnly($id);

        if (empty($sales)) return false;

        $sales = self::formatDataSales($sales);

        return json_encode($sales);
    }

    static function create(array $params)
    {
        $date = new DateTime();
        $sale = new SaleDTO();
        $sale->setDate($date->format("Y-m-d H:i:s"));
        $sale->setId(SaleDAO::create($sale));

        $amount = 0;
        $tax_amount = 0;
        foreach ($params['itens'] as $key => $param) {
            $tax = ($param['price'] * $param['tax']) / 100;
            $price = $param['price'] - $tax;
            $quantity = $param['quantity'];

            $itemAmount = $price * $quantity;
            $itemTaxAmount = $tax * $quantity;

            $amount += $itemAmount;
            $tax_amount += $itemTaxAmount;

            $saleProduct = new SaleProductDTO($sale->getId(), $param['product'], $quantity);
            SaleProductDAO::create($saleProduct);
        }
        $sale->setAmount($amount);
        $sale->setTaxAmount($tax_amount);
        SaleDAO::update($sale);
    }

    static function update(string $id,  array $params)
    {
    }

    static function delete(string $id)
    {
        SaleDAO::delete($id);
    }

    static function formatDataSales(array $sales)
    {
        $newArray = null;

        foreach ($sales as $sale) {

            if (!isset($newArray[$sale['sales_id']])) {

                $newArray[$sale['sales_id']] = [
                    'id' => $sale['sales_id'],
                    'amount' => $sale['sales_amount'],
                    'tax_amount' => $sale['sales_tax_amount'],
                    'date' => $sale['sales_date'],
                    'items' => [],
                ];
            }
            $newArray[$sale['sales_id']]['items'][] = [
                'sales_products' => $sale['id'],
                'products_id' => $sale['products_id'],
                'products_title' => $sale['products_title'],
                'products_description' => $sale['products_description'],
                'products_price' => $sale['products_price'],
                'categories_title' => $sale['categories_title'],
                'categories_tax' => $sale['categories_tax']
            ];
        }

        return array_values($newArray);
    }
}
