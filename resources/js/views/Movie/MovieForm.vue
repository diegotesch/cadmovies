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
      <div class="col-md-7">
        <b-card
          :title="title"
          class="mb-2"
        >
          <b-form
            @submit="handleSubmit"
            >
            <b-form-group
              label="Movie Name:"
              label-for="name"
              :invalid-feedback="invalidFeedback"
              :valid-feedback="validFeedback"
              :state="state"
            >
              <b-form-input
                id="name"
                v-model="movie.name"
                required
                placeholder="Enter movie name"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              label="Starring Date:"
              label-for="starring"
              :state="state"
            >
              <b-form-datepicker
                id="starring"
                :state="state"
                v-model="movie.starring"
              ></b-form-datepicker>
            </b-form-group>

            <b-form-group
              label="Profit:"
              label-for="profit"
              :invalid-feedback="invalidFeedback"
              :valid-feedback="validFeedback"
              :state="state"
            >

              <money
              v-model="movie.profit"
              v-bind="money"
              required
              class="form-control"></money>
            </b-form-group>

            <b-form-group
              label="Category:"
              label-for="category"
              :invalid-feedback="invalidFeedback"
              :valid-feedback="validFeedback"
              :state="state"
            >
              <b-form-select
                v-model="movie.category_id"
                :options="listCategories"
              >
              </b-form-select>
            </b-form-group>

            <b-button type="submit" variant="primary">Save</b-button>
            <b-button v-if="movie.id" variant="primary" @click="editCast">Edit Cast</b-button>
          </b-form>
        </b-card>
      </div>
      <div class="col-md5" >
        <b-card
          title="Movie's cast"
          class="mb-2"
          v-if="movie.cast"
        >
          <b-list-group>
            <b-list-group-item v-for="athor in listAthors" :key="athor">{{ athor }}</b-list-group-item>
          </b-list-group>
        </b-card>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      movie: {},
      listCategories: [],
      listAthors: [],
      money: {
        decimal: ',',
        thousands: '.',
        prefix: '$ ',
        precision: 2,
        masked: false
      },

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
        this.$router.push(`/movies`)
      }
    },

    editCast(){
      this.$router.push(`/movie/${this.movie.id}/cast`)
    },

    handleSubmit(e) {
      e.preventDefault();
      if (this.validateForm()) {
        this.getHeaderAuth();

        if (!this.movie.id) {
          axios.post("/api/movie", this.movie)
          .finally(() => {
            this.showAlert();
          })
          .then((response) => {
            this.message = response.data.message;
          }, err => {
            this.alertType = 'danger';
            this.message = 'Fail on store movie';
            console.error(err)
          });
          return;
        }

        axios.put("/api/movie", this.movie)
        .finally(() => {
            this.showAlert();
        })
        .then((response) => {
          this.message = response.data.message;
        }, err => {
          this.alertType = 'danger';
          this.message = 'Fail on update movie';
          console.error(err)
        });
        return;
      }
    },

    validateForm() {
      if (!this.movie.name) {
        this.message = "Name not be is Empty"
        this.alertType = 'warning';
        this.showAlert();
        return;
      }

      if (this.movie.name.length < 5) {
        this.message = "Name not be less then 5 character"
        this.alertType = 'warning';
        this.showAlert();
        return;
      }

      if (!this.movie.category_id) {
        this.message = "Please select one category"
        this.alertType = 'warning';
        this.showAlert();
        return;
      }

      return true;
    },

    getHeaderAuth() {
      let token = sessionStorage.getItem("jwt");

      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    },

    getCategories() {
      this.getHeaderAuth();
      axios.get('/api/category')
      .then(response => {
        this.listCategories = response.data.data.map(category => {
          return {
            value: category.id,
            text: category.name
          }
        });
      });
    },

    getCast(id) {
      this.getHeaderAuth()
      axios.get(`/api/cast/${id}`)
      .then(response => {
        this.listAthors = response.data.data.athors_names;
      })
    }


  },
  mounted() {
    let { id } = this.$route.params;

    this.getCategories();

    this.title = 'Create Movie';
    if (id) {
      this.getHeaderAuth();
      this.title = 'Update Movie';
      axios.get(`/api/movie/${id}`).then((response) => {
        this.movie = response.data.data;
        this.getCast(this.movie.cast.id)
      });
    }
  },

  computed: {
    state() {
      return (this.movie.category_id && (this.movie.name && this.movie.name.length >= 4))
    },

    invalidFeedback() {
      if (!this.movie.name) {
        return 'Plaese enter movie name'
      } else if (this.movie.name.length > 0) {
        return 'Enter at least 4 characteres'
      }

      if (!this.movie.category_id){
        return 'Select a category'
      }

      return
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
