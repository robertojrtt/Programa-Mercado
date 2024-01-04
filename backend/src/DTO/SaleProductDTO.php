<?php

namespace App\DTO;

use App\DTO\AbstractDTO;

class SaleProductDTO extends AbstractDTO
{
    protected $id;
    protected $sale_id;
    protected $product_id;
    protected $quantity;

    public function __construct($sale_id, $product_id, $quantity)
    {
        $this->sale_id = $sale_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSaleId()
    {
        return $this->sale_id;
    }

    public function setSaleId($sale_id)
    {
        $this->sale_id = $sale_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}
