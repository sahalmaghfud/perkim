<div class="flex flex-col sm:flex-row justify-between sm:items-start py-3">
    <span class="text-sm font-medium text-slate-600 w-full sm:w-1/3 mb-1 sm:mb-0">{{ $label }}</span>
    <span
        class="text-sm text-slate-900 font-semibold text-left sm:text-right w-full sm:w-2/3
        {{ isset($isCurrency) && $isCurrency ? 'font-mono' : '' }}
        {{ isset($isTotal) && $isTotal ? 'text-lg text-emerald-600' : '' }}">
        {{ $value ?? '—' }}
    </span>
</div>
