<div>
    @foreach($conferences as $conference)
        <div class="mb-10">
            <x-forms.dropdown-input :teams="$teams" :conference="$conference" />
        </div>
    @endforeach
    <x-forms.dropdown-input :teams="$teams" />
    <script>
        // JavaScript to toggle the dropdown
        var dropdownGroups = document.querySelectorAll('.dropdown-group');
        var domParser = new DOMParser();

        dropdownGroups.forEach((group) => {
            var dropdownButton = group.querySelector('.select-dropdown-btn');
            var dropdownMenu = group.querySelector('.select-dropdown');
            var searchInput = group.querySelector('.search-input');
            var teamsInput = group.querySelector('.teams_input');
            var selectedTeamsDiv = group.querySelector('.selected-teams');
            var selectedItems = selectedTeamsDiv.querySelectorAll('.active');
            var items = group.querySelectorAll('.item-button');
            var selectedTeams = [];
            let isOpen = false;
            let isMultiple = dropdownMenu.classList.contains('multiple');
            var maxTeams = 7;

            // Function to toggle the dropdown state
            function toggleDropdown() {
                isOpen = !isOpen;
                dropdownMenu.classList.toggle('hidden', !isOpen);
            }

            dropdownButton.addEventListener('click', () => {
                toggleDropdown();
            });

            // Add event listener to filter items based on input
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();
                const items = dropdownMenu.querySelectorAll('button');

                items.forEach((item) => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            items.forEach((item) => {
                item.addEventListener('click', () => {

                    console.log('clicked');
                    // get the team id from the data tag
                    let teamId = item.getAttribute('data-team');
                    
                    console.log(item.parentElement.classList);
                    // Check if the item is in the dropdown or in the button
                    if(item.parentElement.classList.contains('select-dropdown-btn')) {
                        // find the item in the selectedTeams by teamid and remove it
                        selectedTeams = selectedTeams.filter((team) => {
                            return team.getAttribute('data-team') !== teamId;
                        });
                        dropdownButton.innerHTML = selectedTeams.join('<br>');
                        
                    }


                    if(item.classList.contains('active')){
                        item.classList.remove('active');
                        return;
                    } else {
                        item.classList.add('active');
                        item.focus();
                    }
                    // Check if the dropdown is multiple
                    if (isMultiple) {
                        if (selectedTeams.length >= maxTeams) {
                            return;
                        }
                        selectedTeams.push(item.outerHTML);
                        item.classList.toggle('hidden');
                        teamsInput.value = selectedTeams.map((team) => {
                            team = domParser.parseFromString(team, 'text/html').body.firstChild;
                            return team.getAttribute('data-team');
                        }).join(',');

                        // add the selected team to the selected teams div
                        selectedTeamsDiv.innerHTML = selectedTeams.join('');
                    } else {
                        selectedTeams = item.outerHTML;
                        selectedTeamsDiv.innerHTML = selectedTeams;
                        teamsInput.value = teamId;
                        toggleDropdown();
                    }
                });
            });

            document.addEventListener('click', (e) => {
                if (!group.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        
            selectedItems.forEach((item) => {
                item.addEventListener('click', () => {
                    item.classList.remove('active');
                });
            });
        
        });
        

    </script>
</div>