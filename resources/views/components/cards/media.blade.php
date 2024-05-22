<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between px-4 pt-4">
        <button data-copy-to-clipboard-target="{{ $media->url }}" class="inline-block text-gray-900 dark:text-gray-400 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700 rounded-lg py-2 px-2.5 inline-flex items-center justify-center bg-white border-gray-200 border">
            <span id="default-message" class="inline-flex items-center">
                <svg class="w-3 h-3 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                </svg>
                <span class="text-xs font-semibold">Copy</span>
            </span>
            <span id="success-message" class="hidden inline-flex items-center">
                <svg class="w-3 h-3 text-blue-700 dark:text-blue-500 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                <span class="text-xs font-semibold text-blue-700 dark:text-blue-500">Copied</span>   
            </span>
        </button>
        <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
            <span class="sr-only">Open dropdown</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
            </svg>
        </button>
        <!-- Media Card Dropdown menu -->
        <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2" aria-labelledby="dropdownButton">
                <li>
                    <form method="POST" action="{{ route('admin.media.delete', ['id' => $media->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="block px-4 py-2 text-sm text-red-700 hover:text-red-500">
                            {{ __('admin.delete') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex flex-col items-center pb-10 mx-5">
        <img class="h-auto max-w-full rounded-md shadow-lg mb-3" src="{{ $media->url }}" alt="{{ $media->title }}"/>
        <h5 class="mb-1 text-xs md:text-sm font-medium text-gray-900 dark:text-white">{{ $media->title }}</h5>
    </div>
    <script>

        var clipboard = FlowbiteInstances.getInstance('CopyClipboard', 'npm-install-copy-text');

        var $defaultMessage = document.getElementById('default-message');
        var $successMessage = document.getElementById('success-message');

        clipboard.updateOnCopyCallback((clipboard) => {
            showSuccess();

            // reset to default state
            setTimeout(() => {
                resetToDefault();
            }, 2000);
        })

        var showSuccess = () => {
            $defaultMessage.classList.add('hidden');
            $successMessage.classList.remove('hidden');
        }

        var resetToDefault = () => {
            $defaultMessage.classList.remove('hidden');
            $successMessage.classList.add('hidden');
        }


    </script>
</div>
