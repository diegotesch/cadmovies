<template>
  <div class="container">
    <div class="row">
      <b-alert
        :show="dismissTime"
        dismissible
        :variant="alertType"
        @dismissed="dismissTime=0"
        @dismiss-count-down="lessTime"
      >
        {{ message }}

        <b-progress
          :value="progress"
          :variant="alertType"
        ></b-progress>
      </b-alert>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <b-card
          :title="title"
          class="mb-2"
        >
          <b-form
            @submit="handleSubmit"
            >
            <b-form-group
              label="Athor Name:"
              label-for="name"
              :invalid-feedback="invalidFeedback"
              :valid-feedback="validFeedback"
              :state="state"
            >
              <b-form-input
                id="name"
                v-model="athor.name"
                required
                placeholder="Enter athor name"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              label="Birth Date:"
              label-for="birthdate"
              :state="state"
            >
              <b-form-datepicker
                :state="state"
                v-model="athor.birthdate"
              ></b-form-datepicker>
            </b-form-group>

            <b-button type="submit" variant="primary">Save</b-button>
          </b-form>
        </b-card>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      athor: {},
      dismissTime: 0,
      progress: 0,
      counter: 0,
      alertType: 'success',
      message: '',
      title: ''
    }
  },

  methods: {
    showAlert() {
      this.dismissTime = 3;
      this.progress = 0;
      this.counter = 0;
    },

    lessTime(dismissTime) {
      this.dismissTime = dismissTime;
      ++this.counter;
      this.progress = (this.counter * 100) / 3;
      if (!this.dismissTime && this.alertType == 'success') {
        this.$router.push(`/athors`)
      }
    },

    handleSubmit(e) {
      e.preventDefault();

      if (this.athor.name && this.athor.birthdate) {
        this.getHeaderAuth();

        if (!this.athor.id) {
          axios.post("/api/athor", this.athor)
          .finally(() => {
            this.showAlert();
          })
          .then((response) => {
            this.message = response.data.message;
          }, err => {
            this.alertType = 'danger';
            this.message = 'Fail on store athor';
            console.log(err)
          });
          return;
        }

        axios.put("/api/athor", this.athor)
        .finally(() => {
            this.showAlert();
        })
        .then((response) => {
          this.message = response.data.message;
        }, err => {
          this.alertType = 'danger';
          this.message = 'Fail on store athor';
          console.log(err)
        });


      } else {
        if (!this.athor.name) {
          this.message = "Name not be is Empty"
          this.alertType = 'warning';
          this.showAlert();
        }

        if (!this.athor.birthdate) {
          this.message = "Birthdate not be is Empty"
          this.alertType = 'warning';
          this.showAlert();
        }

        return ;
      }
    },

    getHeaderAuth() {
      let token = sessionStorage.getItem("jwt");

      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    }
  },
  mounted() {
    let { id } = this.$route.params;

    this.getHeaderAuth();

    this.title = 'Create Athor';
    if (id) {
      this.title = 'Update Athor';
      axios.get(`/api/athor/${id}`).then((response) => {
        this.athor = response.data.data;
      });
    }
  },

  computed: {
    state() {
      return ((this.athor.name && this.athor.birthdate ) && this.athor.name.length >= 4);
    },

    invalidFeedback() {
      if (!this.athor.name) {
        return 'Plaese enter something'
      } else if (this.athor.name.length > 0) {
        return 'Enter at least 4 characteres'
      }
      return ''
    },

    validFeedback() {
      return this.state ? 'All ready!' : ''
    },
  },

  beforeRouteEnter(to, from, next) {
    if (!sessionStorage.getItem("jwt")) {
      return next("login");
    }

    next();
  },
};
</script>
