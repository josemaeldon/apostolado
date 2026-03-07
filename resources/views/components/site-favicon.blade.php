@php
    $version = null;
    $faviconUrl = route('site.favicon');

    try {
        $favicon = \App\Models\SiteSetting::get('favicon');

        if ($favicon) {
            $updatedAt = \App\Models\SiteSetting::query()
                ->where('key', 'favicon')
                ->value('updated_at');

            $version = $updatedAt ? strtotime((string) $updatedAt) : null;
            $faviconUrl = route('site.favicon', $version ? ['v' => $version] : []);
        } else {
            $fallbackPath = public_path('favicon.ico');
            $version = file_exists($fallbackPath) ? filemtime($fallbackPath) : null;
            $faviconUrl = route('site.favicon', $version ? ['v' => $version] : []);
        }
    } catch (\Throwable $e) {
        $faviconUrl = asset('favicon.ico');
    }
@endphp

<link rel="icon" href="{{ $faviconUrl }}" sizes="any">
<link rel="shortcut icon" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">
<meta name="theme-color" content="#ffffff">
