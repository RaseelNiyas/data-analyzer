<?php

// app/Models/DynamicData.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicData extends Model
{
    use HasFactory;

    protected $fillable = ['data']; // 'data' is a default column

    // Method to dynamically set fillable columns
    public function setFillableColumns($columns)
    {
        $this->fillable = array_merge(['data'], $columns);
    }
}
