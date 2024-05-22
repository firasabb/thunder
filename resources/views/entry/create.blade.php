    @push('head_scripts')

        
    @endpush


    <x-app-layout>

        <div class="flex justify-center items-center py-5">
            <div class="container mx-auto w-100 w-4/12">
                <div class="mb-5">
                    <h1 class="text-2xl font-semibold text-gray-900">The Road To Jansanity $1 Million Playoff Challenge!</h1>
                </div>

                <div class="mb-10">
                    {!! $description !!}
                </div>

                <div class="mb-3">
                    <h1 class="text-xl font-semibold text-gray-900">Submit your Entry:</h1>
                </div>
                <div class="">
                    <div class="mb-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <span class="text-xs text-gray-500">A confirmation number will be sent to your email after you submit your entry.</span>
                        <input type="text" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-5">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                +1
                            </span>
                            <input type="text" id="phone" name="phone"
                                class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <h1 class="text-lg font-semibold text-gray-600">Select your Teams:</h1>
                    </div>

                    <x-forms.dropdown :teams="$teams" :conferences="$activeConferences"></x-forms.dropdown>

                    <div class="my-5">
                        <button type="button" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Submit</button>
                    </div>

                </div>
            </div>
        </div>

    </x-app-layout>

