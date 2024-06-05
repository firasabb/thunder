@extends('admin.layouts.panel')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$report->id}}</div>

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

                    <form method="POST" action="{{ route('admin.edit.report', ['id' => $report->id]) }}" class="edit-form-confirm">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <textarea class="form-control enabled-disabled" name="name" placeholder="{{ __('admin.body') }}" disabled>{{ $report->body }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row info-row">
                            <div class="col">
                                <h5>{{ __('admin.reported by') }}:</h1>
                                <a href="{{ route('admin.show.user', ['id' => $report->user_id]) }}">{{ $report->user_id }}</a>
                                <h5>{{ __('admin.Created at') }}:</h1>
                                <p>{{ $report->created_at }}</p>
                                <h5>{{ __('admin.Updated at') }}:</h1>
                                <p>{{ $report->updated_at }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="block-button">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.delete.report', ['id' => $report->id]) }}" method="POST" class="delete-form-2 delete-form-confirm">
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
