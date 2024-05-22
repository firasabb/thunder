@extends('admin.layouts.panel')


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center search-row">
            <div class="col search-col">
                <form method="post" action="{{ route('admin.search.reports') }}">
                    {!! csrf_field() !!}
                    <div class="row" >
                        <div class="col">
                            <input type='number' name='id' placeholder="{{ __('admin.ID') }}" class="form-control" value="{{ Request::get('id') ?? '' }}"/>
                        </div>
                        <div class="col">
                            <input type='text' name='name' placeholder="{{ __('admin.title') }}" class="form-control" value="{{ Request::get('name') ?? '' }}"/>
                        </div>
                        <div class="col-sm-1">
                            <input type='submit' value="{{ __('admin.search') }}" class="btn btn-primary"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('main.reports') }}</div>

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
                                    <a class="a-no-decoration"  href="{{ route('admin.index.reports', ['order' => 'id', 'desc' => !$desc]) }}">{!! $order == 'id' && $desc ? '&#8639;' : '&#8642;' !!} {{ __('admin.ID') }}</a>
                                </th>
                                <th>
                                    {{ __('admin.body') }}
                                </th>
                                <th>
                                    {{ __('admin.reportable id') }}
                                </th>
                                <th>
                                    {{ __('admin.reportable type') }}
                                </th>
                                <th>
                                    {{ __('admin.reported by') }}
                                </th>
                                <th>
                                    {{ __('admin.created') }}
                                </th>
                                <th class="td-actions">
                                    {{ __('admin.actions') }}
                                </th>   
                            </tr>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>
                                        {{ $report->id }}
                                    </td>
                                    <td>
                                        {{ Str::limit($report->body, $limit = 10, $end = '...') }}
                                    </td>
                                    <td>
                                        {{ $report->reportable_id }}
                                    </td>
                                    <td>
                                        {{ $report->reportable_type }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.show.user', ['id' => $report->user_id]) }}">{{ $report->user_id }}</a>
                                    </td>
                                    <td>
                                        {{ $report->created_at->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        <div class="td-actions-btns">
                                            <a href="{{ route('admin.show.report', ['id' => $report->id]) }}" class="btn btn-success">{{ __('admin.show/edit') }}</a>
                                            <form action="{{ route('admin.delete.report', ['id' => $report->id]) }}" method="POST" class="delete-form-1 delete-form-confirm">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-danger" type="submit">{{ __('admin.delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $reports->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
