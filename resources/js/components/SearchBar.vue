<template>
  <div>
    <div
      v-if="focus && searchTerm.length > 2"
      @click="focus = false"
      class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10"
    ></div>

    <div class="relative z-10">
      <div class="absolute">
        <svg viewBox="0 0 24 24" class="w-5 h-5 mt-2 ml-2">
          <path
            fill-rule="evenodd"
            d="M20.2 18.1l-1.4 1.3-5.5-5.2 1.4-1.3 5.5 5.2zM7.5 12c-2.7 0-4.9-2.1-4.9-4.6s2.2-4.6 4.9-4.6 4.9 2.1 4.9 4.6S10.2 12 7.5 12zM7.5.8C3.7.8.7 3.7.7 7.3s3.1 6.5 6.8 6.5c3.8 0 6.8-2.9 6.8-6.5S11.3.8 7.5.8z"
            clip-rule="evenodd"
          />
        </svg>
      </div>
      <input
        type="text"
        id="searchTerm"
        class="w-64 mr-6 bg-gray-200 border border-gray-400 pl-8 pr-3 py-1 rounded-full text-sm focus:outline-none focus:border-blue-500 focus:shadow focus:bg-gray-100"
        placeholder="Search..."
        v-model="searchTerm"
        @input="search"
        @focus="focus = true"
      />

      <div
        v-if="focus && searchTerm.length > 2"
        class="absolute bg-blue-900 rounded-lg p-4 w-96 right-0 mr-6 mt-2 shadow z-20"
      >
        <div class="text-white" v-if="results.length === 0">No results found for '{{ searchTerm }}'</div>
        <div v-for="result in results" @click="focus = false" class="hover:bg-blue-800 p-2 rounded">
          <router-link :to="result.links.self" class="block py-2">
            <div class="flex items-center text-white">
              <user-circle :name="result.data.name" />
              <div class="pl-3">
                <p>{{ result.data.name }}</p>
                <p class="text-xs">{{ result.data.company }}</p>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";
import UserCircle from "../components/UserCircle";

export default {
  name: "SearchBar",
  components: {
    UserCircle
  },
  data: () => ({
    searchTerm: "",
    focus: false,
    results: []
  }),
  methods: {
    search: _.debounce(function() {
      if (this.searchTerm.length < 3) {
        return;
      }

      axios
        .post("/api/search", {
          searchTerm: this.searchTerm
        })
        .then(response => {
          this.results = response.data.data;
        })
        .catch(error => {
          console.log(error.response);
        });
    }, 300)
  }
};
</script>