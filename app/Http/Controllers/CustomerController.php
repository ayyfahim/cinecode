<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function home()
    {
        return redirect()->route('customer.shop');
    }
}
