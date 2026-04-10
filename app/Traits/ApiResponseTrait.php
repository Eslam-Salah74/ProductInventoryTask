<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{
    protected $response = [
        'status' => true,
        'message' => '',
        'data' => null,
        'code' => 200,
    ];

    public function isOk($message = '')
    {
        $this->response['status'] = true;
        $this->response['message'] = $message;
        $this->response['code'] = 200;
        return $this;
    }

    public function isError($message = '')
    {
        $this->response['status'] = false;
        $this->response['message'] = $message;
        $this->response['code'] = 400;
        return $this;
    }

    public function setData($data)
    {
        $this->response['data'] = $data;
        return $this;
    }

    public function setStatus($code)
    {
        $this->response['code'] = $code;
        return $this;
    }

    public function build()
    {
        return response()->json([
            'status' => $this->response['status'],
            'message' => $this->response['message'],
            'data' => $this->response['data'],
        ], $this->response['code']);
    }

    public function api_model_set_paginate($resource, $data)
    {
        return [
            'items' => $resource,
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ]
        ];
    }
}
