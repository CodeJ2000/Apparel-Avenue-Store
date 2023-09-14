<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Services\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    protected $sizeService;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function getSizes()
    {
        $sizes = Size::all();
        return response()->json($sizes);
    }

    public function displaySizeDataTable()
    {
        return $this->sizeService->getSizesJson();
    }


}