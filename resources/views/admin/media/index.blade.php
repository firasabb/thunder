<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="py-5 px-8 col-span-3">
                <div>
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-white">
                        {{ __('admin.media library') }}
                    </h1>
                </div>
                <div class="mt-5 grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($medias as $media)
                        <x-cards.media :media="$media" />
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $medias->links() }}
                </div>
            </div>
            <div>
                <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="py-5 px-8">
                        <div>
                            <h1 class="font-semibold text-xl text-gray-800 dark:text-white">
                                {{ __('admin.upload media') }}
                            </h1>
                        </div>
                        <div class="mt-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('admin.title') }}
                            </label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mt-4">                  
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    </div>
                                    <input id="dropzone-file" name="mediaFile" type="file" class="dropzone-file hidden" />
                                </label>
                            </div> 
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                {{ __('admin.upload') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>  
    
    <script>

        var dropzoneFiles = document.querySelectorAll('.dropzone-file');
        dropzoneFiles.forEach(function(dropzoneFile) {
            dropzoneFile.addEventListener('change', function() {
                let uploadParagraph = this.parentElement.querySelector('p');
                uploadParagraph.innerHTML = this.files[0].name;
                
                // Update the title if blank
                let title = document.getElementById('title');
                if (title.value === ''){
                    title.value = this.files[0].name;
                }
            });
        });


    </script>
</x-admin-layout>
