<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ProductStatisticsCell extends Cell
{
    protected $productStock;
    protected $productPrice;
    private $statistics;

    public function mount()
    {
        $this->statistics = ($this->productPrice * $this->productStock) / 100;
    }

    public function getProductStockProperty()
    {
        return $this->productStock;
    }

    public function getProductPriceProperty()
    {
        return $this->productPrice;
    }

    public function getStatisticsProperty()
    {
        return $this->statistics;
    }
}
