@extends('admin.layouts.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header">{{ $setting->title }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.edit.setting', ['id' => $setting->id]) }}" class="edit-form-confirm">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name" class="form-label">{{ __('admin.name') }}</label>
                                    <input class="form-control enabled-disabled" type="text" name="name"  value="{{ $setting->name }}" placeholder="{{ __('admin.name') }}" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <div>
                                    <label for="value" class="form-label">{{ __('admin.value') }}</label>
                                    <textarea class="form-control enabled-disabled" name="value" placeholder="{{ __('admin.value') }}" disabled>{{ $setting->value }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col submit-btn-roles">
                                <button type="submit" class="btn btn-primary submit-edit-btn enabled-disabled" disabled>{{ __('admin.submit') }}</button>
                            </div>
                        </div>
                        <div class="row info-row">
                            <div class="col">
                                <h5>{{ __('admin.Created at') }}:</h1>
                                <p>{{ $setting->created_at }}</p>
                                <h5>{{ __('admin.Updated at') }}:</h1>
                                <p>{{ $setting->updated_at }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="block-button">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success btn-lg" id="edit-button">{{ __('admin.edit') }}</button>
                    <form action="{{ route('admin.delete.setting', ['id' => $setting->id]) }}" method="POST" class="delete-form-2 delete-form-confirm">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger btn-lg">{{ __('admin.delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
