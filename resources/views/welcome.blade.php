<x-app-layout>
    <div class="bg-cream">
		<div class="max-w-screen-xl px-8 mx-auto flex flex-col lg:flex-row items-start relative z-50">
			<!--Left Col-->
			<div class="flex flex-col w-full lg:w-8/12 justify-center lg:pt-10 items-start text-center lg:text-left mb-5 md:mb-0">
				<h1 data-aos="fade-right" data-aos-once="true" class="my-4 text-3xl font-bold leading-tight text-darken">
					Welcome to The Road To Jansanity <span class="text-blue-700">$1 Million</span> Playoff Challenge!
				</h1>
				<p data-aos="fade-down" data-aos-once="true" data-aos-delay="300" class="leading-normal text-lg mb-8">
					Here’s your chance to showcase your college football expertise and compete for $1 million dollars.
				</p>
				<p  class="text-md text-gray-700 mb-10" data-aos="fade-left" data-aos-once="true" data-aos-delay="300">
					<span class="font-semibold">So, how does it work?</span>
					<br>
					It's simple….
					<br>
					You accurately pick the 12 playoff teams and eventual National Champion - you win $1M!
					<br>
					Are you up for the challenge? 
					<br>
					Join us on The Road To Jansanity!
				</p>
				<div data-aos="fade-up" data-aos-once="true" data-aos-delay="700" class="w-full md:flex items-center justify-center lg:justify-start md:space-x-5">
					<a href="{{ route('entry.create') }}" target="_blank"
					class="lg:mx-0 bg-gradient-to-br from-pink-500 to-orange-400 text-white text-xl font-bold rounded-full py-4 px-9 focus:outline-none transform transition hover:scale-110 duration-300 ease-in-out">
						Enter now
					</a>
				</div>
			</div>
			<!--Right Col-->
			<div class="w-full lg:w-6/12 mt-10 relative" id="girl">
				<img data-aos="fade-up" data-aos-once="true" class="w-8/12 md:8/12 mx-auto rounded-xl" src="images/hero.png" />
			</div>
		</div>
		<div class="text-white -mt-14 sm:-mt-24 lg:-mt-36 z-40 relative">
			<svg class="xl:h-40 xl:w-full" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
				<path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z" fill="currentColor"></path>
			</svg>
			<div class="bg-white w-full h-20 -mt-px"></div>
		</div>
	</div>
</x-app-layout>