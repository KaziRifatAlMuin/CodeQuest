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
					<form action="{{ url('admin/editorials/' . ($editorial->editorial_id ?? '')) }}" method="POST">
						@csrf
						@if(!empty($editorial))
							@method('PUT')
						@endif

						<div class="mb-3">
							<label class="form-label">Title</label>
							<input type="text" name="title" class="form-control" value="{{ $editorial->title ?? '' }}" required>
						</div>

						<div class="mb-3">
							<label class="form-label">Content</label>
							<textarea name="content" rows="8" class="form-control" required>{{ $editorial->content ?? '' }}</textarea>
						</div>

						<div class="mb-3">
							<label class="form-label">Problem ID</label>
							<input type="number" name="problem_id" class="form-control" value="{{ $editorial->problem_id ?? '' }}" min="1">
						</div>

						<div class="mb-3">
							<label class="form-label">Author ID</label>
							<input type="number" name="author_id" class="form-control" value="{{ $editorial->author_id ?? '' }}" min="1">
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
