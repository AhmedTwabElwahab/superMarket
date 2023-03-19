<?php

namespace App\Http\Interfaces;

use App\Models\Journal;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

interface InvoiceFunc
{
    public function getDetailInstance();
    public function description();
    public function doctype();

}
