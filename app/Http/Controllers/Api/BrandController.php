<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\BrandHasCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use Symfony\Component\HttpFoundation\Response;


class BrandController extends Controller
{
    public function allBrandInCategories($id)
    {
        try {
            $brandCompanies = BrandHasCategory::where('category_id', $id)->get();
            $data = [];
            foreach ($brandCompanies as $category) {
                $data[] = Brand::findOrFail($category->brand_id);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => BrandResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}
