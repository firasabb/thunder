@extends('admin.layouts.panel')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$user->username}}</div>

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

                        <form method="POST" action="{{ route('admin.edit.user', ['id' => $user->id]) }}"
                              class="edit-form-confirm">
                            {!! csrf_field() !!}
                            {!! method_field('PUT') !!}

                            <div class="row mb-2">
                                <div class="col">

                                    <input class="form-control enabled-disabled" type="text" name="first_name"
                                            value="{{ $user->first_name }}" placeholder="{{ __('user.first name') }}"
                                            disabled/>

                                </div>
                                <div class="col">
                                    <input class="form-control enabled-disabled" type="text" name="last_name"
                                            value="{{ $user->last_name }}" placeholder="{{ __('user.last name') }}"
                                            disabled/>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
   
                                    <input class="form-control enabled-disabled" type="text" name="name"
                                            value="{{ $user->username }}" placeholder="{{ __('admin.name') }}"
                                            disabled/>
                                </div>
                                <div class="col">

                                    <input class="form-control enabled-disabled" type="email" name="email"
                                            value="{{ $user->email }}" placeholder="{{ __('admin.email') }}"
                                            disabled/>
                                </div>
                                <div class="col">
                                    <div>
                                        <select multiple class="form-control enabled-disabled" id="usersSelect"
                                                name="roles[]" disabled>
                                            @foreach($roles as $role)
                                                <option
                                                    <?php $user->hasRole($role->name) ? print('selected') : print(' ')  ?> value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary submit-edit-btn enabled-disabled"
                                            disabled>{{ __('admin.submit') }}</button>
                                    <a href=" {{ route('admin.generate.password.user', ['id' => $user->id]) }} "
                                       class="btn btn-danger submit-edit-btn disabled"
                                       id="generate-password">{{ __('admin.generate password') }}</a>
                                    <a href=" {{ route('admin.user.login.as', ['id' => $user->id]) }} "
                                       class="btn btn-warning submit-edit-btn"
                                       id="login-as">{{ __('admin.login as') }}</a>
                                    <a href=" {{ route('admin.user.toggle.ban', ['id' => $user->id]) }} "
                                       class="btn btn-dark submit-edit-btn"
                                       id="login-as">{{ $user->status != 'banned' ? __('admin.ban') : __('admin.unban') }}</a>
                                </div>
                            </div>
                            <div class="row info-row">
                                <div class="col">
                                    <h4>Roles:</h4>
                                    @foreach($user->roles as $role)
                                        <p> {{ strtoupper($role->name) }} </p>
                                    @endforeach
                                </div>
                                <div class="col">
                                    <h5>{{ __('admin.Created at') }}:</h5>
                                    <p>{{ $user->created_at }}</p>
                                    <h5>{{ __('admin.Updated at') }}:</h5>
                                    <p>{{ $user->updated_at }}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="block-button">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-lg"
                                id="edit-button">{{ __('admin.edit') }}
                        </button>
                        <form action="{{ route('admin.delete.user', ['id' => $user->id]) }}" method="POST"
                            class="delete-form-2 delete-form-confirm">
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
