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
					<form action="{{ url('admin/problems/' . ($problem->id ?? $problem['id'] ?? '')) }}" method="POST">
						@csrf
						@if(!empty($problem))
							@method('PUT')
						@endif

						<div class="mb-3">
							<label class="form-label">Title</label>
							<input type="text" name="title" class="form-control" value="{{ $problem->title ?? $problem['title'] ?? '' }}">
						</div>

						<div class="mb-3">
							<label class="form-label">Statement</label>
							<textarea name="statement" rows="6" class="form-control">{{ $problem->statement ?? $problem['statement'] ?? '' }}</textarea>
						</div>

						<div class="mb-3">
							<label class="form-label">Difficulty</label>
							<select name="difficulty" class="form-select">
								<option value="easy" {{ (($problem->difficulty ?? $problem['difficulty'] ?? '') == 'easy') ? 'selected' : '' }}>Easy</option>
								<option value="medium" {{ (($problem->difficulty ?? $problem['difficulty'] ?? '') == 'medium') ? 'selected' : '' }}>Medium</option>
								<option value="hard" {{ (($problem->difficulty ?? $problem['difficulty'] ?? '') == 'hard') ? 'selected' : '' }}>Hard</option>
							</select>
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
