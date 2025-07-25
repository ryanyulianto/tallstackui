<?php

it('can render basic command')
    ->expect('<x-command><x-command.content><x-command.content.item>Settings</x-command.content.item></x-command.content></x-command>')
    ->render()
    ->toContain('Settings');

it('can render with search')
    ->expect('<x-command searchable><x-command.content><x-command.content.item>Settings</x-command.content.item></x-command.content></x-command>')
    ->render()
    ->toContain('Settings');

it('can render with header slot')
    ->expect('<x-command header="Custom Header"><x-command.content><x-command.content.item>Settings</x-command.content.item></x-command.content></x-command>')
    ->render()
    ->toContain('Settings')
    ->toContain('Custom Header');

it('can render with content groups')
    ->expect('<x-command><x-command.content group="System"><x-command.content.item>Settings</x-command.content.item></x-command.content></x-command>')
    ->render()
    ->toContain('Settings')
    ->toContain('System');

it('can render content item with href')
    ->expect('<x-command><x-command.content><x-command.content.item href="/settings">Settings</x-command.content.item></x-command.content></x-command>')
    ->render()
    ->toContain('Settings')
    ->toContain('href="/settings"');

it('can render content item with icon')
    ->expect('<x-command><x-command.content><x-command.content.item icon="cog">Settings</x-command.content.item></x-command.content></x-command>')
    ->render()
    ->toContain('Settings');

it('can render content item with shortcut')
    ->expect('<x-command><x-command.content><x-command.content.item shortcut="⌘S">Settings</x-command.content.item></x-command.content></x-command>')
    ->render()
    ->toContain('Settings')
    ->toContain('⌘S');