<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class BackCell extends Cell
{
    public $backLinkBase; // Change from private to public
    public $backLink;

    public function mount()
    {
        if (isset($this->backLink)) {
            $this->backLinkBase = base_url($this->backLink);
        } else {
            $this->backLinkBase = 'javascript:history.back()';
        }
    }
}
