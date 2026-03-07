@php
    $faviconUrl = null;

    try {
        $favicon = \App\Models\SiteSetting::get('favicon');

        if ($favicon) {
            $updatedAt = \App\Models\SiteSetting::query()
                ->where('key', 'favicon')
                ->value('updated_at');

            $version = $updatedAt ? strtotime((string) $updatedAt) : null;
            $faviconUrl = \App\Helpers\ImageHelper::storageUrl($favicon);
            $faviconUrl = $version ? $faviconUrl . '?v=' . $version : $faviconUrl;
        }
    } catch (\Throwable $e) {
        $faviconUrl = null;
    }
@endphp

@if($faviconUrl)
    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $faviconUrl }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
@endif
