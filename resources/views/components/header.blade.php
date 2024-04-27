

<header>
    <nav class="bg-dark dark:bg-white w-full z-20 top-0 start-0">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-2">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <x-application-logo class="fill-white width-7" />
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-2 md:p-0 font-medium rounded-lg md:space-x-3 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                    <li>
                        <a href="{{ url('/') }}" class="block py-2 px-3 text-white rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-300" aria-current="page">
                            {{__('main.home')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.show', ['url' => 'contact-us']) }}"
                            class="block py-2 px-3 text-white  rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-300">
                            {{ __('front.contact') }}
                        </a>
                    </li>
                </ul>

                <ul class="flex flex-col p-2 md:p-0 font-medium rounded-lg md:space-x-3 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                @if(Auth::check())

                    @php
                        $user = Auth::user();

                        $username = $user->username;
                        // Check if there is unseen messages
                        $hasUnseenMessages = $user->hasUnseenMessages();

                    @endphp

                    <li>
                        <a href="{{ route('chat.channels.index') }}" class="block py-2 px-3 text-white  rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-300">
                            {{ __('chat.messages') }}
                            @if($hasUnseenMessages)
                                <span class="position-absolute top-0 start-75 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- Auth Dropdown -->
                    <li>
                        <button id="authDropDownLink"
                            data-dropdown-toggle="authDropDown" 
                            class="flex items-center justify-between w-full py-2 px-3 text-white rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-300">
                                {{ $username }} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="authDropDown" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-47 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                                @if($user->hasRole('expert'))
                                    <li>
                                        <a href="{{ route('user.seller.earnings') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            @php
                                                $balance = $user->balance / 100;
                                            @endphp
                                            ${{ $balance }}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('user.dashboard') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.profile', ['username' => $username]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('user.my profile') }}</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ __('auth.logout') }}</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <!-- Auth Dropdown -->


                    <!-- Create Dropdown -->
                    <li>
                        <button id="createDropDownLink"
                            data-dropdown-toggle="createDropDown" 
                            class="flex items-center justify-between w-full py-2 px-3 text-white rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-300">
                                {{ __('main.create') }} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div id="createDropDown" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-47 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="{{ route('projects.create') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Project</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.create.collection') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('main.study set') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('item.create', ['type' => 'flashcards']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('main.flashcards') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.create.question') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('main.ask question') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Create Dropdown -->


                    @else

                        <li>
                            <a href="{{ route('register') }}" class="block py-2 px-3 text-white  rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-300">
                                {{ __('auth.sign up') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="block py-2 px-3 text-white  rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-300">
                                {{ __('auth.sign in') }}
                            </a>
                        </li>

                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>