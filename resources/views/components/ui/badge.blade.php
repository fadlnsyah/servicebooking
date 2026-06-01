@props(['value', 'label' => null])

<span {{ $attributes->class(['inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 '.booking_status_classes($value)]) }}>
    {{ $label ?? \Illuminate\Support\Str::headline($value) }}
</span>
