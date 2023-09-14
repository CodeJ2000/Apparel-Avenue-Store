<?php
namespace App\Services;

use Yajra\DataTables\Facades\DataTables;


class DataTableService {

    //Generate the data table
    public function generateDataTable($query)
    {
        return DataTables::eloquent($query)
        ->toJson();
    }
}