<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Size;
use Illuminate\Http\Request;
use App\Services\SizeService;
use App\Http\Requests\SizeRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function add(SizeRequest $request)
    {
        $validated = $request->validated();
        return $this->sizeService->addSize($validated['size']);
    }

    public function edit(Size $size)
    {
        return $this->sizeService->editSize($size);
    }

    public function update(Size $size, SizeRequest $request)
    {
        $validated = $request->validated();
        return $this->sizeService->updateSize($size, $validated['size']);
    }

    public function delete(Size $size)
    {
        return $this->sizeService->deleteSize($size);
    }
}