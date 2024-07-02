<x-admin-layout>
    <div>
        <div class="p-4 sm:ml-64">
            <h2 class="mb-6 text-xl">{{ 'Entry #' . $entry->id }}</h2>
            <div class="w-full">
                <div class="mb-4">
                    <span class="text-sm font-semibold">{{ __('admin.email') }}: </span>
                    <span class="text-sm">{{ $entry->email }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-semibold">{{ __('admin.phone') }}: </span>
                    <span class="text-sm">{{ $entry->phone }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-semibold">{{ __('admin.created at') }}: </span>
                    <span class="text-sm">{{ $entry->created_at }}</span>
                </div>
                <div class="mb-4">
                    <span class="text-sm font-semibold">{{ __('admin.confirmation code') }}: </span>
                    <span class="text-sm">{{ $entry->confirmation_code }}</span>
                </div>
                <div class="mb-4">
                    <a href="{{ route('entry.pdf', ['entry' => $entry->uuid]) }}" target="_blank"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('admin.download pdf') }}</a>
                </div>
            </div>
        </div>
    </div>

    
</x-admin-layout>
