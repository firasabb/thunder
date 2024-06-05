<x-admin-layout>
    @php
        $id = $setting ? $setting->id : null;
        $name = $setting ? $setting->name : old('name');
        $value = $setting ? $setting->value : old('value');

    @endphp
    <div>
        <div class="p-4 sm:ml-64">
            <h2 class="mb-4 text-xl">{{ __('admin.create setting') }}</h2>
            <div class="w-full">
                <form action="{{ route('admin.settings.store', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('admin.name') }}</label>
                        <input 
                            type="text"
                            name="name"
                            id="name"
                            value="{{ $name }}"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('admin.value') }}</label>
                        <textarea
                            name="value"
                            id="value"
                            rows="15"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">{{ $value }}</textarea>
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
