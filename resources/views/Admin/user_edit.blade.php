@php
	$user = $user ?? null;
@endphp

@component('components.layout')
	@slot('title') Edit User - Admin @endslot

	<div class="row">
		<div class="col-12">
			<h3 class="mb-3">Edit User</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<form action="{{ url('admin/users/' . ($user->id ?? $user['id'] ?? '')) }}" method="POST">
						@csrf
						@if(!empty($user))
							@method('PUT')
						@endif

						<div class="mb-3">
							<label class="form-label">Name</label>
							<input type="text" name="name" class="form-control" value="{{ $user->name ?? $user['name'] ?? '' }}">
						</div>

						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="email" name="email" class="form-control" value="{{ $user->email ?? $user['email'] ?? '' }}">
						</div>

						<div class="mb-3">
							<label class="form-label">Role</label>
							<select name="role" class="form-select">
								<option value="user" {{ ( ($user->role ?? $user['role'] ?? '') == 'user') ? 'selected' : '' }}>User</option>
								<option value="admin" {{ ( ($user->role ?? $user['role'] ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
							</select>
						</div>

						<div class="d-flex gap-2">
							<button class="btn btn-primary">Save</button>
							<a href="{{ url('admin/users') }}" class="btn btn-outline-secondary">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endcomponent
