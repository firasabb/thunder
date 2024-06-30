<div id="app">
    @php
        $postTeamsRoute = route('entry.store.temp', ['entry' => $entry]);
        $getEntryTeamsRoute = route('entry.teams', ['entry' => $entry]);
    @endphp
    @foreach($conferences as $conference)
        <div class="mb-10">
            <dropdown 
                get-teams-route="{{ route('teams.conference', ['conference' => $conference->abbreviation]) }}"
                post-teams-route="{{ $postTeamsRoute }}"
                conference="{{ $conference->toJson() }}" 
                multiple="" 
                input-name="" 
                />
        </div>
    @endforeach
    <div class="mb-10">
        <dropdown 
            title="Choose a Team from All Conferences"
            get-teams-route="{{ route('teams.conference', ['conference' => 'all']) }}"
            post-teams-route="{{ $postTeamsRoute }}"
            input-name="other"/>
    </div>
    <div class="mb-10">
        <dropdown 
            title="Choose 8 Teams from All Teams"
            get-teams-route="{{ route('teams.conference') }}"
            post-teams-route="{{ $postTeamsRoute }}"
            conference="" 
            multiple="true" 
            input-name="all"/>
    </div>
    <div class="mb-10">
        <dropdown 
            title="Choose the Championship Winner"
            post-teams-route="{{ $postTeamsRoute }}"
            get-entry-teams-route="{{ $getEntryTeamsRoute }}"
            input-name="winner"/>
    </div>

    <script>

        // JavaScript to toggle the dropdown
        var allSelectedTeams = [];
        var dropdownGroups = document.querySelectorAll('.dropdown-group');
        var winnerInput = document.querySelector('input[name="winner"]');
        var domParser = new DOMParser();
        var selectedTeams = [];

        function dropdownGroupClicked(){

            dropdownGroups.forEach((group) => {
                var dropdownButton = group.querySelector('.select-dropdown-btn');
                var dropdownMenu = group.querySelector('.select-dropdown');
                var searchInput = group.querySelector('.search-input');
                var teamsInput = group.querySelector('.teams_input');
                var selectedTeamsDiv = group.querySelector('.selected-teams');
                var selectedItems = selectedTeamsDiv.querySelectorAll('.item-button');
                var items = group.querySelectorAll('.item-button');
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
                    var searchTerm = searchInput.value.toLowerCase();

                    items.forEach((item) => {
                        const text = item.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });

                function itemClicked(){
                    items.forEach((item) => {
                        item.addEventListener('click', (e) => {
                            // get the team id from the data tag
                            let teamId = item.getAttribute('data-team');
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
                                selectedTeamsDiv.innerHTML = item.outerHTML;
                                teamsInput.value = teamId;
                                toggleDropdown();
                            }
                            AddRemoveAllSelectedItems(item);
                            selectedItemsOnClick();
                            // stop propagation
                            e.stopPropagation();
                        });
                    });
                }
                itemClicked();

                document.addEventListener('click', (e) => {
                    if (!group.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            
                function selectedItemsOnClick(){
                    selectedItems = selectedTeamsDiv.querySelectorAll('.item-button');
                    selectedItems.forEach((selectedItem) => {
                        selectedItem.addEventListener('click', () => {
                            items.forEach((item) => {
                                if(selectedItem.getAttribute('data-team') === item.getAttribute('data-team')){
                                    item.classList.remove('hidden');
                                }
                            });
                            // remove the item from selected teams
                            selectedTeams = selectedTeams.filter((team) => {
                                team = domParser.parseFromString(team, 'text/html').body.firstChild;
                                return team.getAttribute('data-team') !== selectedItem.getAttribute('data-team');
                            });

                            // remove the item from all selected teams
                            allSelectedTeams = allSelectedTeams.filter((team) => {
                                team = domParser.parseFromString(team, 'text/html').body.firstChild;
                                return team.getAttribute('data-team') !== selectedItem.getAttribute('data-team');
                            });
                            AddRemoveAllSelectedItems(selectedItem);
                            selectedItem.remove();
                        });
                    });
                }


                // Add or remove the item from all selected teams
                function AddRemoveAllSelectedItems(item){
                    if(allSelectedTeams.includes(item.outerHTML)){
                        allSelectedTeams = allSelectedTeams.filter((team) => {
                            teamDom = domParser.parseFromString(team, 'text/html').body.firstChild;
                            itemDom = domParser.parseFromString(item.outerHTML, 'text/html').body.firstChild;
                            return team !== item.outerHTML;
                        });
                    } else {
                        allSelectedTeams.push(item.outerHTML);
                    }
                    updateWinnerInput();
                }


                function updateWinnerInput(){

                    // Clear all the selected items in the winner input
                    let winnerDropdown = winnerInput.parentElement;
                    let winnerItems = winnerDropdown.querySelectorAll('.item-button');
                    if(winnerItems.length > 0){
                        winnerItems.forEach((item) => {
                            item.remove();
                        });
                    }

                    winnerInput.value = allSelectedTeams.map((team) => {
                        team = domParser.parseFromString(team, 'text/html').body.firstChild;
                        return team.getAttribute('data-team');
                    }).join(',');

                    // remove all the teams from the dropdown and add the selected teams
                    allSelectedTeams.forEach((team) => {
                        team = domParser.parseFromString(team, 'text/html').body.firstChild;
                        // check if the team has the class hidden and remove it
                        team.classList.remove('hidden');

                        // add the team to the dropdown before the input
                        winnerInput.before(team);
                        let parent = winnerInput.parentElement;
                        let teams = parent.querySelectorAll('.item-button');
                        // order the teams in the dropdown by name
                        teams = Array.from(teams).sort((a, b) => {
                            if(a.textContent < b.textContent) { return -1; }
                            if(a.textContent > b.textContent) { return 1; }
                            return 0;
                        });
                    });
                    dropdownGroupClicked();
                }
            });

        }

        dropdownGroupClicked();

    </script>
</div>