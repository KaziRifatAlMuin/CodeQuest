@php
	$problem = $problem ?? null;
@endphp

@component('components.layout')
	@slot('title') Edit Problem - Admin @endslot

	<div class="row">
		<div class="col-12">
			<h3 class="mb-3">Edit Problem</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<form action="{{ url('admin/problems/' . ($problem->problem_id ?? '')) }}" method="POST">
						@csrf
						@if(!empty($problem))
							@method('PUT')
						@endif

						<div class="mb-3">
							<label class="form-label">Title</label>
							<input type="text" name="title" class="form-control" value="{{ $problem->title ?? '' }}" required>
						</div>

						<div class="mb-3">
							<label class="form-label">Problem Link</label>
							<input type="url" name="problem_link" class="form-control" value="{{ $problem->problem_link ?? '' }}" required>
						</div>

						<div class="mb-3">
							<label class="form-label">Rating</label>
							<input type="number" name="rating" class="form-control" value="{{ $problem->rating ?? 800 }}" min="0">
						</div>

						<div class="mb-3">
							<label class="form-label">Solved Count</label>
							<input type="number" name="solved_count" class="form-control" value="{{ $problem->solved_count ?? 0 }}" min="0">
						</div>

						<div class="mb-3">
							<label class="form-label">Stars</label>
							<input type="number" name="stars" class="form-control" value="{{ $problem->stars ?? 0 }}" min="0">
						</div>

						<div class="d-flex gap-2">
							<button class="btn btn-primary">Save</button>
							<a href="{{ url('admin/problems') }}" class="btn btn-outline-secondary">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endcomponent
