<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function __invoke(Request $request): void
    {
        dd('Secure Credit Card Controller');
    }
}
