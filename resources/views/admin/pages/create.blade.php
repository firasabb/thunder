<x-admin-layout>
    @php
        $id = $page ? $page->id : null;
        $title = $page ? $page->title : old('title');
        $url = $page ? $page->url : old('url');
        $status = $page ? $page->status : old('status');
        $body = $page ? $page->body : old('body');
        $featured = $page ? $page->featured : old('featured');
    @endphp
    <div>
        <div class="p-4 sm:ml-64">
            <h2 class="mb-4 text-xl">{{ __('admin.create page') }}</h2>
            <div class="w-full">
                <form action="{{ route('admin.pages.store', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('admin.title') }}</label>
                        <input 
                            type="text"
                            name="title"
                            id="title"
                            value="{{ $title }}"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('admin.URL') }}</label>
                        <input 
                            type="text" 
                            name="url" 
                            id="url" 
                            value="{{ $url }}"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('admin.status') }}</label>
                        <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            @foreach($availableStatuses as $availableStatus)
                                <option value="{{ $availableStatus }}" {{ $availableStatus == $status ? 'selected' : '' }}>{{ __('admin.' . $availableStatus) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('admin.body') }}</label>
                        <textarea
                            name="body"
                            id="body"
                            rows="15"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">{{ $body }}</textarea>
                    </div>
                    <div class="mb-4">
                        @if($featured)
                            <div>
                                <img src="{{ asset($featured->getUrl()) }}" alt="{{ $title }}" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <div>
                            <label for="featured_input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.featured image') }}</label>
                            <input id="featured_input"
                                type="file"
                                name="featured"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        </div>
                    </div>
                    <div class="mb-4">
                        <button 
                            type="submit" 
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            {{ __('admin.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</x-admin-layout>
