<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Models\Product;
use App\Models\CompanyHasCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Symfony\Component\HttpFoundation\Response;


class CompanyController extends Controller
{
    public function allCompaniesinStreet($id)
    {
        try {
            $catCompanies = CompanyHasCategory::where('category_id', $id)->get();
            $companies = [];
            foreach ($catCompanies as $company) {
                $companies[] = Company::findOrFail($company->company_id);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => CompanyResource::collection($companies)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}
