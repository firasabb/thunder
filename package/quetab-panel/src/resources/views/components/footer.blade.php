<footer class="bg-white dark:bg-gray-900">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('images/logo-black.png') }}" class="h-8 me-3" />
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Resources</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li>
                            <a href="{{ route('page.show', ['url' => 'contact-us']) }}" class="hover:underline">{{ __('main.contact us') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li>
                            <a href="{{ route('page.show', ['url' => 'privacy-policy']) }}" class="hover:underline">{{ __('main.privacy policy') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('page.show', ['url' => 'terms-of-service']) }}" class="hover:underline">{{ __('main.terms of service') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('page.show', ['url' => 'cookie-policy']) }}" class="hover:underline">{{ __('main.cookie policy') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">&copy;{{ date("Y") }}. All rights reserverd
            </span>
        </div>
        <div>
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">Created with <a href="" class="text-blue-500">Quetab Panel</a>
            </span>
        </div>
    </div>
</footer>



@guest
    @include('cookie-consent::index')
@endguest