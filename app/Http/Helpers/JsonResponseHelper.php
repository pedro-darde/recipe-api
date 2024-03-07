<?php

namespace App\Http\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class JsonResponseHelper
{
    private static string  $internalServerErrorMessage = 'Internal server error. Contact admin.';
    static function success(array $data): JsonResponse {
        return response()->json($data);
    }
    static function successWithPagination(Collection $data, string $modelClass): JsonResponse
    {
        $request = request();
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 0);

        return self::success(
            [
                'rows' => $data,
                'page' => $page,
                'per_page' => $perPage,
                'total' => $modelClass::count(),
            ]
        );
    }

    static function modelSaved(string $modelName): JsonResponse
    {
        return self::success([
            'message' => "$modelName saved successfully."
        ]);
    }

    static function serverError(\Exception $ex, $message = '', $logError = true): JsonResponse
    {
        if (empty($message)) {
            $message = self::$internalServerErrorMessage;
        }

        if ($logError) {
            Log::error($ex);
        }

        return response()->json(compact('message'), 500);
    }

}