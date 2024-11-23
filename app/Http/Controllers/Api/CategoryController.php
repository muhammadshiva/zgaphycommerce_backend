<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $category = Category::withCount('artwork')->orderBy('artwork_count', 'desc')->paginate();

        return response()->json(
            [
                'success' => true,
                'message' => 'Get all categories',
                'data' => $category,
            ]
        );
    }
}
