<div>
    @foreach($conferences as $conference)
        <div class="mb-3">
            <x-forms.dropdown-input :teams="$teams" :conference="$conference" />
        </div>
    @endforeach
    <x-forms.dropdown-input :teams="$teams" />
    <script>
        // JavaScript to toggle the dropdown
        var dropdownGroups = document.querySelectorAll('.dropdown-group');

        dropdownGroups.forEach((group) => {
            var dropdownButton = group.querySelector('.select-dropdown-btn');
            var dropdownMenu = group.querySelector('.select-dropdown');
            var searchInput = group.querySelector('.search-input');
            var teamsInput = group.querySelector('.teams_input');
            var items = dropdownMenu.querySelectorAll('button');
            var selectedTeams = [];
            let isOpen = false;
            let isMultiple = dropdownMenu.classList.contains('multiple');

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
                    if(item.classList.contains('active')){
                        item.classList.remove('active');
                        return;
                    } else {
                        item.classList.add('active');
                        item.focus();
                    }
                    // Check if the dropdown is multiple
                    if (isMultiple) {
                        dropdownButton.classList.add('flex-col');
                        selectedTeams.push(item.outerHTML);
                        dropdownButton.innerHTML = selectedTeams.join('<br>');
                    } else {
                        selectedTeams = item.outerHTML;
                        dropdownButton.innerHTML = selectedTeams;
                        teamsInput.value = selectedTeams;
                        toggleDropdown();
                    }
                });
            });
        });
    </script>
</div>