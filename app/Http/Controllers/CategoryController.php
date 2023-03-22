<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
     public function __construct()
     {
         $this->init();
         $this->middlewareInit();
     }

    public function index(Request $request)
    {
        $categories = Category::paginate(APP_PAGINATE);
        return $this->view(compact('categories'));
    }

    public function create()
    {
       return $this->view();
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $category = new Category($request->all());

            if ($category->save() == false)
            {
                throw new Exception('error',APP_ERROR);
            }

            DB::commit();
            $this->success('success_add');
            return redirect()->route('category.index');

        }catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('category.index');
        }
    }

    public function edit(Category $category)
    {
       return $this->view(compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $category->update($request->all());

            if ($category->save() == false)
            {
                throw new Exception('error',APP_ERROR);
            }

            DB::commit();
            $this->success('success_update');
            return redirect()->route('category.index');
        }catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            if ($category->products->isNotEmpty())
            {
                throw new Exception('delete_error' ,APP_ERROR);
            }

            if ($category->delete() == false)
            {
                throw new Exception('delete_error' ,APP_ERROR);
            }
            DB::commit();
            $this->success('success_delete');
            return redirect()->route('category.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }
}
