<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ActivityHistoryCell extends Cell
{
    protected $dateTime;
    private $date;
    private $time;

    public function mount()
    {
        $this->date = date('Y-m-d', strtotime($this->dateTime));
        $this->time = date("H:i:s", strtotime($this->dateTime));

        if (!cache()->get("loggedin")) {
            cache()->save("loggedin", $this->dateTime, 300);
        } else {
            $this->dateTime = cache()->get("loggedin");
        }
    }
    public function getDateTimeProperty()
    {
        return $this->dateTime;
    }

    public function getDateProperty()
    {
        return $this->date;
    }

    public function getTimeProperty()
    {
        return $this->time;
    }
}
