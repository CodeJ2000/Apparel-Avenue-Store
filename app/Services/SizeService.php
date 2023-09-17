<?php
namespace App\Services;

use Exception;
use App\Models\Size;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SizeService {
    
    protected $dataTableService;

    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService = $dataTableService;
    }
    public function getSizesJson()
    {
        try {
            $sizes = Size::select(['id', 'name']);
            return $this->dataTableService->generateDataTable($sizes);
        } catch(Exception $e){
            Log::error('An erro occured at:' . $e->getMessage());
        }
    }

    public function addSize($validatedSize)
    {
        try {
            $size = Size::create([
                'name' => $validatedSize
            ]);
            if(!$size){
                return response()->json(['errors' => 'Oops! Failed to added!'], 500);
            }
            return response()->json(['message' => 'Successfuly added!'], 201);
        }catch (Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
            return response()->json(['errors' => 'Oops! Something went wrong!'], 500);
        }
    }

    public function editSize($size)
    {
        try {
            if(!$size){
                throw new NotFoundHttpException();
            }
            return response()->json($size);
        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }

    public function updateSize($size, $validatedInput)
    {
        try {
            if(!$size){
                throw new NotFoundHttpException();
            }
            $size->name = $validatedInput;
            if(!$size->save()){
                return response()->json(['errors' => 'Oops! The size did update'], 500);
            }
            return response()->json(['message' => 'Successfuly updated'], 201);
        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
            return response()->json(['errors' => 'Oops! Something went wrong!'], 500);
        }
    }

    public function deleteSize($size)
    {
        try {
            if(!$size){
                throw new NotFoundHttpException();
            }
            $size->delete();
            return response()->json(['message' => 'Successfuly deleted!']);
        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.']);
        }
    }
}