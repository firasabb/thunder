<x-app-layout>
    <div class="bg-cream">
		<div class="max-w-screen-xl px-8 mx-auto flex justify-center items-start relative z-50">
            <section class="">
                <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 z-10 relative">
                    <div class="mb-5">
                        <img class="mx-auto w-48 h-auto lg:w-64" src="{{ asset('images/logo.png') }}" alt="Road to Jansanity" />
                    </div>
                    <h1 class="mb-4 text-2xl font-extrabold tracking-tight leading-none text-gray-900 md:text-3xl dark:text-white">Welcome to the Road to Jansanity $1 Million Dollar Playoff Challenge!</h1>
                    <p class="mb-8 text-md font-normal text-gray-500 md:text-lg sm:px-16 lg:px-48 dark:text-gray-200 text-left">
                        For the first time ever college football has a legitimate end of season tournament.      
                        <br>
                        12 Teams will earn their spot to compete for the chance to play on January 20th in the National Championship.
                        <br>
                        <br>
                        We call this new season of fun <span class="text-blue-600 font-bold">Jansanity</span>!
                        <br>
                        <br>
                        We created a way for you to get involved and have a chance to win $1 Million.                        <br>
                        <br>
                        <span class="font-bold">What’s the Challenge?</span>
                        <br>
                        1) Pick the 12 teams that will enter the college football playoffs (no specific order or seed).
                        <br>
                        2) Pick the team that will come out on top and be the National Champion.
                        <br>
                        <br>
                        Offer your email to be one of the first to be notified when the contest goes live!
                    </p>
                    <form class="w-full max-w-md mx-auto">   
                        <label for="default-email" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Subscribe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 rtl:inset-x-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                    <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                                    <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                                </svg>
                            </div>
                            <input type="email" id="default-email" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your email..." required />
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Subscribe</button>
                        </div>
                        <p id="success" class="mt-2 text-sm text-green-600 dark:text-green-500 hidden"><span class="font-medium">Awesome!</span> You will receive from us soon!</p>
                        <p id="failed" class="mt-2 text-sm text-red-600 dark:text-red-500 hidden"><span class="font-medium">Oops!</span> Something went wrong!</p>
                    </form>
                </div>
            </section>
		</div>
		<div class="text-white -mt-14 sm:-mt-24 lg:-mt-36 z-40 relative">
			<svg class="xl:h-40 xl:w-full" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
				<path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z" fill="currentColor"></path>
			</svg>
			<div class="bg-white w-full h-20 -mt-px"></div>
		</div>
	</div>

    <script type="module">
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('form').submit(function(e){
                e.preventDefault();
                var email = $('#default-email').val();
                var success = $('#success');
                var failed = $('#failed');

                $.ajax({
                    url: "{{ route('subscribe') }}",
                    method: 'post',
                    data: {
                        email: email
                    },
                    success: function(response){
                        success.removeClass('hidden');
                        failed.addClass('hidden');

                    },error: function(err){
                        failed.removeClass('hidden');
                        success.addClass('hidden');
                    }
                });
            });
        });
    </script>
</x-app-layout>