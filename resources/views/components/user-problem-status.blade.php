@php
    $userStatus = null;
    if (auth()->check()) {
        $userStatus = $problem->getUserStatus(auth()->id());
    }
@endphp

@if(auth()->check())
    <div class="card shadow-sm mb-4" style="border-left: 4px solid #0066cc;">
        <div class="card-header" style="background-color: #f0f4ff;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user"></i> Your Status</h5>
                <div class="d-flex gap-2">
                    <!-- Star Toggle Button -->
                    <form action="{{ route('problem.toggleStar', $problem) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <button type="submit" class="btn btn-sm {{ $userStatus && $userStatus->is_starred ? 'btn-warning' : 'btn-outline-warning' }}" 
                                title="{{ $userStatus && $userStatus->is_starred ? 'Remove star' : 'Add star' }}">
                            <i class="fas fa-star"></i> {{ $userStatus && $userStatus->is_starred ? 'Starred' : 'Star' }}
                        </button>
                    </form>
                    
                    @if($userStatus)
                        <a href="{{ route('userProblem.edit', [$problem, auth()->id()]) }}" 
                           class="btn btn-sm btn-outline-primary"
                           title="Update your status">
                            <i class="fas fa-pencil-alt"></i> Update
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($userStatus)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong>Current Status:</strong></p>
                        <div class="mb-2">
                            @if($userStatus->status === 'solved')
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Solved</span>
                            @elseif($userStatus->status === 'trying')
                                <span class="badge bg-warning"><i class="fas fa-spinner"></i> Trying</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-times-circle"></i> Unsolved</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong>Starred:</strong></p>
                        <p>
                            @if($userStatus->is_starred)
                                <i class="fas fa-star text-warning"></i> Yes
                            @else
                                <i class="fas fa-star text-muted"></i> No
                            @endif
                        </p>
                    </div>
                </div>

                @if($userStatus->solved_at)
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1"><strong>Solved On:</strong></p>
                            <p class="text-muted">{{ $userStatus->solved_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                @endif

                @if($userStatus->submission_link)
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1"><strong>Submission Link:</strong></p>
                            <a href="{{ $userStatus->submission_link }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-external-link-alt"></i> {{ $userStatus->submission_link }}
                            </a>
                        </div>
                    </div>
                @endif

                @if($userStatus->notes)
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1"><strong><i class="fas fa-lock text-success"></i> Your Private Notes:</strong></p>
                            <div class="alert alert-light border">
                                {{ $userStatus->notes }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <p class="text-muted mb-0">
                    <i class="fas fa-info-circle"></i> You haven't marked your progress on this problem yet.
                    <a href="{{ route('userProblem.edit', [$problem, auth()->id()]) }}">Set your status now</a>.
                </p>
            @endif
        </div>
    </div>
@endif
