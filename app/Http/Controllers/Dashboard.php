<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;

class Dashboard extends Controller
{
   public function index(): View
   {
       $this->init();
       return $this->view();
   }
}
