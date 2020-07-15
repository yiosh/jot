<template>
  <div>
    <a href="#" class="text-blue-400" @click="$router.back()">< Back</a>

    <form @submit.prevent="submitForm">
      <input-field
        name="name"
        label="Contact Name"
        placeholder="Contact Name"
        @update:field="form.name = $event"
        :errors="errors"
        :data="form.name"
      />

      <input-field
        name="email"
        label="Contact Email"
        placeholder="Contact Email"
        @update:field="form.email = $event"
        :errors="errors"
        :data="form.email"
      />

      <input-field
        name="company"
        label="Company"
        placeholder="Company"
        @update:field="form.company = $event"
        :errors="errors"
        :data="form.company"
      />

      <input-field
        name="birthday"
        label="Birthday"
        placeholder="MM/DD/YYYY"
        @update:field="form.birthday = $event"
        :errors="errors"
        :data="form.birthday"
      />

      <div class="flex justify-end">
        <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
        <button class="bg-blue-500 py-2 px-4 rounded text-white hover:bg-blue-400">Save</button>
      </div>
    </form>
  </div>
</template>

<script>
import InputField from "../components/InputField";
export default {
  name: "ContactsCreate",
  components: {
    InputField
  },
  data: () => ({
    form: {
      name: "",
      email: "",
      company: "",
      birthday: ""
    },
    errors: null
  }),
  mounted() {
    axios
      .get(`/api/contacts/${this.$route.params.id}`)
      .then(response => {
        this.form = response.data.data;
        this.loading = false;
      })
      .catch(error => {
        this.loading = false;

        if (error.response.status === 404) {
          this.$router.push("/contacts");
        }
      });
  },
  methods: {
    submitForm() {
      axios
        .patch(`/api/contacts/${this.$route.params.id}`, this.form)
        .then(response => {
          this.$router.push(response.data.links.self);
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
        });
    }
  }
};
</script>