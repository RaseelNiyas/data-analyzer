<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelData extends Model
{
    protected $fillable = ['file_data'];

    // Accessor to get dynamic column value
    public function getColumnValueAttribute($column)
    {
        return $this->attributes['file_data'][$column] ?? null;
    }

    // Mutator to set dynamic column value
    public function setColumnValueAttribute($column, $value)
    {
        $fileData = $this->attributes['file_data'];
        $fileData[$column] = $value;
        $this->attributes['file_data'] = $fileData;
    }

}
