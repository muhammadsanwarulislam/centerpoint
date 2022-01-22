<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Response;

trait JsonResponseTrait
{
    public function json($message, $data = [], $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function error($message, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json([
            'message' => $message
        ], $statusCode);
    }

    public function bad($message, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'message' => $message
        ], $statusCode);
    }

}
