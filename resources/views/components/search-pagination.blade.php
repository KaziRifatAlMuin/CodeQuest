{{-- Search and Pagination Controls Component --}}
<div class="row mb-3">
    <div class="col-md-8">
        <form method="GET" action="{{ $action ?? request()->url() }}" class="d-flex gap-2">
            {{-- Preserve existing query parameters --}}
            @foreach(request()->except(['search', 'per_page', 'page']) as $key => $value)
                @if(is_array($value))
                    @foreach($value as $val)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $val }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            
            <div class="input-group flex-grow-1">
                <span class="input-group-text bg-white">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    class="form-control border-start-0" 
                    placeholder="{{ $placeholder ?? 'Search...' }}"
                    value="{{ request('search') }}"
                    style="border-left: none !important;"
                >
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i> Search
                </button>
                @if(request('search'))
                    <a href="{{ request()->url() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="col-md-4">
        <form method="GET" action="{{ $action ?? request()->url() }}" id="perPageForm">
            {{-- Preserve existing query parameters --}}
            @foreach(request()->except(['per_page', 'page']) as $key => $value)
                @if(is_array($value))
                    @foreach($value as $val)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $val }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="fas fa-list text-muted"></i>
                </span>
                <select 
                    name="per_page" 
                    class="form-select border-start-0" 
                    onchange="this.form.submit()"
                    style="border-left: none !important;"
                >
                    @foreach([10, 25, 50, 100] as $option)
                        <option value="{{ $option }}" {{ request('per_page', 25) == $option ? 'selected' : '' }}>
                            {{ $option }} per page
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<style>
/* Search Highlight Styling */
mark.search-highlight {
    background: linear-gradient(120deg, #ffd700 0%, #ffed4e 100%);
    color: #000;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(255, 215, 0, 0.3);
    animation: highlight-pulse 1.5s ease-in-out;
}

@keyframes highlight-pulse {
    0% {
        background: linear-gradient(120deg, #fff 0%, #fff 100%);
    }
    50% {
        background: linear-gradient(120deg, #ffd700 0%, #ffed4e 100%);
    }
    100% {
        background: linear-gradient(120deg, #ffd700 0%, #ffed4e 100%);
    }
}

/* Modern search input styling */
.input-group .form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    border-color: #86b7fe;
}

.input-group-text {
    border-right: none;
}

.form-control.border-start-0:focus {
    border-left: 1px solid #86b7fe !important;
}

.input-group:focus-within .input-group-text {
    border-color: #86b7fe;
}
</style>
