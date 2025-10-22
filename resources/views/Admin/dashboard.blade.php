@php
	// Minimal placeholders: controllers should pass real counts and lists when available
	$problemsCount = $problemsCount ?? 0;
	$usersCount = $usersCount ?? 0;
	$editorialsCount = $editorialsCount ?? 0;
	$tagsCount = $tagsCount ?? 0;
	$recentProblems = $recentProblems ?? [];
	$recentUsers = $recentUsers ?? [];
@endphp

@component('components.layout')
	@slot('title') Admin Dashboard - CodeQuest @endslot

	<div class="row">
		<div class="col-12">
			<h2 class="display-4">Admin Dashboard</h2>
			<p class="lead">Overview of the site. Use the cards below to quickly jump into management screens.</p>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-md-3">
			<div class="card text-center p-3">
				<div class="card-body">
					<h5 class="card-title">Problems</h5>
					<div class="h2">{{ $problemsCount }}</div>
					<a href="{{ url('admin/problems') }}" class="btn btn-outline-primary btn-sm mt-2">Manage</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card text-center p-3">
				<div class="card-body">
					<h5 class="card-title">Users</h5>
					<div class="h2">{{ $usersCount }}</div>
					<a href="{{ url('admin/users') }}" class="btn btn-outline-primary btn-sm mt-2">Manage</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card text-center p-3">
				<div class="card-body">
					<h5 class="card-title">Editorials</h5>
					<div class="h2">{{ $editorialsCount }}</div>
					<a href="{{ url('admin/editorials') }}" class="btn btn-outline-primary btn-sm mt-2">Manage</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card text-center p-3">
				<div class="card-body">
					<h5 class="card-title">Tags</h5>
					<div class="h2">{{ $tagsCount }}</div>
					<a href="{{ url('admin/tags') }}" class="btn btn-outline-primary btn-sm mt-2">Manage</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<strong>Recent Problems</strong>
				</div>
				<div class="card-body p-0">
					<table class="table mb-0">
						<thead>
							<tr>
								<th>Title</th>
								<th>Rating</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($recentProblems as $p)
								<tr>
									<td>{{ $p->title ?? 'Untitled' }}</td>
									<td><span class="badge">{{ $p->rating ?? 'N/A' }}</span></td>
									<td>
										<a href="{{ url('admin/problems/' . $p->problem_id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="3" class="text-center p-3">No problems yet.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<strong>Recent Users</strong>
				</div>
				<div class="card-body p-0">
					<table class="table mb-0">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($recentUsers as $u)
								<tr>
									<td>{{ $u->name ?? 'User' }}</td>
									<td>{{ $u->email ?? '-' }}</td>
									<td>
										<a href="{{ url('admin/users/' . $u->user_id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="3" class="text-center p-3">No users yet.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-12 text-end">
			<a href="{{ url('/') }}" class="btn btn-outline-secondary">Back to site</a>
		</div>
	</div>

@endcomponent
