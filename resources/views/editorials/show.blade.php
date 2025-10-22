@php
    $rating = (int) ($editorial->problem->rating ?? 0);
    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
    $themeBg = \App\Helpers\RatingHelper::getRatingBgColor($rating);
    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
@endphp

<x-layout>
    <x-slot:title>Editorial: {{ $editorial->problem->title }} - CodeQuest</x-slot:title>

    <!-- Include Marked.js for Markdown rendering -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    
    <!-- Include Highlight.js for code syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/cpp.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/java.min.js"></script>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Editorial Header -->
    <div class="card shadow-sm mb-4" style="border-left: 4px solid {{ $themeColor }};">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h1 class="display-5 mb-2" style="color: {{ $themeColor }}; font-weight: 700;">
                        <i class="fas fa-book-open"></i> Editorial
                    </h1>
                    <h3 class="mb-2">
                        <a href="{{ route('problem.show', $editorial->problem->problem_id) }}" 
                           style="color: {{ $themeColor }}; text-decoration: none;">
                            {{ $editorial->problem->title }}
                        </a>
                    </h3>
                </div>
                <span class="badge" style="background: {{ $themeColor }}; font-size: 1.2rem; padding: 10px 20px;">
                    {{ $themeName }} ({{ $rating }})
                </span>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">
                        <strong style="color: {{ $themeColor }};">Author:</strong>
                        <a href="{{ route('user.show', $editorial->author->user_id) }}" class="text-decoration-none">
                            {{ $editorial->author->name }}
                        </a>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        <i class="far fa-clock"></i> Updated {{ $editorial->updated_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Vote Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <form action="{{ route('editorials.upvote', $editorial->editorial_id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-thumbs-up"></i> Upvote ({{ $editorial->upvotes }})
                        </button>
                    </form>
                    
                    <form action="{{ route('editorials.downvote', $editorial->editorial_id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-thumbs-down"></i> Downvote ({{ $editorial->downvotes }})
                        </button>
                    </form>
                </div>
                
                <div>
                    @if(auth()->check() && (auth()->id() === $editorial->author_id || auth()->user()->role === 'admin'))
                        <a href="{{ route('editorials.edit', $editorial->editorial_id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Editorial
                        </a>
                    @endif
                    
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <form action="{{ route('editorials.destroy', $editorial->editorial_id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this editorial?');">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Solution Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: {{ $themeBg }}; border-bottom: 2px solid {{ $themeColor }};">
            <h5 class="mb-0" style="color: {{ $themeColor }};">
                <i class="fas fa-lightbulb"></i> Solution Approach
            </h5>
        </div>
        <div class="card-body">
            <div id="solution-content" class="markdown-content">
                <!-- Markdown will be rendered here -->
            </div>
        </div>
    </div>

    <!-- Code Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: {{ $themeBg }}; border-bottom: 2px solid {{ $themeColor }};">
            <h5 class="mb-0" style="color: {{ $themeColor }};">
                <i class="fas fa-code"></i> Code Implementation
            </h5>
        </div>
        <div class="card-body p-0">
            <pre style="margin: 0;"><code id="code-content" class="language-cpp" style="display: block; padding: 20px;">{{ $editorial->code }}</code></pre>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4 pt-4" style="border-top: 2px solid #dee2e6;">
        <div class="col-12">
            <div class="d-flex gap-2">
                <a href="{{ route('problem.show', $editorial->problem->problem_id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Problem
                </a>
                <a href="{{ route('editorials.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Editorials
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Markdown content styling */
        .markdown-content {
            line-height: 1.8;
            font-size: 1.05rem;
        }
        
        .markdown-content h1 {
            color: {{ $themeColor }};
            border-bottom: 2px solid {{ $themeColor }};
            padding-bottom: 10px;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        
        .markdown-content h2 {
            color: {{ $themeColor }};
            margin-top: 25px;
            margin-bottom: 15px;
        }
        
        .markdown-content h3 {
            color: {{ $themeColor }};
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        .markdown-content code {
            background-color: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
        }
        
        .markdown-content pre {
            background-color: #2d2d2d;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        
        .markdown-content pre code {
            background-color: transparent;
            padding: 0;
            color: #f8f8f2;
        }
        
        .markdown-content ul, .markdown-content ol {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        
        .markdown-content li {
            margin-bottom: 8px;
        }
        
        .markdown-content blockquote {
            border-left: 4px solid {{ $themeColor }};
            padding-left: 15px;
            margin-left: 0;
            color: #6c757d;
            font-style: italic;
        }
        
        .markdown-content a {
            color: {{ $themeColor }};
            text-decoration: none;
        }
        
        .markdown-content a:hover {
            text-decoration: underline;
        }
        
        .markdown-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .markdown-content table th,
        .markdown-content table td {
            border: 1px solid #dee2e6;
            padding: 10px;
        }
        
        .markdown-content table th {
            background-color: {{ $themeBg }};
            color: {{ $themeColor }};
            font-weight: bold;
        }
    </style>

    <script>
        // Render Markdown
        const solutionMarkdown = @json($editorial->solution);
        document.getElementById('solution-content').innerHTML = marked.parse(solutionMarkdown);
        
        // Apply syntax highlighting to code
        hljs.highlightElement(document.getElementById('code-content'));
        
        // Also highlight any code blocks within the markdown content
        document.querySelectorAll('.markdown-content pre code').forEach((block) => {
            hljs.highlightElement(block);
        });
    </script>
</x-layout>
