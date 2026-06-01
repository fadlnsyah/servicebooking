@props(['label', 'value', 'hint' => null])

<x-ui.card class="p-6">
    <p class="text-sm font-semibold text-slate-500">{{ $label }}</p>
    <p class="mt-4 text-3xl font-extrabold text-slate-950">{{ $value }}</p>
    @if($hint)
        <p class="mt-2 text-sm text-slate-500">{{ $hint }}</p>
    @endif
</x-ui.card>
