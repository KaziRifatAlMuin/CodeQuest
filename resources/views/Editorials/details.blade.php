<x-layout>
    <x-slot:title>Editorial Details - CodeQuest</x-slot:title>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="fas fa-book"></i> Editorial for: {{ $editorial->problem_title }}
                </h1>
                <a href="{{ url('/editorials') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Problem Information</h5>
                        <div class="mb-3">
                            <b>Problem:</b> {{ $editorial->problem_title }}
                            <br>
                            <b>Problem ID:</b> {{ $editorial->problem_id }}
                            <br>
                            @if($editorial->problem_rating)
                            <b>Rating:</b> 
                            @php
                                $ratingBgClass = \App\Helpers\RatingHelper::getRatingBgClass((int)$editorial->problem_rating);
                            @endphp
                            <span class="badge {{ $ratingBgClass }}">{{ $editorial->problem_rating }}</span>
                            <br>
                            @endif
                            @if($editorial->problem_link)
                            <b>Link:</b> <a href="{{ $editorial->problem_link }}" target="_blank">View Problem <i class="fas fa-external-link-alt"></i></a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Editorial Content</h5>
                        
                        @if($editorial->approach)
                        <div class="mb-4">
                            <h6 class="text-muted">Approach</h6>
                            <p style="white-space: pre-wrap;">{{ $editorial->approach }}</p>
                        </div>
                        @endif

                        @if($editorial->complexity)
                        <div class="mb-4">
                            <h6 class="text-muted">Complexity</h6>
                            <p>{{ $editorial->complexity }}</p>
                        </div>
                        @endif

                        @if($editorial->code)
                        <div class="mb-4">
                            <h6 class="text-muted">Solution Code 
                                @if($editorial->language)
                                <span class="badge badge-secondary">{{ strtoupper($editorial->language) }}</span>
                                @endif
                            </h6>
                            <pre class="bg-light p-3 rounded"><code>{{ $editorial->code }}</code></pre>
                        </div>
                        @endif

                        @if($editorial->explanation)
                        <div class="mb-4">
                            <h6 class="text-muted">Detailed Explanation</h6>
                            <p style="white-space: pre-wrap;">{{ $editorial->explanation }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Author</h5>
                        <p>
                            <b>{{ $editorial->author_name }}</b>
                            @if($editorial->author_handle)
                            <br><small class="text-muted">@{{ $editorial->author_handle }}</small>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Votes</h5>
                        <div class="d-flex justify-content-around">
                            <div class="text-center">
                                <h3 class="text-success">
                                    <i class="fas fa-thumbs-up"></i> {{ $editorial->upvotes ?? 0 }}
                                </h3>
                                <small class="text-muted">Upvotes</small>
                            </div>
                            <div class="text-center">
                                <h3 class="text-danger">
                                    <i class="fas fa-thumbs-down"></i> {{ $editorial->downvotes ?? 0 }}
                                </h3>
                                <small class="text-muted">Downvotes</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Details</h5>
                        <p>
                            <small class="text-muted">Created:</small><br>
                            {{ \Carbon\Carbon::parse($editorial->created_at)->format('M d, Y h:i A') }}
                        </p>
                        @if($editorial->updated_at != $editorial->created_at)
                        <p>
                            <small class="text-muted">Updated:</small><br>
                            {{ \Carbon\Carbon::parse($editorial->updated_at)->format('M d, Y h:i A') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
