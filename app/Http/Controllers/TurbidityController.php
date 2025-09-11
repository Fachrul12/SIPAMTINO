<?php

namespace App\Http\Controllers;

use App\Models\Turbidity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TurbidityController extends Controller
{
    /**
     * Get the latest turbidity data for real-time monitoring
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatest()
    {
        try {
            $latest = Turbidity::latest('recorded_at')->first();
            
            if (!$latest) {
                return response()->json([
                    'success' => false,
                    'message' => 'No turbidity data available'
                ], 404);
            }
            
            // Determine status based on turbidity value
            $turbidity = $latest->turbidity;
            $status = '';
            $statusColor = '';
            $statusDescription = '';
            
            if ($turbidity <= 5) {
                $status = 'Sangat Baik';
                $statusColor = 'green';
                $statusDescription = 'Aman dikonsumsi';
            } elseif ($turbidity <= 25) {
                $status = 'Baik';
                $statusColor = 'yellow';
                $statusDescription = 'Layak konsumsi';
            } elseif ($turbidity <= 50) {
                $status = 'Sedang';
                $statusColor = 'orange';
                $statusDescription = 'Perlu penyaringan';
            } else {
                $status = 'Perlu Perhatian';
                $statusColor = 'red';
                $statusDescription = 'Perlu treatment';
            }
            
            // Calculate quality percentage (inverse of turbidity)
            $qualityPercentage = min(100, max(0, 100 - ($turbidity * 2)));
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $latest->id,
                    'turbidity' => $latest->turbidity,
                    'status' => $status,
                    'statusColor' => $statusColor,
                    'statusDescription' => $statusDescription,
                    'qualityPercentage' => $qualityPercentage,
                    'recordedAt' => $latest->recorded_at->format('H:i'),
                    'recordedDate' => $latest->recorded_at->format('d M Y'),
                    'timestamp' => $latest->recorded_at->timestamp,
                    'created_at' => $latest->created_at,
                    'updated_at' => $latest->updated_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching turbidity data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get turbidity data history with optional pagination
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistory(Request $request)
    {
        try {
            $limit = $request->get('limit', 50);
            $page = $request->get('page', 1);
            
            $turbidities = Turbidity::orderBy('recorded_at', 'desc')
                ->paginate($limit);
            
            return response()->json([
                'success' => true,
                'data' => $turbidities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching turbidity history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
