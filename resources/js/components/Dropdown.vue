<template>
    <div class="">
        <div>
            <span v-if="title" class="mr-2 text-sm font-medium">{{ title }}</span>
            <span v-else class="mr-2">Choose {{ (conferenceJson.abbreviation == 'ACC' || conferenceJson.abbreviation == 'SEC') ?  conferenceJson.abbreviation : conferenceJson.name }} Conference Champion</span>
        </div>

        <div class="relative group dropdown-group">

            <div class="selected-teams grid grid-flow-row-dense grid-cols-3 bg-white my-5 rounded-md">
                <button v-for="selectedTeam in selectedTeams" :key="selectedTeam.id"
                    @click="unselectTeam(selectedTeam)"
                    type="button" 
                    class="relative item-button block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md" data-team="{{$selectedTeam->id}}">
                    <img :src="selectedTeam.logo_url" class="w-5 h-5 inline-block mr-2">
                    <span>{{ selectedTeam.name }}</span>
                    <span class="absolute top-0 right-0">
                        <svg class="w-4 h-4 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </button>
            </div>

            <button @click="openDropdown" type="button"
                class="select-dropdown-btn inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                    
                <span v-if="secondTitle" class="mr-2">{{ secondTitle }}</span>
                <span v-else-if="title" class="mr-2">{{ title }}</span>
                <span v-else class="mr-2">Choose {{ (conferenceJson.abbreviation == 'ACC' || conferenceJson.abbreviation == 'SEC') ?  conferenceJson.abbreviation : conferenceJson.name }} Conference Champion</span>
                
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div ref="dropdown" class="{{ multipleClass }} select-dropdown hidden h-80 overflow-scroll w-full absolute left-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1 z-10">
                <!-- Search input -->
                <input 
                    v-model="searchKeyword"
                    id="search-input"
                    class="search-input block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none" type="text" placeholder="Search items" autocomplete="off">
                <!-- Dropdown content goes here -->
                <button v-for="team in teams" :key="team.id"
                    @click="selectTeam(team)"
                    type="button" 
                    :class="[team.hidden ? 'hidden' : '', teamClassList]" data-team="{{$team->id}}">
                    <img :src="team.logo_url" class="w-5 h-5 inline-block mr-2">
                    <span>{{ team.name }}</span>
                </button>

                <input v-if="conferenceJson" class="teams_input" type="hidden" name="{{ conferenceJson.abbreviation }}" value="">
                <input v-else class="teams_input" type="hidden" name="{{ inputName }}" value="">

            </div>
        </div>

    </div>
</template>

<script>
export default {

    watch: {
        searchKeyword: function(){
            this.searchTeams();
        }
    },

    props: {
        title: {
            type: String,
            default: ''
        },
        secondTitle:{
            type: String,
            default: ''
        },
        conference: {
            type: String,
            default: ''
        },
        multiple: {
            type: String,
            default: false
        },
        inputName: {
            type: String,
            default: ''
        },
        getTeamsRoute: {
            type: String,
            default: ''
        },
        postTeamsRoute: {
            type: String,
            default: ''
        },
        getEntryTeamsRoute: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            multipleClass: '',
            conferenceJson: '',
            selectedTeams: [],
            teams: [],
            searchKeyword: '',
            dropdown: null,
            teamClassList: ['item-button block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md'],
        }
    },

    methods: {

        getTeams(route = null) {

            route = route ?? this.getTeamsRoute;
            if(route){
                axios.get(route)
                    .then(response => {
                        console.log(response.data);
                        let teams = response.data;
                        // loop through teams and remove repeated teams
                        teams = teams.filter((team, index, self) =>
                            index === self.findIndex((t) => (
                                t.uuid === team.uuid
                            ))
                        );
                        this.teams = teams;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

        postTeams(){
            let route = this.postTeamsRoute;
            let teams = this.selectedTeams;
            let conference = this.conferenceJson ? this.conferenceJson.abbreviation : this.inputName;

            let formData = new FormData();
            // append teams to form data, only id is needed
            teams = teams.map(team => team.uuid);
            formData.append('teams', JSON.stringify(teams));
            formData.append('conference', conference);
            axios.post(route, formData)
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        searchTeams(){
            let search = this.searchKeyword.toLowerCase();
            this.teams.forEach(team => {
                if(team.hasOwnProperty('selected') && team.selected == true){
                    team.hidden = true;
                }
                else if(team.name.toLowerCase().includes(search)){
                    team.hidden = false;
                }
                else{
                    team.hidden = true;
                }
            });
        },

        openDropdown() {
            this.dropdown.classList.toggle('hidden');
            // Get the selected teams from the previous selections
            if(this.getEntryTeamsRoute){
                this.selectedTeams = [];
                this.getTeams(this.getEntryTeamsRoute);
            }
        },

        closeDropdown() {
            this.dropdown.classList.add('hidden');
        },

        selectTeam(team){
            if(this.multiple){
                if(this.selectedTeams.length < 7){
                    this.selectedTeams.push(team);
                }
                if(this.selectedTeams.length >= 7){
                    this.closeDropdown();
                    this.postTeams();
                }
            }
            else if(this.selectedTeams.length < 1){
                this.selectedTeams.push(team);
                this.closeDropdown();
                this.postTeams();
            } else {
                return;
            }
            team.hidden = true;
            team.selected = true;
        },

        unselectTeam(team){
            this.selectedTeams = this.selectedTeams.filter(item => item !== team);
            team.hidden = false;
        }

    },

    mounted() {
        if (this.multiple){
            this.multipleClass = 'multiple'
        }
        this.conferenceJson = this.conference ? JSON.parse(this.conference): '';
        this.dropdown = this.$refs.dropdown;
        if(this.getTeamsRoute){
            this.getTeams();
        }
    },
}
</script>