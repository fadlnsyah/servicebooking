@props(['title', 'description'])

<x-ui.card class="p-10 text-center">
    <h3 class="text-xl font-bold text-slate-950">{{ $title }}</h3>
    <p class="mt-3 text-sm text-slate-500">{{ $description }}</p>
    {{ $slot }}
</x-ui.card>
