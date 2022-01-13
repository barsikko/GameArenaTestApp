<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\GetProductResource;
use App\Product;
use App\Services\ProductService;
use Illuminate\Http\Response;


class ProductsController extends Controller
{

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();        
    
        return response()->json(['status' => 'success', 
                                'data' => GetProductResource::collection($products)],
                                Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $this->productService->storeProduct($request->title, 
                                                $request->eid,
                                                    $request->category_ids,
                                                        $request->price);

        return response()->json(['status' => 'success'], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(['status' => 'success', 
                                'data' => GetProductResource::make($product)],
                                Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->updateProduct($product,
                                                $request->title, 
                                                    $request->eid,
                                                        $request->category_ids,
                                                            $request->price);

        return response()->json(['status' => 'success'], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['status' => 'success'], Response::HTTP_OK);
    }
}
