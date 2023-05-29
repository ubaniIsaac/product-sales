<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products = Product::latest()->paginate(7)->through(fn ($product) => new ProductResource($product));

        return response()->json([
            'data' => $products,
            'status' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json([
            'message' => "Product uploaded",
            'data' => $product,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $product)
    {
        try {
            //code...
            $product = Product::findOrFail($product);
            return response()->json([
                'message' => "product showed successfully",
                'data' => new ProductResource($product),
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "Product with this id not found ",
                'status' => 404
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $product)
    {
        try {
            $product = Product::find($product);

            $product->update([
                'title' => $request->title,
                'description' => $request->description
            ]);

            return response()->json([
                'message' => "product Updated successfully",
                'data' => $product,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "No product with this Id was found ",
                'status' => 404
            ]);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => "Product delete successfully",
            'data' => $product,
            'status' => 200
        ]);
    }
}
