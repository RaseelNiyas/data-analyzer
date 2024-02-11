<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class DataImport implements ToCollection
{
    protected $data;

    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }

    public function getData()
    {
        return $this->data;
    }
}
