{{-- Progress Meter Component --}}
@props([
    'title' => 'Progress',
    'percentage' => 0,
    'completed' => 0,
    'total' => 0,
    'description' => '',
    'period' => '',
    'icon' => 'heroicon-o-chart-bar',
    'id' => 'progress-meter-' . uniqid()
])

@php
    // Calculate dynamic values
    $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
    $remaining = $total - $completed;
    
    // Determine status
    $statusText = '';
    $statusEmoji = '';
    $statusColor = '';
    
    if ($percentage >= 100) {
        $statusText = 'Pencatatan Selesai';
        $statusEmoji = '✅';
        $statusColor = 'text-green-600 dark:text-green-400';
    } elseif ($percentage >= 75) {
        $statusText = 'Hampir Selesai';
        $statusEmoji = '🔵';
        $statusColor = 'text-blue-600 dark:text-blue-400';
    } elseif ($percentage >= 50) {
        $statusText = 'Sedang Progress';
        $statusEmoji = '🟡';
        $statusColor = 'text-yellow-600 dark:text-yellow-400';
    } else {
        $statusText = 'Perlu Perhatian';
        $statusEmoji = '🔴';
        $statusColor = 'text-red-600 dark:text-red-400';
    }
@endphp

<div id="{{ $id }}" class="progress-meter-container" data-percentage="{{ $percentage }}">
    {{-- Header --}}
    <div class="progress-meter-header">
        <div class="progress-meter-title">
            <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ $title }}
        </div>
        
        <div class="progress-meter-percentage {{ $statusColor }}">
            <span class="status-icon">{{ $statusEmoji }}</span>
            <span class="percentage-number">0%</span>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div class="progress-bar-container">
        <div class="progress-bar" style="width: 0%;">
            <div class="progress-text">0%</div>
        </div>
    </div>

    {{-- Status Info --}}
    @if($description || $period)
        <div class="progress-info-text">
            @if($description)
                {{ $description }}
            @endif
            @if($period)
                <br><strong>Periode:</strong> {{ $period }}
            @endif
        </div>
    @endif

    {{-- Progress Details --}}
    <div class="progress-details">
        <div class="progress-detail-card">
            <div class="progress-detail-number text-green-600 dark:text-green-400">
                {{ number_format($completed, 0, ',', '.') }}
            </div>
            <div class="progress-detail-label text-green-700 dark:text-green-300">
                Selesai
            </div>
        </div>
        
        <div class="progress-detail-card">
            <div class="progress-detail-number text-orange-600 dark:text-orange-400">
                {{ number_format($remaining, 0, ',', '.') }}
            </div>
            <div class="progress-detail-label text-orange-700 dark:text-orange-300">
                Tersisa
            </div>
        </div>
    </div>

    {{-- Additional Info --}}
    <div class="mt-4 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }} bg-opacity-10">
            <span class="mr-2">{{ $statusEmoji }}</span>
            {{ $statusText }}
        </span>
    </div>

    {{-- Status Badge for Total --}}
    <div class="mt-3 text-center text-sm text-gray-600 dark:text-gray-400">
        <strong>{{ number_format($completed, 0, ',', '.') }}</strong> dari 
        <strong>{{ number_format($total, 0, ',', '.') }}</strong> pelanggan
    </div>
</div>

{{-- Styles and Scripts --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/progress-meter.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/progress-meter.js') }}"></script>
@endpush
