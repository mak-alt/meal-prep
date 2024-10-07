<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    use HasFactory;

    public const BASE_FILE_UPLOAD_DIR = 'public/uploads/pages';

    public const STATUSES = [
        'published' => 'published',
        'hidden'    => 'hidden',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_static',
        'title',
        'sub_title',
        'content',
        'data',
        'seo_title',
        'seo_description',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_static' => 'boolean',
        'data'      => 'array',
    ];

    /**
     * @param array $data
     * @return bool
     */
    public function updatePage(array $data): bool
    {
        if ($this->name === 'Partners') {
            $uploadDir = self::BASE_FILE_UPLOAD_DIR . DIRECTORY_SEPARATOR . $this->id;

            foreach ($data['data']['local_partners']['items'] as $index => &$localPartners) {
                $oldLocalPartnersImageUploadedPath = $this->data['local_partners']['items'][$index]['image'] ?? null;

                if (isset($localPartners['image']) && $localPartners['image'] instanceof UploadedFile) {
                    if ($oldLocalPartnersImageUploadedPath) {
                        Storage::delete($oldLocalPartnersImageUploadedPath);
                    }
                    $localPartnersImageUploadedPath = Storage::url(Storage::putFile($uploadDir, $localPartners['image']));

                    $localPartners['image'] = $localPartnersImageUploadedPath;
                } else {
                    $localPartners['image'] = $oldLocalPartnersImageUploadedPath;
                }
            }
        }

        if ($this->name === 'galleryAndReviews') {
            if (!empty($data['data']['gallery']['items'])) {
                $newGalleryItems                  = collect($data['data']['gallery']['items'])->map(function (string $uploadGalleryItemPath) {
                    return ['image' => $uploadGalleryItemPath];
                })->toArray();
                $data['data']['gallery']['items'] = array_merge($this->data['gallery']['items'] ?? [], $newGalleryItems);
            } else {
                $data['data']['gallery']['items'] = $this->data['gallery']['items'] ?? [];
            }
            if (!empty($data['data']['reviews']['items'])) {
                $newReviews                       = collect($data['data']['reviews']['items'])->map(function (string $uploadReviewPath) {
                    return ['image' => $uploadReviewPath];
                })->toArray();
                $data['data']['reviews']['items'] = array_merge($this->data['reviews']['items'] ?? [], $newReviews);
            } else {
                $data['data']['reviews']['items'] = $this->data['reviews']['items'] ?? [];
            }
        }

        return $this->update($data);
    }

    /**
     * @param string $path
     * @param string $key
     * @return bool
     */
    public function deleteDataFile(string $path, string $key): bool
    {
        Storage::delete($path);

        if ($this->name === 'galleryAndReviews') {
            $filteredData = collect($this->data[$key]['items'])->map(function (array $data) use ($path) {
                if ($data['image'] === $path) {
                    unset($data);
                    return null;
                }

                return $data;
            })->filter()->toArray();
        }

        if (isset($filteredData)) {
            $data = $this->data;
            $data[$key]['items'] = $filteredData;

            $this->update(['data' => $data]);
        }

        return true;
    }
}
