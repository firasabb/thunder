
<x-admin-layout>
    <div class="container">
        @if (session('status'))
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="text-center">
            <h1>{{ __('main.totals') }}</h1>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3 mb-5 mt-3">
            <div class="col">
                <a href="{{ route('admin.users.index') }}">
                    <div class="dashboard-card" style="background-color: #e2f8fb">
                        <h3>{{ $totalUserCount }}</h3>
                        <h3>{{ __('admin.users') }}</h3>
                    </div>
                </a>
                <div>
                    <canvas id="userChart"></canvas>
                </div>
            </div>
            <div class="col">
                <a href="{{ route('admin.messages.index') }}">
                    <div class="dashboard-card" style="background-color: #f7fff9">
                        <h3>{{ $totalMessageCount }}</h3>
                        <h3>{{ __('chat.messages') }}</h3>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('admin.pages.index') }}">
                    <div class="dashboard-card" style="background-color: #fdfbf4">
                        <h3>{{ $totalPageCount }}</h3>
                        <h3>{{ __('main.pages') }}</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="row my-5">
            <div class="col">
                <div class="padding-2 shadow-sm" style="min-height: 30rem">
                    <div>
                        <h4>{{ __('admin.last support messages') }}</h4>
                    </div>
                    <div class="mt-5">
                        @if(!$lastMessages->isEmpty())
                            <table class="table">
                                <tbody>
                                    @foreach($lastMessages as $lastMessage)
                                        <tr>
                                            <th scope="row">
                                                {{ $lastMessage->id }}
                                            </th>
                                            <td>
                                                {{ Str::limit($lastMessage->body, 20, '...') }}
                                            </td>
                                            <td>
                                                {{ $lastMessage->created_at }}
                                            </td>
                                            <td>
                                                <a class="btn btn-light" target="_blank" 
                                                href="{{ route('admin.show.message', ['id' => $lastMessage->id]) }}">
                                                    {{ __('main.view') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>{{ __('admin.no support messages') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

@push('footer_scripts')


@endpush