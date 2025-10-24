<x-layout>
    <x-slot:title>Activity - CodeQuest</x-slot:title>

    <div class="container py-5">
        <h1 class="mb-4">🔔 Recent Activity</h1>
        <p class="text-muted mb-4">Live feed powered by the activity controller. Only valid problems and users are linked.</p>

        <div class="list-group shadow-sm">
            @forelse($activities as $activity)
                <div class="list-group-item d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        @php
                            $userClass = \App\Helpers\RatingHelper::getRatingTextClass((int) ($activity->user_rating ?? 0));
                            $problemClass = \App\Helpers\RatingHelper::getRatingTextClass((int) ($activity->problem_rating ?? 0));
                        @endphp

                        @if(!empty($activity->user_id))
                            <a href="{{ route('user.show', $activity->user_id) }}" class="text-decoration-none {{ $userClass }}">
                                {{ $activity->user_name ?? 'Anonymous' }}
                            </a>
                        @else
                            <span class="{{ $userClass }}">{{ $activity->user_name ?? 'Anonymous' }}</span>
                        @endif
                        <span class="text-muted">{{ ucfirst($activity->activity_type ?? 'activity') }}</span>
                        @if(!empty($activity->problem_id))
                            <a href="{{ route('problem.show', $activity->problem_id) }}" class="text-decoration-none {{ $problemClass }}">
                                {{ $activity->problem_title ?? 'Problem' }}
                            </a>
                        @else
                            <span class="{{ $problemClass }}">{{ $activity->problem_title ?? '' }}</span>
                        @endif
                    </div>
                    <span class="badge bg-light text-muted">{{ \Carbon\Carbon::parse($activity->activity_date ?? 'now')->diffForHumans() }}</span>
                </div>
            @empty
                <div class="list-group-item text-center text-muted py-4">No recent activity to display.</div>
            @endforelse
        </div>

        <div class="mt-4 text-center text-muted small">Data updates every time the controller is invoked.</div>
    </div>
</x-layout>
