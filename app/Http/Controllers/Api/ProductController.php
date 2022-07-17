<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function allProductsInBrand($id)
    {
        try {
            $data = Product::where('brand_id', $id)->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => ProductResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function productDetails($id)
    {
        try {
            $data = Product::find($id);
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => new ProductResource($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function allProductsInCompany($id)
    {
        try {
            $data = Product::where('company_id', $id)->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => ProductResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}
