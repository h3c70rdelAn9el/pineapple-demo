<x-app-layout>
    <x-main-container>
        <h1 class="p-2 text-2xl text-center">Add Client</h1>
        <x-client-form :action="route('clients.store')"
            :method="'POST'"
            :therapists="$therapists"
            :countries="$countries"
            :categories="$categories"
            :states="$states"
            :ethnic-groups="$ethnicGroups"
            :pronouns="$pronouns"
            :genders="$genders"
            :activeTherapists="$activeTherapists"
            :inactiveTherapists="$inactiveTherapists"
            :maxSessions="$maxSessions"
            />
    </x-main-container>
</x-app-layout>
