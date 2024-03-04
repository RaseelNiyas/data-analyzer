<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Data extends Model
{
    protected $table = 'excel_data'; // Replace with your actual table name

    // Define any hidden attributes if needed
    protected $hidden = [];

    // The fillable array will be dynamically set in the constructor
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the fillable array based on the actual columns in the table
        $this->fillable = $this->getFillableColumns();
    }

    protected function getFillableColumns()
    {
        $columns = Schema::getColumnListing($this->getTable());
        return array_diff($columns, $this->hidden);
    }
}
