<template>
    <div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Name
            </label>
            <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="Name">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="relationship">
                Relationship
            </label>

            <select
                name="relationship"
                class="block appearance-none w-1/3 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 mb-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                v-model="relationshipType"
                >
                <option></option>
                <option>Parent</option>
                <option>Child</option>
                <option>Spouse</option>
            </select>

            &nbsp; of
            {{ relationshipType }}

            <select
                name="related_to"
                id="related_to"
                class="block appearance-none w-1/3 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 mt-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                >
                <option v-for="person in people" :key="person.id" :value="person.id">
                    {{ person.name }}
                </option>
            </select>
        </div>

        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Submit
        </button>
    </div>
</template>

<script>
    export default {
        props: {
           'people': {
               'type': Array,
               'required': true,
           },
        },

        data() {
            return {
                relationshipType: null,
            }
        },

        methods: {
        }
    }
</script>
