<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ColorTextCell extends Cell
{
    protected $text;
    private $color;

    public function mount()
    {
        if (strtolower($this->text) === 'available' || strtolower($this->text) === 'active') {
            $this->color = 'primary';
        } elseif (strtolower($this->text) === 'limited') {
            $this->color = 'warning'; // Default color for other statuses
        } elseif (strtolower($this->text) === 'new') {
            $this->color = 'success'; // Default color for other statuses
        } else {
            $this->color = 'danger';
        }
    }

    public function getTextProperty()
    {
        return $this->text;
    }
    public function getColorProperty()
    {
        return $this->color;
    }
}
