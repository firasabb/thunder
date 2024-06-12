<div class="">
    @php
        if($multiple == 'true'){
            $multiple = 'multiple';
        } else {
            $multiple = '';
        }

        if(isset($conference) && $conference){
            $teams = $conference->teams()->get();
        }
    @endphp
    <div>
        @if(isset($title) && $title)
            <span class="mr-2 text-sm font-medium">{{ $title }}</span>
        @else
            @if(isset($conference))
                <span class="mr-2 text-sm font-medium">Choose {{ $conference->name }} Team</span>
            @endif
        @endif
    </div>
    <div class="relative group dropdown-group">
        <div class="selected-teams grid grid-flow-row-dense grid-cols-3 bg-white my-5 rounded-md">

        </div>
        <button type="button" class="select-dropdown-btn inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
            @if(isset($title) && $title)
                <span class="mr-2">{{ $title }}</span>
            @else
                @if(isset($conference))
                    <span class="mr-2">Choose {{ $conference->name }} Team</span>
                @endif
            @endif
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div class="{{ $multiple }} select-dropdown hidden h-80 overflow-scroll w-full absolute left-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1 z-10">
            <!-- Search input -->
            <input id="search-input" class="search-input block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none" type="text" placeholder="Search items" autocomplete="off">
            <!-- Dropdown content goes here -->
            @foreach($teams as $team)
                <button type="button" class="item-button block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md" data-team="{{$team->id}}">
                    @if($team->logo_url)
                        <img src="{{ $team->logo_url }}" class="w-5 h-5 inline-block mr-2">
                    @endif
                    <span>{{ $team->name }}</span>
                </button>
            @endforeach

            @if(isset($conference))
                <input class="teams_input" type="hidden" name="{{ $conference->abbreviation }}" value="">
            @elseif(isset($inputName) && $inputName)
                <input class="teams_input" type="hidden" name="{{ $inputName }}" value="">
            @endif
        </div>
    </div>

</div>