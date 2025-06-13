<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse {

    protected function success(mixed $data = null, ?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message ?? "ok",
            'data' => $data,
        ], Response::HTTP_OK);
    }

    protected function created(mixed $data = null, ?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message ?? "created",
            'data' => $data,
        ], Response::HTTP_CREATED);
    }

    protected function updated(mixed $data = null, ?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message ?? "updated",
            'data' => $data,
        ], Response::HTTP_OK);
    }

    protected function deleted(?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message ?? "deleted",
        ], Response::HTTP_OK);
    }

    protected function notFound(?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message ?? "not found",
        ], Response::HTTP_NOT_FOUND);
    }

    protected function unauthorized(?string $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message ?? "not found",
        ], Response::HTTP_UNAUTHORIZED);
    }
}