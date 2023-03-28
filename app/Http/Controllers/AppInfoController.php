<?php

namespace App\Http\Controllers;

use App\Models\AppInfo;
use Illuminate\Http\Request;

class AppInfoController extends Controller
{
    public function __construct()
    {
        $this->init();
        $this->middlewareInit();
    }

    /**
     * @param AppInfo $appInfo
     * @return void
     *
     * TODO:edit method
     * TODO:update method
     * TODO:view files
     *
     *
     */
    public function edit(AppInfo $appInfo)
    {
        dd($appInfo);
    }

    public function update(Request $request, AppInfo $appInfo)
    {
        //
    }

}
