<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-header"><a href="{{ route('page.show', ['url' => $page->url]) }}" target="_blank">{{ $page->title }}</a></div>

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

                        <form method="POST" action="{{ route('admin.edit.page', ['id' => $page->id]) }}" class="edit-form-confirm" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            {!! method_field('PUT') !!}

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control enabled-disabled" type="text" name="title"  value="{{ $page->title }}" placeholder="{{ __('admin.title') }}" disabled/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <input class="form-control enabled-disabled" type="text" name="url"  value="{{ $page->url }}" placeholder="{{ __('admin.URL') }}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-5">
                                <div class="col">
                                    <div class="form-group">
                                        <textarea class="tinymce-textarea enabled-disabled" rows="20" name="body" disabled>{{ $page->body }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <select class="form-control enabled-disabled" name="status" disabled>
                                            <option value="published" {{ $page->status == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="draft" {{ $page->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col">
                                    <div class="mb-3">
                                        <span>{{ __('main.featured image') }}</span>
                                    </div>
                                    <div>
                                        <img class="w-25 mb-2" id="featured-img" src="{{ $page->featured_full_url }}">
                                    </div>
                                    <div>
                                        <input id="featured-input" class="enabled-disabled" type="file" name="featured" disabled>
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
                                    <p>{{ $page->created_at }}</p>
                                    <h5>{{ __('admin.Updated at') }}:</h1>
                                    <p>{{ $page->updated_at }}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="block-button">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-lg" id="edit-button">{{ __('admin.edit') }}</button>
                        <form action="{{ route('admin.delete.page', ['id' => $page->id]) }}" method="POST" class="delete-form-2 delete-form-confirm">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="submit" class="btn btn-danger btn-lg">{{ __('admin.delete') }}</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){

            var featuredInput = $('#featured-input');
            var featuredImg = $('#featured-img');

            featuredInput.on('change', function(e){
                let file = featuredInput.prop('files')[0];
                featuredImg.attr('src', URL.createObjectURL(file));
            });

        });
    </script>
</x-admin-layout>
