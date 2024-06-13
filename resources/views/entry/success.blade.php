<x-app-layout>
    <div class="flex justify-center items-center py-5">
        <div class="container mx-auto w-100 w-8/12">
            <div class="mb-5 text-center">
                <h1 class="text-2xl font-semibold text-gray-900 pt-10">
                    You have successfully submitted your entry!
                    <svg class="w-6 h-6 text-green-600 dark:text-white inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                    </svg>
                </h1>

                <div class="mt-5">
                    <div>
                        <p class="text-gray-700 text-sm mb-5">
                            Thank you for submitting your entry to the Road To Jansanity $1 Million Playoff Challenge!
                            <br>
                            <span class="text-gray-900 font-bold">Your confirmation number is: {{ $entry->confirmation_code }}</span></p>
                        <p class="text-gray-700 text-sm mb-5">The confirmation number has been also sent to your email. Please keep this number for your records.</p>
                        <div class="mt-10">
                            <a href="{{ route('entry.pdf', ['entry' => $entry->uuid]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download Confirmation File</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>

