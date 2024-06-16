<?php

namespace App\Http\Controllers;

use App\Models\Position;

class PositionController extends Controller
{
    function listPositions()
    {
        $allPositions = Position::all(['id', 'name']);

        // Check if position exists
        if ($allPositions->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => "Positions not found",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'positions' => $allPositions,
        ]);
    }
}
