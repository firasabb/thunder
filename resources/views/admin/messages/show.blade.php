<x-admin-layout>
    <div>
        <div class="p-4 sm:ml-64">
            <h2 class="mb-6 text-xl">{{ __('admin.support message') . ' #' . $message->id }}</h2>
            <div class="w-full">
                <div class="mb-4">
                    <span class="text-2xl font-semibold">{{ $message->subject }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-semibold">{{ __('admin.email') }}:</span>
                    <span class="text-sm">{{ $message->email }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-semibold">{{ __('admin.phone') }}:</span>
                    <span class="text-sm">{{ $message->phone }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-semibold">{{ __('admin.created at') }}:</span>
                    <span class="text-sm">{{ $message->created_at }}</span>
                </div>
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('admin.body') }}</label>
                    <textarea
                        name="body"
                        id="body"
                        rows="15"
                        class="disabled mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">{{ $message->body }}</textarea>
                </div>
            </div>
        </div>
    </div>

    
</x-admin-layout>
