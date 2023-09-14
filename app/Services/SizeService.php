<?php
namespace App\Services;

use App\Models\Size;
use Exception;
use Illuminate\Support\Facades\Log;

class SizeService {
    
    protected $dataTableService;

    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService = $dataTableService;
    }
    public function getSizesJson()
    {
        try {
            $sizes = Size::select(['name']);
            return $this->dataTableService->generateDataTable($sizes);
        } catch(Exception $e){
            Log::error('An erro occured at:' . $e->getMessage());
        }
    }

}