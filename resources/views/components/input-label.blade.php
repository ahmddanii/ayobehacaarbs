@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs text-slate-700 dark:text-slate-350 uppercase tracking-wider mb-2']) }}>
    {{ $value ?? $slot }}
</label>
