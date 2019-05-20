@extends('_layouts.backend')
@section('title', __('exhibitor.add'))

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('admin.exhibition.index') }}">Exhibition</a>
    <a class="breadcrumb-item" href="{{ route('admin.exhibition.edit', $exhibition->id) }}">{{ str_limit($exhibition->title, 20, '...') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.exhibition_assign.index', $exhibition->id) }}">Exhibitors</a>
    <span class="breadcrumb-item active text-muted">Add</span>
</nav>

<div class="block block-bordered">
	<form action="{{ route('admin.exhibition_assign.store', $exhibition->id) }}" method="post">
		{{ csrf_field() }}
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('exhibitor_id') ? ' is-invalid' : '' }}">
						<label for="field-exhibitor_id">{{ __('general.exhibitor') }}</label>
						<select class="js-select2 form-control" id="field-exhibitor_id" name="exhibitor_id" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
							<option></option>
							@foreach($exhibitors as $exhibitor)
							<option value="{{ $exhibitor->id }}" {{ old('exhibitor_id') == $exhibitor->id ? 'selected' : '' }}>{{ $exhibitor->name }}</option>
							@endforeach
						</select>
						<div class="invalid-feedback">{{ $errors->first('exhibitor_id') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('booth') ? ' is-invalid' : '' }}">
						<label for="field-booth">Booth</label>
						<input type="text" class="form-control" id="field-booth" name="booth" value="{{ old('booth') }}">
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
