<x-app-layout>
    <div class="flex justify-center items-center py-5">
        <div class="container mx-auto w-100 w-8/12 md:w-4/12">
            <div class="mb-5">
                <h1 class="text-2xl font-semibold text-gray-900">Contact Us</h1>
            </div>

            <div class="mb-10">
                <form action="{{ route('page.contact') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="name" class="block text-sm text-gray-600">Name</label>
                        <input type="text" name="name" id="name" class="w-full border border-gray-300 p-2 rounded mt-1" value="{{ old('name') }}">
                    </div>
                    <div class="mb-5">
                        <label for="email" class="block text-sm text-gray-600">Email</label>
                        <input type="email" name="email" id="email" class="w-full border border-gray-300 p-2 rounded mt-1" value="{{ old('email') }}">
                    </div>
                    <div class="mb-5">
                        <label for="phone" class="block text-sm text-gray-600">Phone</label>
                        <input type="text" name="phone" id="phone" class="w-full border border-gray-300 p-2 rounded mt-1" value="{{ old('phone') }}">
                    </div>
                    <div class="mb-5">
                        <label for="subject" class="block text-sm text-gray-600">Subject</label>
                        <input type="text" name="subject" id="subject" class="w-full border border-gray-300 p-2 rounded mt-1" value="{{ old('subject') }}">
                    </div>
                    <div class="mb-5">
                        <label for="message" class="block text-sm text-gray-600">Message</label>
                        <textarea name="message" id="message" class="w-full border border-gray-300 p-2 rounded mt-1" rows="4">{{ old('message') }}</textarea>
                    </div>
                    <div class="mb-5">
                        <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded">Submit</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>

</x-app-layout>

