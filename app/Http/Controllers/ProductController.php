<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Barcode;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->init();
        $this->middlewareInit();
    }

    public function index()
    {
        $products = Product::with(['unit','category'])->paginate(APP_PAGINATE);
        return $this->view(compact('products'));
    }

    public function create():View
    {
        $units       = Unit::get();
        $categories  = Category::all();
        return $this->view(compact('units','categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $product = Product::createProduct($request);

            Barcode::createBarcode($product->id, $request->input('barcode'));

            $Stock   = new Stock();
            $Stock->product_id     = $product->id;
            $Stock->warehouse_id   = MASTER_WAREHOUSE;

            if ($Stock->save() == false)
            {
                throw new Exception('error_create_product',APP_ERROR);
            }

            DB::commit();
            $this->success('success_add');
            return redirect()->route('product.index');

        }catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }

    public function edit(Product $product)
    {
        $units       = Unit::get();
        $categories  = Category::all();
        return $this->view(compact('product','categories','units'));
    }

    public function show(Product $product)
    {
        return $this->view(compact('product'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
           $res = $product->update($request->except('barcode'));

            if ($res == false)
            {
                throw new Exception('error_update',APP_ERROR);
            }

            Barcode::updateBarcode($product,$request->input('barcode'));

            DB::commit();
            $this->success('success_update');
            return redirect()->route('product.index');
        }catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }


    public function getProduct(Request $request)
    {
        return Product::getProduct($request);
    }
}
