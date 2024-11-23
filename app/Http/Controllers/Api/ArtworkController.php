<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index(): JsonResponse
    {

        $artwork = Artwork::with(['category', 'stock'])->paginate();

        return response()->json([
            'success' => true,
            'message' => 'Get all artworks successfully',
            'data' => $artwork,
        ]);
    }

    public function show(Artwork $artwork): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Get detail artwork successfully',
            'data' => $artwork,
        ]);
    }
}
