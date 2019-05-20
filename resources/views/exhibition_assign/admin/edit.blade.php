@extends('_layouts.backend')
@section('title', __('exhibitor.edit'))

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('admin.exhibition.index') }}">Exhibition</a>
    <a class="breadcrumb-item" href="{{ route('admin.exhibition.edit', $exhibition->id) }}">{{ str_limit($exhibition->title, 20, '...') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.exhibition_assign.index', $exhibition->id) }}">Exhibitors</a>
    <span class="breadcrumb-item active text-muted">{{ $exhibitor->name }}</span>
</nav>

<div class="block block-bordered">
	<form action="{{ route('admin.exhibition_assign.update', [$exhibition->id, $exhibitor->pivot->exhibitor_id]) }}" method="post">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">

		<div class="block-header block-header-default border-b">
			<h3 class="block-title">{{ __('general.detail') }}</h3>
		</div>
		<div class="block-content block-content-full mb-20">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('exhibitor_id') ? ' is-invalid' : '' }}">
						<label for="field-exhibitor_id">{{ __('general.exhibitor') }}</label>
						<input type="text" class="form-control" value="{{ $exhibitor->name }}" disabled>
						<div class="invalid-feedback">{{ $errors->first('exhibitor_id') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('booth') ? ' is-invalid' : '' }}">
						<label for="field-booth">Booth</label>
						<input type="text" class="form-control" id="field-booth" name="booth" value="{{ old('booth', $exhibitor->pivot->booth) }}">
						<div class="invalid-feedback">{{ $errors->first('booth') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="block-content block-content-full bg-gray-lighter border-t">
			<div class="row">
				<div class="col-auto mr-auto">
				</div>
				<div class="col-auto">
					<button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection
