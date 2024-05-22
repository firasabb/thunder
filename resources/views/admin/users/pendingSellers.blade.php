@extends('admin.layouts.panel')


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('admin.approve sellers') }}</div>

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
                                    {{ __('admin.username') }}
                                </th>
                                <th>
                                    {{ __('admin.created') }}
                                </th>
                                <th class="td-actions">
                                    {{ __('admin.actions') }}
                                </th>   
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->id }}
                                    </td>
                                    <td>
                                        <a href="{{ route('user.profile', ['username' => $user->username]) }}">{{ $user->username }}</a>
                                    </td>
                                    <td>
                                        {{ $user->created_at }}
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <form action="{{ route('admin.sellers.approve') }}" method="POST" class="delete-form-1 delete-form-confirm">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <input type="hidden" name="status" value="approved">
                                                <button class="btn btn-blue" type="submit">{{ __('admin.approve') }}</button>
                                            </form>
                                            <form action="{{ route('admin.sellers.approve') }}" method="POST" class="delete-form-1 delete-form-confirm">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <input type="hidden" name="status" value="disapproved">
                                                <button class="btn btn-warning" type="submit">{{ __('admin.disapprove') }}</button>
                                            </form>
                                            <a href="{{ route('admin.show.user', ['id' => $user->id]) }}" class="btn btn-success">{{ __('admin.show/edit') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
