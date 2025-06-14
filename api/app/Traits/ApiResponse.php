<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;

trait ApiResponse {

    protected function responseSuccess(mixed $data = null, ?string $message = null, ?Paginator $paginator = null): JsonResponse
    {
        $response = [
            'code' => Response::HTTP_OK,
            'message' => $message ?? "ok",
            'data' => $data,
        ];

        if ($paginator) {
            $response['pagination'] = [
                'current_page' => $paginator->currentPage(),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
                'has_more_pages' => $paginator->hasMorePages()
            ];
        }

        return response()->json($response, Response::HTTP_OK);
    }

    protected function responseCreated(mixed $data = null, ?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_CREATED,
            'message' => $message ?? "created",
            'data' => $data,
        ], Response::HTTP_CREATED);
    }

    protected function responseUpdated(mixed $data = null, ?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message ?? "updated",
            'data' => $data,
        ], Response::HTTP_OK);
    }

    protected function responseDeleted(?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message ?? "deleted",
        ], Response::HTTP_OK);
    }

    protected function responseNotFound(?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_NOT_FOUND,
            'message' => $message ?? "not found",
        ], Response::HTTP_NOT_FOUND);
    }

    protected function responseUnauthorized(?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => $message ?? "not found",
        ], Response::HTTP_UNAUTHORIZED);
    }

    protected function responseInternalServerError(): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => "internal server error",
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
