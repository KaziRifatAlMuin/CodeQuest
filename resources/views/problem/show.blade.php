@php
    $rating = (int) ($problem->rating ?? 0);
    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
    $themeBg = \App\Helpers\RatingHelper::getRatingBgColor($rating);
    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
@endphp

<x-layout>
    <x-slot:title>{{ $problem->title }} - CodeQuest</x-slot:title>

    <!-- Problem Header with Rating Theme -->
    <div class="card shadow-sm mb-4" style="border-left: 4px solid {{ $themeColor }};">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div style="width: 120px; height: 120px; border-radius: 50%; background: {{ $themeBg }}; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 3px solid {{ $themeColor }};">
                        <i class="fas fa-code" style="font-size: 3rem; color: {{ $themeColor }};"></i>
                    </div>
                </div>
                <div class="col-md-10">
                    <h1 class="display-5 mb-2" style="color: {{ $themeColor }}; font-weight: 700;">
                        {{ $problem->title }}
                    </h1>
                    <p class="lead mb-2">
                        <a href="{{ $problem->problem_link }}" target="_blank" style="color: {{ $themeColor }}; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-external-link-alt"></i> View on Online Judge
                        </a>
                    </p>
                    <span class="badge" style="background: {{ $themeColor }}; font-size: 1rem; padding: 8px 16px;">
                        {{ $themeName }} ({{ $rating }})
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-12">
            <!-- Statistics Dashboard -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid {{ $themeColor }};">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line" style="font-size: 2.5rem; color: {{ $themeColor }}; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: {{ $themeColor }}; font-weight: 700;">{{ $rating }}</h2>
                            <small class="text-muted">Problem Rating</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid #212529;">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle" style="font-size: 2.5rem; color: #212529; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: #212529; font-weight: 700;">{{ number_format($problem->solved_count ?? 0) }}</h2>
                            <small class="text-muted">Solved Count</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid #212529;">
                        <div class="card-body text-center">
                            <i class="fas fa-star" style="font-size: 2.5rem; color: #212529; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: #212529; font-weight: 700;">{{ number_format($problem->stars ?? 0) }}</h2>
                            <small class="text-muted">Stars</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid #212529;">
                        <div class="card-body text-center">
                            <i class="fas fa-fire" style="font-size: 2.5rem; color: #212529; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: #212529; font-weight: 700;">{{ number_format($problem->popularity ?? 0, 2) }}</h2>
                            <small class="text-muted">Popularity</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background: {{ $themeBg }}; border-bottom: 2px solid {{ $themeColor }};">
                    <h5 class="mb-0" style="color: {{ $themeColor }};">
                        <i class="fas fa-info-circle"></i> Problem Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Problem Link:</strong></p>
                            <p>
                                <a href="{{ $problem->problem_link }}" target="_blank" style="color: {{ $themeColor }}; text-decoration: none; font-weight: 600;">
                                    <i class="fas fa-external-link-alt"></i> {{ $problem->problem_link }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Rating Category:</strong></p>
                            <p class="text-muted">{{ $themeName }}</p>
                        </div>
                    </div>
                    @if(!empty($problem->created_at))
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Added:</strong></p>
                            <p class="text-muted">{{ $problem->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Last Updated:</strong></p>
                            <p class="text-muted">{{ $problem->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons at Bottom (Left Aligned) -->
    <div class="row mt-4 pt-4" style="border-top: 2px solid #dee2e6;">
        <div class="col-12">
            <div class="d-flex gap-2">
                <a href="{{ route('problem.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Problems
                </a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i> Go to Admin Dashboard
                        </a>
                    @endif
                    
                    @if(in_array(auth()->user()->role, ['moderator', 'admin']))
                        <a href="{{ route('problem.edit', $problem) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Problem
                        </a>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                        <form action="{{ route('problem.destroy', $problem) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this problem? This action cannot be undone.');">
                                <i class="fas fa-trash"></i> Delete Problem
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-layout>
