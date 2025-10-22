@php
    $rating = $problem ? (int) ($problem->rating ?? 0) : 0;
    $themeColor = $problem ? \App\Helpers\RatingHelper::getRatingColor($rating) : '#212529';
    $themeBg = $problem ? \App\Helpers\RatingHelper::getRatingBgColor($rating) : '#f8f9fa';
    $themeName = $problem ? \App\Helpers\RatingHelper::getRatingTitle($rating) : 'Problem';
@endphp

<x-layout>
    <x-slot:title>Write Editorial - CodeQuest</x-slot:title>

    <!-- Include SimpleMDE CSS and JS for Markdown Editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    
    <!-- Include Highlight.js for code syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4" style="color: {{ $themeColor }};">
                <i class="fas fa-pen"></i> Write Editorial
            </h1>
            @if($problem)
                <p class="lead">
                    Writing editorial for: 
                    <a href="{{ route('problem.show', $problem->problem_id) }}" 
                       style="color: {{ $themeColor }}; text-decoration: none; font-weight: 700;">
                        {{ $problem->title }}
                    </a>
                    <span class="badge" style="background: {{ $themeColor }};">{{ $rating }}</span>
                </p>
            @else
                <p class="lead">Create a problem editorial</p>
            @endif
        </div>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm" style="border-left: 4px solid {{ $themeColor }};">
                <div class="card-body">
                    <form action="{{ route('editorials.store') }}" method="POST">
                        @csrf

                        @if($problem)
                            <input type="hidden" name="problem_id" value="{{ $problem->problem_id }}">
                        @else
                            <div class="mb-4">
                                <label for="problem_id" class="form-label">Problem <span class="text-danger">*</span></label>
                                <select class="form-select @error('problem_id') is-invalid @enderror" id="problem_id" name="problem_id" required>
                                    <option value="">Select a problem</option>
                                    @foreach(\App\Models\Problem::orderBy('title')->get() as $p)
                                        <option value="{{ $p->problem_id }}" {{ old('problem_id') == $p->problem_id ? 'selected' : '' }}>
                                            {{ $p->title }} ({{ $p->rating }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('problem_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="solution" class="form-label">Solution / Approach <span class="text-danger">*</span></label>
                            <small class="text-muted d-block mb-2">
                                <i class="fas fa-info-circle"></i> Write your solution explanation in Markdown. Supports **bold**, *italic*, lists, code blocks, etc.
                            </small>
                            <textarea class="form-control @error('solution') is-invalid @enderror" 
                                      id="solution" 
                                      name="solution" 
                                      rows="10" 
                                      required>{{ old('solution') }}</textarea>
                            @error('solution') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="code" class="form-label">Code Implementation <span class="text-danger">*</span></label>
                            <small class="text-muted d-block mb-2">
                                <i class="fas fa-code"></i> Paste your code solution here (will be displayed with syntax highlighting)
                            </small>
                            <textarea class="form-control @error('code') is-invalid @enderror" 
                                      id="code" 
                                      name="code" 
                                      rows="15" 
                                      style="font-family: 'Courier New', monospace; font-size: 14px;"
                                      required>{{ old('code') }}</textarea>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="alert" style="background: {{ $themeBg }}; border-color: {{ $themeColor }}; color: {{ $themeColor }};">
                            <i class="fas fa-lightbulb"></i> <strong>Tips:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Explain your approach step by step in the solution section</li>
                                <li>Include time and space complexity analysis</li>
                                <li>Make sure your code is well-commented and readable</li>
                                <li>You can update your editorial anytime after submission</li>
                            </ul>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-lg" style="background: {{ $themeColor }}; color: white;">
                                <i class="fas fa-save"></i> Publish Editorial
                            </button>
                            <a href="{{ $problem ? route('problem.show', $problem->problem_id) : route('editorials.index') }}" 
                               class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize SimpleMDE for Markdown editing
        var simplemde = new SimpleMDE({
            element: document.getElementById("solution"),
            spellChecker: false,
            placeholder: "Write your solution explanation here...\n\nExample:\n## Approach\nThis problem can be solved using...\n\n### Algorithm\n1. First step\n2. Second step\n\n### Complexity\n- Time: O(n)\n- Space: O(1)",
            toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", 
                      "link", "image", "|", "preview", "side-by-side", "fullscreen", "|", "guide"],
            status: ["lines", "words", "cursor"],
        });

        // Highlight code preview
        document.getElementById('code').addEventListener('input', function() {
            this.style.color = '#e83e8c';
        });
    </script>
</x-layout>
