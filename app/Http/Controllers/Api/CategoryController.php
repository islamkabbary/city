<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\BrandHasCategory;
use App\Models\CompanyHasCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {  
        try {
            $data =  Category::all();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => CategoryResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function show($id)
    {
        try {
            $data = Category::findOrFail($id);
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => new CategoryResource($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function allCompaniesinStreet($id)
    {
        try {
            $catCompanies = CompanyHasCategory::where('category_id', $id)->get();
            $companies = [];
            foreach ($catCompanies as $company) {
                $companies[] = Company::findOrFail($company->company_id);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => $companies], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function allCategoriesInCompanies($id)
    {
        try {
            $catCompanies = CompanyHasCategory::where('company_id', $id)->get();
            $data = [];
            foreach ($catCompanies as $category) {
                $data[] = Category::findOrFail($category->category_id);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function allBrandInCategories($id)
    {
        try {
            $brandCompanies = BrandHasCategory::where('category_id', $id)->get();
            $data = [];
            foreach ($brandCompanies as $category) {
                $data[] = Brand::findOrFail($category->brand_id);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function allProductsInBrand($id)
    {
        try {
            $data = Product::where('brand_id', $id)->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => $data], Response::HTTP_OK);
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
}
