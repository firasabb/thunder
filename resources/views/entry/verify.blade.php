<x-app-layout>
    <div class="flex justify-center items-center py-5">
        <div class="container mx-auto w-100 w-4/12">
            <div>
                <div class="mb-5">
                    <h1 class="text-2xl font-semibold text-gray-900">Please verify your phone number to complete your submission</h1>
                </div>

                <div class="mb-10">
                    <p class="text-gray-700 text-sm mb-5">We have sent a verification code to your phone number. Please enter the code below to complete your submission.</p>
                    <form action="{{ route('entry.verify.store', ['entry' => $entry->uuid]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="code" class="block text-sm font-bold text-gray-700">Verification Code</label>
                            <input type="text" name="code" id="code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="w-full bg-blue-700 hover:bg-sky-700 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Verify
                            </button>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>

</x-app-layout>

