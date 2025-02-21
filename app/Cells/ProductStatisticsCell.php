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

        if (!cache()->get("product-statistics")) {
            cache()->save("product-statistics", $this->statistics, 3600);
        } else {
            $this->statistics = cache()->get("product-statistics");
        }
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
