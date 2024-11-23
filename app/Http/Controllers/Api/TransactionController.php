<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\Store;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private function _fullyBookedChecker(Store $request) {}
}
