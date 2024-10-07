<?php

namespace App\Traits;

trait FormatResponse
{
    /**
     * @param $status
     * @param null $message
     * @param null $data
     * @return array
     */
    protected function formatResponse($status, $message = null, $data = null): array
    {
        return [
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ];
    }
}
