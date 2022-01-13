<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\GetCategoryResource;
use App\Services\CategoryService;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();        
    
        return response()->json(['status' => 'success', 
                                'data' => GetCategoryResource::collection($categories)],
                                Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->storeCategory($request->title, $request->eid);

        return response()->json(['status' => 'success'], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json(['status' => 'success', 
                                'data' => GetCategoryResource::make($category)],
                                Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->title, $request->eid);

        return response()->json(['status' => 'success'], Response::HTTP_OK);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
    
        return response()->json(['status' => 'success'], Response::HTTP_OK);   
    }
}
