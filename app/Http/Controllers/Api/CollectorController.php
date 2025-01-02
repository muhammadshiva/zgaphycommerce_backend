<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectorController extends Controller
{
    public function index(): JsonResponse
    {

        $artworks = Collector::select('artwork_id')
            ->with('artwork')
            ->groupBy('artwork_id')
            ->selectRaw('artwork_id, COUNT(*) as collector_count')
            ->orderByDesc('collector_count')
            ->get();

        $artworks = $artworks->map(function ($item) {
            return [
                'artwork' => $item->artwork,
                'collector_count' => $item->collector_count,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Get artworks sorted by collector count successfully',
            'data' => $artworks,
        ]);
    }


    public function show(Collector $collector): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Get detail collector successfully',
            'data' => $collector,
        ]);
    }

    public function listByArtwork(int $artwork_id): JsonResponse
    {
        $collectors = Collector::with('artwork')
            ->where('artwork_id', $artwork_id)
            ->get();

        if ($collectors->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No collectors found for the specified artwork',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get collectors by artwork successfully',
            'data' => $collectors,
        ]);
    }
}
