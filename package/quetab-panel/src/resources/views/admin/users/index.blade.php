@extends('admin.layouts.panel')


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center search-row">
            <div class="col-md-12 search-col">
                <form method="post" action="{{ route('admin.search.users') }}" id="filter-form">
                    {!! csrf_field() !!}
                    <div class="row" >
                        <div class="col">
                            <input type="number" name="id" placeholder="{{ __('admin.ID') }}" class="form-control filter-input" value="{{ Request::get('id') ?? '' }}"/>
                        </div>
                        <div class="col">
                            <input type="eamil" name="email" placeholder="{{ __('admin.email') }}" class="form-control filter-input" value="{{ Request::get('email') ?? '' }}"/>
                        </div>
                        <div class="col">
                            <input type="text" name="first_name" placeholder="{{ __('admin.first name') }}" class="form-control filter-input" value="{{ Request::get('first_name') ?? '' }}"/>
                        </div>
                        <div class="col">
                            <input type="text" name="last_name" placeholder="{{ __('admin.last name') }}" class="form-control filter-input" value="{{ Request::get('last_name') ?? '' }}"/>
                        </div>
                        <div class="col">
                            <input type="text" name="username" placeholder="{{ __('admin.username') }}" class="form-control filter-input" value="{{ Request::get('username') ?? '' }}"/>
                        </div>
                        <div class="col">
                            <select name="status" class="form-control">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}">{{ strtoupper($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="submit" id='filter-btn' value="{{ __('admin.search') }}" class="btn btn-primary"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('admin.users') }}
                            </div>
                            <div class="col-md-6">
                                <form class="float-end" method="post" action="{{ route('admin.export.users') }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <button class="btn btn-sm btn-light">{{ __('main.export') }}</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>

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
                                    <a class="a-no-decoration" href="{{ route('admin.index.users', ['order' => 'id', 'desc' => !$desc]) }}">{!! $order == 'id' && $desc ? '&#8639;' : '&#8642;' !!} {{ __('admin.ID') }}</a>
                                </th>
                                <th>
                                    {{ __('admin.name') }}
                                </th>
                                <th>
                                    {{ __('admin.email') }}
                                </th>
                                <th>
                                    <a class="a-no-decoration"  href="{{ route('admin.index.users', ['order' => 'status', 'desc' => !$desc]) }}">{!! $order == 'status' && $desc ? '&#8639;' : '&#8642;' !!} {{ __('admin.status') }}</a>
                                </th>
                                <th>
                                    <a class="a-no-decoration"  href="{{ route('admin.index.users', ['order' => 'username', 'desc' => !$desc]) }}">{!! $order == 'username' && $desc ? '&#8639;' : '&#8642;' !!} {{ __('admin.username') }}</a>
                                </th>
                                <th>
                                    {{ __('admin.created') }}
                                </th> 
                                <th>
                                    {{ __('admin.roles') }}
                                </th>
                                <th class="td-actions">
                                    {{ __('admin.actions') }}
                                </th>   
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{$user->id}}
                                    </td>
                                    <td>
                                        {{$user->first_name . ' ' . $user->last_name}}
                                    </td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                    <td>
                                        {{ strtoupper($user->status) }}
                                    </td>
                                    <td>
                                        {{$user->username}}
                                    </td>
                                    <td>
                                        {{ $user->created_at->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        <?php
                                            $userRoles = $user->roles;
                                            foreach ($userRoles as $role) {
                                                echo strtoupper($role->name) . ' <br> ';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="td-actions-btns">
                                            <a href="{{ url('admin/dashboard/user/' . $user->id) }}" class="btn btn-success">{{ __('admin.edit') }}</a>
                                            <form action="{{ route('admin.delete.user', ['id' => $user->id]) }}" method="POST" class="delete-form-1 delete-form-confirm">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-danger" type="submit">{{ __('admin.delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $users->links() }}
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
                        <form method="POST" action="{{ route('admin.create.user') }}">
                                {!! csrf_field() !!}
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.add') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-2">
                                            <input class="form-control" type="text" name="first_name"  value="{{ old('first_name') }}" placeholder="{{ __('admin.first name') }}" />
                                        </div>
                                        <div class="form-group mb-2">
                                            <input class="form-control" type="text" name="last_name"  value="{{ old('last_name') }}" placeholder="{{ __('admin.last name') }}" />
                                        </div>
                                        <div class="form-group mb-2">
                                            <input class="form-control" type="email" name="email"  value="{{ old('email') }}" placeholder="{{ __('admin.email') }}" />
                                        </div>
                                        <div class="form-group mb-2">
                                            <input class="form-control" id="username" type="text" name="username"  value="{{ old('username') }}" placeholder="{{ __('admin.username') }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-2">
                                            <input class="form-control" type="password" name="password"  value="{{ old('password') }}" placeholder="{{ __('admin.password') }}" />
                                        </div>
                                        <div>
                                            <select multiple class="form-control" id="usersSelect" name="roles[]">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
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
