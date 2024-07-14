<x-app-layout>
    <div class="bg-cream">
		<div class="max-w-screen-xl px-8 mx-auto flex justify-center items-start relative z-50">
            <section class="">
                <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 z-10 relative">
                    <div class="mb-10">
                        <img class="mx-auto w-48 h-auto lg:w-96 rounded-lg" src="{{ asset('images/logo.jpg') }}" alt="Road to Jansanity" />
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
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('entry.create') }}" target="_blank"
                            class="lg:mx-0 bg-gradient-to-br from-pink-500 to-orange-400 text-white text-xl font-bold rounded-full py-4 px-9 focus:outline-none transform transition hover:scale-110 duration-300 ease-in-out">
                                Enter now
                        </a>
                    </div>
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