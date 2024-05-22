@extends('admin.layouts.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$permission->name}}</div>

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

                    <form method="POST" action="{{ route('admin.edit.permission', ['id' => $permission->id]) }}" class="edit-form-confirm">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control enabled-disabled" type="text" name="name"  value="{{ $permission->name }}" placeholder="{{ __('admin.name') }}" disabled/>
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <select multiple class="form-control enabled-disabled" id="usersSelect" name="roles[]" disabled>
                                        @foreach($roles as $role)
                                            <option <?php $permission->hasRole($role->name) ? print('selected') : print(' ')  ?> value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
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
                                <h4>{{ __('admin.roles') }}:</h4>
                                @foreach($permission->roles as $role)
                                    <p> {{ strtoupper($role->name) }} </p>
                                @endforeach
                            </div>
                            <div class="col">
                                <h5>{{ __('admin.Created at') }}:</h1>
                                <p>{{ $permission->created_at }}</p>
                                <h5>{{ __('admin.Updated at') }}:</h1>
                                <p>{{ $permission->updated_at }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="block-button">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success btn-lg" id="edit-button">{{ __('admin.edit') }}</button>
                    <form action="{{ route('admin.delete.permission', ['id' => $permission->id]) }}" method="POST" class="delete-form-2 delete-form-confirm">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <button type="submit" class="btn btn-danger btn-lg">{{ __('admin.delete') }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
