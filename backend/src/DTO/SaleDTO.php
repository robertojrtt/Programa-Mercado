<?php

namespace App\DTO;

use App\DTO\AbstractDTO;

class SaleDTO extends AbstractDTO
{
    protected $id;
    protected $date;
    protected $amount;
    protected $taxAmount;
    protected $salesProduct;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = round($amount, 2);
    }

    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = round($taxAmount, 2);
    }

    public function getSalesProduct()
    {
        return $this->salesProduct;
    }

    public function setSalesProduct($salesProduct)
    {
        $this->salesProduct = $salesProduct;
    }
}
