@php
    $personalize = $classes();
@endphp

<div class="{{ $personalize['wrapper'] }}"
     data-command-group="{{ $group }}"
     {{ $attributes->except(['class']) }}>
    
    @if ($group)
        <div class="{{ $personalize['group.wrapper'] }}">
            <div class="{{ $personalize['group.title'] }}">
                {{ ucfirst($group) }}
            </div>
        </div>
    @endif
    
    {!! $slot !!}
</div>