@props(['headers' => [], 'paginator' => null])

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>

<style>
    .table-hover tbody tr {
        cursor: pointer;
        transition: all 0.3s ease;
        transform-origin: center;
    }
    
    .table-hover tbody tr:hover {
        background-color: #e3f2fd !important;
        transform: scale(1.005);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }
    
    .table-hover tbody tr:active {
        transform: scale(0.995);
    }
</style>

@if(!empty($paginator) && method_exists($paginator, 'links'))
    <div class="d-flex justify-content-end align-items-center mt-3">
        {!! $paginator->links() !!}
    </div>
@endif
