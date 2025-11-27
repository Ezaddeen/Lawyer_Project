@php
    $brandName = filament()->getBrandName();
    $brandLogo = filament()->getBrandLogo();
    $brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $getLogoClasses = fn (bool $isDarkMode): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-logo',
        'flex items-center gap-2',
        'flex dark:hidden' => $hasDarkModeBrandLogo && (! $isDarkMode),
        'hidden dark:flex' => $hasDarkModeBrandLogo && $isDarkMode,
    ]);

    $logoStyles = "height: {$brandLogoHeight}";
@endphp

@capture($content, $logo, $isDarkMode = false)
    @if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
        <div
            {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
                    ->style([$logoStyles])
            }}
        >
            {{ $logo }}
            @if (filled($brandName))
                <span class="ml-2 text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ $brandName }}
                </span>
            @endif
        </div>
    @elseif (filled($logo))
        <div
            {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
            }}
        >
            <img
                alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
                src="{{ $logo }}"
                style="{{ $logoStyles }}"
                class="h-auto"
            />
            @if (filled($brandName))
                <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ $brandName }}
                </span>
            @endif
        </div>
    @else
        <div
            {{
                $attributes->class([
                    $getLogoClasses($isDarkMode),
                    'text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white',
                ])
            }}
        >
            {{ $brandName }}
        </div>
    @endif
@endcapture

{{ $content($brandLogo) }}

@if ($hasDarkModeBrandLogo)
    {{ $content($darkModeBrandLogo, isDarkMode: true) }}
@endif
