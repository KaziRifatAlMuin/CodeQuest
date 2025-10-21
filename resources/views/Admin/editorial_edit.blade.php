@php
	$editorial = $editorial ?? null;
@endphp

@component('components.layout')
	@slot('title') Edit Editorial - Admin @endslot

	<div class="row">
		<div class="col-12">
			<h3 class="mb-3">Edit Editorial</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<form action="{{ url('admin/editorials/' . ($editorial->id ?? $editorial['id'] ?? '')) }}" method="POST">
						@csrf
						@if(!empty($editorial))
							@method('PUT')
						@endif

						<div class="mb-3">
							<label class="form-label">Title</label>
							<input type="text" name="title" class="form-control" value="{{ $editorial->title ?? $editorial['title'] ?? '' }}">
						</div>

						<div class="mb-3">
							<label class="form-label">Content</label>
							<textarea name="content" rows="8" class="form-control">{{ $editorial->content ?? $editorial['content'] ?? '' }}</textarea>
						</div>

						<div class="d-flex gap-2">
							<button class="btn btn-primary">Save</button>
							<a href="{{ url('admin/editorials') }}" class="btn btn-outline-secondary">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endcomponent
