<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ProductResource;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function getCart()
    {
        try {
            $data = Cart::where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product In Cart', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'qty' => 'integer',
            ]);
            $productInCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if ($productInCart) {
                $productInCart->qty += ($request->qty ? $request->qty : 1);
                $productInCart->save();
            } else {
                $cart = new Cart();
                $cart->user_id = Auth::id();
                $cart->product_id = $request->product_id;
                $cart->qty = $request->qty;
                $cart->save();
            }
            $data = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product added to cart successfully', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function removeProductInCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'qty' => 'integer',
            ]);
            $productInCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if ($productInCart && $productInCart->qty <= 1) {
                $productInCart->delete();
            } else {
                $productInCart->qty -= ($request->qty ? $request->qty : 1);
                $productInCart->save();
            }
            $data = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product deleted from cart successfully', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function removeItemInCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
            ]);
            $productInCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if ($productInCart) {
                $productInCart->delete();
            }
            $data = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product deleted from cart successfully', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function companiesInCart()
    {
        try {
            $data = Cart::where('user_id', Auth::id())->get()->pluck('product_id');
            $products = Product::whereIn('id', $data)->get()->pluck('company_id');
            $companies = Company::whereIn('id', $products)->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Companies In Cart', 'data' => CompanyResource::collection($companies)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function productsCompanyInCart($id)
    {
        try {
            $data = Cart::where('user_id', Auth::id())->get()->pluck('product_id');
            $products = Product::whereIn('id', $data)->where('company_id', $id)->get();
            $productInCart = Cart::whereIn('product_id', $products->pluck('id'))->get();
            $sub_total = [];
            // foreach ($productInCart as $pro) {
            //     dd($products);
            //     $sub_total[] = $pro->qty * $pro->product->price;
            // }
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Products In Cart', 'data' => ProductResource::collection($products)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}