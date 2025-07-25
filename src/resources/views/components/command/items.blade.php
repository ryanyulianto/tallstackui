@php
    $personalize = $classes();
    $isLink = !empty($href);
    $tag = $isLink ? 'a' : 'button';
    $attributes = $isLink ? $attributes->merge(['href' => $href]) : $attributes;
@endphp

<div class="{{ $personalize['wrapper'] }}">
    <{{ $tag }}
        class="{{ $personalize['item.base'] }}"
        data-command-item
        data-href="{{ $href }}"
        data-default="{{ $default ? 'true' : 'false' }}"
        data-searchable="true"
        x-on:click="selectItem($el)"
        x-on:mousemove="handleMouseMove($el)"
        {{ $attributes->except(['class']) }}>
        
        @if ($icon)
            @if ($position === 'left')
                <x-dynamic-component :component="TallStackUi::prefix('icon')"
                                     :$icon
                                     internal
                                     class="{{ $personalize['icon'] }}" />
            @endif
        @endif
        
        <span class="flex-1 text-left">
            {!! $slot !!}
        </span>
        
        @if ($shortcut)
            <span class="{{ $personalize['shortcut'] }}">
                {{ $shortcut }}
            </span>
        @endif
        
        @if ($icon && $position === 'right')
            <x-dynamic-component :component="TallStackUi::prefix('icon')"
                                 :$icon
                                 internal
                                 class="{{ $personalize['icon'] }}" />
        @endif
    </{{ $tag }}>
</div>
