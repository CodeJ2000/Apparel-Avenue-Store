<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();

            Category::create([
                'name' => $validated['name'] 
            ]);

            return response()->json(['message' => 'Successfuly added']);
        } catch (Exception $e) {
            Log::error('An error occured: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{

            $category = Category::findOrFail($id);

            if(!$category){
                throw new Exception("Category not found");
            }
            return response()->json($category);

        }catch(Exception $e){
            Log::error('An error occured: ' . $e->getMessage());

            return response()->json(['message' => 'Error occured in editting cataegory']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            
            $validated = $request->validated();

            $category = Category::findOrFail($id);

            $category->name = $validated['name'];
            $category->save();

            return response()->json(['message' => 'Successfuly updated']);

        } catch(Exception $e){
            Log::error('An error occured: ' . $e->getMessage());
            return response()->json(['message' => 'There is an error updating the category']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
           $category = Category::findOrFail($id);
            
           if(!$category){
            throw new Exception("Category you want to delete not found in our records");
           }
           $category->delete();           
        } catch(Exception $e){
            Log::error('An error occured: ' . $e->getMessage());
        }
    }

    public function categoriesDataTable()
    {
        try {
            $categories = Category::select(['id', 'name']);

        // return DataTables::eloquent($categories)->json();
            return DataTables::eloquent($categories)->toJson(); 
        } catch (Exception $e){
            Log::error('An error occured: ' . $e->getMessage());
        }
    }

    public function getCategories()
    {   
        try {
            $categories = Category::query()->select('id', 'name', 'created_at')->get();

            if($categories){
                return response()->json(['data' => $categories]);
            }
            return response()->json(['message' => 'There is no category.']); 
        } catch (Exception $e){
            Log::error('An error occured: ' . $e->getMessage());
           
        }

    }

}