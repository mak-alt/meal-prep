<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SeoHeadMetaDataComposer
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private Collection $seoData;

    /**
     * SeoHeadMetaDataComposer constructor.
     */
    public function __construct()
    {
        $this->seoData = $this->getSeoData();
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('seoData', $this->seoData);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function getSeoData(): Collection
    {
        $seoKeys          = collect(['seo_title', 'seo_description', 'seo_keywords']);
        $appName          = config('app.name');
        $seoDefaultValues = [
            'seo_title'       => config('app.name'),
            'seo_description' => "$appName - Fresh, local & healthy meals delivered to your door.",
            'seo_keywords'    => null,
        ];

        $seoData = collect(Setting::whereIn('key', $seoKeys)
            ->get(['key', 'data'])
            ->groupBy('key')
            ->whenEmpty(function (Collection $seoData) use ($appName, $seoDefaultValues) {
                foreach ($seoDefaultValues as $key => $seoDefaultValue) {
                    $seoData->put($key, $seoDefaultValue);
                }

                return $seoData;
            })
            ->map(function ($item) {
                if ($item instanceof Collection && !empty($item->first())) {
                    return $item->first()->data;
                }

                return $item;
            })
        );
        $seoKeys->map(function (string $key) use ($seoData, $seoDefaultValues) {
            if (!in_array($key, $seoData->keys()->toArray())) {
                $seoData->put($key, $seoDefaultValues[$key]);
            }
        });

        $seoData->each(function (?string $value, string $key) use ($seoData) {
            unset($seoData[$key]);
            $seoData->put(Str::replaceFirst('seo_', '', $key), $value);
        });

        return $seoData;
    }
}
