@extends('admin.layouts.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('admin.roles') }}</div>

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

                    <table class="table">
                        <tr>
                            <th>
                                {{ __('admin.ID') }}
                            </th>
                            <th>
                                {{ __('admin.name') }}
                            </th>
                            <th>
                                {{ __('admin.permissions') }}
                            </th>
                            <th class="td-actions">
                                {{ __('admin.actions') }}
                            </th>   
                        </tr>
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    {{$role->id}}
                                </td>
                                <td>
                                    {{ strtoupper($role->name) }}
                                </td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                        {{ $permission->name }} <br>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="td-actions-btns">
                                        <a href="{{ route('admin.show.role', ['id' => $role->id]) }}" class="btn btn-success">{{ __('admin.show/edit') }}</a>
                                        <form action="{{ route('admin.delete.role', ['id' => $role->id]) }}" method="POST" class="delete-form-1 delete-form-confirm">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-danger" type="submit">{{ __('admin.delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
            <div class="block-button">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addModal">{{ __('admin.add') }}</button>
                </div>
            </div>

            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <form method="POST" action="{{ route('admin.create.role') }}">
                            {!! csrf_field() !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.role') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name"  value="{{ old('name') }}" placeholder="{{ __('admin.name') }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <select multiple class="form-control" id="permissionsSelect" name="permissions[]">
                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                            <button name="action" type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
