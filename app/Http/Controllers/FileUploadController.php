<?php

namespace App\Http\Controllers;

use App\Http\Requests\Frontend\Files\DeleteFileRequest;
use App\Http\Requests\Frontend\Files\FileUploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    private const GENERAL_FILE_UPLOAD_DIR = 'public/uploads';

    /**
     * @param \App\Http\Requests\Frontend\Files\FileUploadRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(FileUploadRequest $request)
    {
        $uploadPath = !empty($request->path)
            ? self::GENERAL_FILE_UPLOAD_DIR . '/' . $request->path
            : self::GENERAL_FILE_UPLOAD_DIR;

        $uploadedPath = Storage::putFile($uploadPath, $request->file('file'));

        if ($request->has('filepond')) {
            return $uploadedPath ? Storage::url($uploadedPath) : '';
        }

        $responseData = $uploadedPath
            ? $this->formatResponse('success', 'File has been successfully uploaded.', [
                'path' => Storage::url($uploadedPath),
            ])
            : $this->formatResponse('error', 'Failed to upload file.');

        return response()->json($responseData);
    }

    /**
     * @param \App\Http\Requests\Frontend\Files\DeleteFileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteFileRequest $request): JsonResponse
    {
        $path = $request->has('path')
            ? $request->path
            : Str::replaceFirst('/storage', '/public', $request->getContent());

        if (empty($path)) {
            throw new \InvalidArgumentException('File path has not been provided.');
        }

        Storage::delete($path);

        return response()->json($this->formatResponse('success', 'File has been successfully deleted.'));
    }
}
