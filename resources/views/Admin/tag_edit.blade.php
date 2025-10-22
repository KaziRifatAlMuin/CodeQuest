@php
	$tag = $tag ?? null;
@endphp

@component('components.layout')
	@slot('title') Edit Tag - Admin @endslot

	<div class="row">
		<div class="col-12">
			<h3 class="mb-3">Edit Tag</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<form action="{{ url('admin/tags/' . ($tag->tag_id ?? '')) }}" method="POST">
						@csrf
						@if(!empty($tag))
							@method('PUT')
						@endif

						<div class="mb-3">
							<label class="form-label">Tag Name</label>
							<input type="text" name="tag_name" class="form-control" value="{{ $tag->tag_name ?? '' }}" required>
						</div>

						<div class="d-flex gap-2">
							<button class="btn btn-primary">Save</button>
							<a href="{{ url('admin/tags') }}" class="btn btn-outline-secondary">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endcomponent
