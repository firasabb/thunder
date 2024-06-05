@push('head_scripts')

        
@endpush


<x-app-layout>

    <div class="flex justify-center items-center py-5">
        <div class="container mx-auto w-100 w-4/12">
            <div class="mb-3">
                <h3 class="text-lg font-medium text-gray-900 mb-5"><span class="text-red-600">Only</span> videos, have <span class="text-red-600">NOT</span> been displayed to the public or submitted anywhere else, will be accepted.</h3>
                <h1 class="text-2xl font-semibold text-gray-900">Submit your Video:</h1>
            </div>
            <div class="">
                <!-- Video Title -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" 
                        name="title" 
                        id="title" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder="" 
                        required />
                    <label for="title"
                        class="peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Video Title
                    </label>
                </div>

                <!-- Video Description -->
                <div class="relative z-0 w-full mb-5 group">
                    <textarea name="description" 
                        id="description" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder="" 
                        required></textarea>
                    <label for="description"
                        class="peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Video Description
                    </label>
                </div>

                <!-- First & Last Name -->
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text"
                            name="first_name" 
                            id="first_name" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder="" 
                            required />
                        <label for="first_name" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            First name
                        </label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text"
                            name="last_name" 
                            id="last_name" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder="" 
                            required />
                        <label for="last_name" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Last name
                        </label>
                    </div>
                </div>

                <!-- Email & Phone -->
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" 
                            name="email" 
                            id="email" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder="" 
                            required />
                        <label for="email" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Email
                        </label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text"
                            name="phone" 
                            id="phone" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder=" " 
                            required />
                        <label for="phone" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Phone
                        </label>
                    </div>
                </div>

                <!-- Mailing Address -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" 
                        name="address_1" 
                        id="address_1" 
                        class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder="" 
                        required />
                    <label for="address_1"
                        class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Address Line 1
                    </label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" 
                        name="address_2" 
                        id="address_2" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                        placeholder="" 
                        required />
                    <label for="address_2"
                        class="peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Address Line 2
                    </label>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" 
                            name="city" 
                            id="city" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder="" 
                            required />
                        <label for="city" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            City
                        </label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text"
                            name="state" 
                            id="state" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder=" " 
                            required />
                        <label for="state" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            State
                        </label>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" 
                            name="zipcode" 
                            id="zipcode" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder="" 
                            required />
                        <label for="zipcode" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Zip Code
                        </label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text"
                            name="country" 
                            id="country" 
                            class="required block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder=" " 
                            required />
                        <label for="country" 
                            class="required peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Country
                        </label>
                    </div>
                </div>

                <!-- people count -->
                <div class="mb-10 mt-5">
                    <div class="relative z-0 w-full group">
                        <input type="password" name="floating_people" id="floating_people" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Number of people seen or heard in the video</label>
                    </div>
                </div>

                <!-- Select Age -->
                <form class="max-w-sm mx-auto mb-10">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">How old are you?</label>
                    <select id="countries" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="18-30">18-30</option>
                        <option value="31-50">31-50</option>
                        <option value="51-60">51-60</option>
                        <option value="61+">61+</option>
                    </select>
                </form>

                <!-- Checkboxes 1 -->
                <div>
                    <div class="flex items-center mb-4">
                        <input checked id="membership-checkbox" type="checkbox" name="membership" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                        <label for="membership-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">FREE Video Club Membership. Join our FREE Video Club email list for updates </label>
                    </div>
                    <div class="mb-5">
                        <div class="flex items-center mb-2">
                            <input id="terms-checkbox" type="checkbox" name="terms" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                            <label for="terms-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Terms of Use</label>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">By checking this box, I hereby certify and confirm the following: I am at least 18 years of age. I have read and agree to the Terms of Use, which include that I am exclusively transferring all of my rights in and to the submitted content to Video Club, worldwide, in all media, in perpetuity. </span>
                    </div>
                </div>

                <!-- Upload Video -->
                <div class="my-3">
                    <div class="text-center">
                        <h1 class="text-lg font-semibold text-gray-700">Video Ownership</h1>
                    </div>
                </div>

                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">1280 x 720 px, MP4 (MAX. 30 Seconds, 50 MBs)</p>
                        </div>
                        <input id="dropzone-file" type="file" name="video" class="required hidden dropzone-file" accept="video/mp4,video/x-m4v,video/*" />
                    </label>
                </div> 

                <!-- Checkboxes 2 -->
                <div class="mt-10">
                    <div class="flex items-center mb-4">
                        <input id="ownership-checkbox" type="checkbox" name="ownership" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                        <label for="ownership-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"> I am the OWNER of the video I submitted.</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input id="recorded-checkbox" type="checkbox" name="recorded" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                        <label for="recorded-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I RECORDED this video.</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input id="unique-checkbox" type="checkbox" name="unique" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                        <label for="unique-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I have NOT submitted this video anywhere else .</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input id="real-checkbox" type="checkbox" name="real" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                        <label for="real-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">The events in the video are REAL (NOT STAGED).</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex mt-10">
                    <button id="submit-btn" class="text-white cursor-not-allowed bg-gradient-to-br from-pink-200 to-orange-300 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" disabled="disabled">Submit</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            // Find inputs with the class 'required' and if all of them are filled out, remove the 'disabled' from the submit button
            const requiredInputs = document.querySelectorAll('.required');
            requiredInputs.forEach(input => {
                input.addEventListener('input', function() {
                    let allFilled = true;
                    requiredInputs.forEach(requiredInput => {
                        if (requiredInput.value === '') {
                            allFilled = false;
                        }
                    });
                    toggleSubmit(allFilled);
                });
            });
        });
        function toggleSubmit(active){
            const submitButton = document.querySelector('#submit-btn');

            if (active){
                submitButton.removeAttribute('disabled');
                submitButton.classList.remove('cursor-not-allowed', 'from-pink-200', 'to-orange-300');
                submitButton.classList.add('from-pink-500', 'to-orange-400');
            } else {
                submitButton.setAttribute('disabled', 'disabled');
                submitButton.classList.add('cursor-not-allowed', 'from-pink-200', 'to-orange-300');
                submitButton.classList.remove('from-pink-500', 'to-orange-400');
            }
        }


        // Dropzone file upload
        var dropzoneFiles = document.querySelectorAll('.dropzone-file');
        dropzoneFiles.forEach(function(dropzoneFile) {
            dropzoneFile.addEventListener('change', function() {
                let uploadParagraph = this.parentElement.querySelector('p');
                uploadParagraph.innerHTML = this.files[0].name;
                console.log(uploadParagraph);
            });
        });

    </script>

</x-app-layout>

