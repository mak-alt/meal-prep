<?php

namespace App\Http\Controllers\Backend\Traits;

use App\Http\Requests\Backend\CalculatePointsRequest;
use Illuminate\Http\JsonResponse;

trait PointsCalculation
{
    /**
     * @param \App\Http\Requests\Backend\CalculatePointsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculatePoints(CalculatePointsRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            return response()->json($this->formatResponse('success', null, [
                'points' => ($request->price ?? 1) * 10]),
            );
        }
    }
}
