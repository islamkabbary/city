<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\CompanyHasCategory;
use App\Http\Controllers\Controller;
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

    public function allCategoriesInCompanies($id)
    {
        try {
            $catCompanies = CompanyHasCategory::where('company_id', $id)->get();
            $data = [];
            foreach ($catCompanies as $category) {
                $data[] = Category::findOrFail($category->category_id);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => CategoryResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}
