@php
    $personalize = $classes();
@endphp

<div class="{{ $personalize['wrapper'] }}"
     x-data="tallstackui_command(@js($searchable), @js($personalize['content.active']), @js($personalize['content.inactive']))"
     x-on:keydown="handleKeydown($event)"
     data-command-id="{{ $id }}"
     x-cloak
     {{ $attributes->except(['class']) }}>
    <div class="{{ $personalize['container'] }}"
         style="max-height: {{ $maxHeight }}px; min-height: {{ $minHeight }}px;">
        
        @if ($searchable)
            <div class="{{ $personalize['search.wrapper'] }}">
                <x-dynamic-component :component="TallStackUi::prefix('icon')"
                                     :icon="TallStackUi::icon('magnifying-glass')"
                                     internal
                                     class="{{ $personalize['search.icon'] }}" />
                <input type="text"
                       x-ref="searchInput"
                       x-model="search"
                       x-on:input="filterItems()"
                       class="{{ $personalize['search.input'] }}"
                       placeholder="{{ $placeholder }}"
                       autocomplete="off"
                       autocorrect="off"
                       spellcheck="false">
            </div>
        @endif

        @if ($header)
            <div class="{{ $personalize['header.wrapper'] }}">
                {!! $header !!}
            </div>
        @endif

        <div x-ref="itemsList"
             class="{{ $personalize['content.wrapper'] }}"
             style="max-height: {{ $searchable ? $maxHeight - 60 : $maxHeight }}px;">
            {!! $slot !!}
        </div>
    </div>
</div>