@props(['status'])

@php
    $status = strtolower($status);
    $classes = match($status) {
        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
        'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
        default => 'bg-slate-100 text-slate-800 border-slate-200',
    };
    
    $labels = [
        'pending' => __('Chờ xác nhận'),
        'confirmed' => __('Đã xác nhận'),
        'completed' => __('Đã hoàn thành'),
        'cancelled' => __('Đã hủy'),
    ];
    
    $label = $labels[$status] ?? ucfirst($status);
@endphp

<span {{ $attributes->merge(['class' => "px-2.5 py-0.5 rounded-full text-xs font-medium border $classes"]) }}>
    {{ $label }}
</span>