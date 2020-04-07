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
              label="Category Name:"
              label-for="name"
              :invalid-feedback="invalidFeedback"
              :valid-feedback="validFeedback"
              :state="state"
            >
              <b-form-input
                id="name"
                v-model="category.name"
                required
                placeholder="Enter category name"
              ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Save</b-button>
          </b-form>
        </b-card>
      </div>
    </div>
  </div>
</template>
<script>
import util from '../util/util'
export default {
  data() {
    return {
      category: {},
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
        this.$router.push(`/categories`)
      }
    },

    handleSubmit(e) {
      e.preventDefault();

      if (this.category.name) {
        let token = sessionStorage.getItem("jwt");

        axios.defaults.headers.common["Content-Type"] = "application/json";
        axios.defaults.headers.common["Authorization"] = "Bearer " + token;

        if (!this.category.id) {
          axios.post("/api/category", this.category)
          .finally(() => {
            this.showAlert();
          })
          .then((response) => {
            this.message = response.data.message;
          }, err => {
            this.alertType = 'danger';
            this.message = 'Fail on store category';
          });
          return;
        }

        axios.put("/api/category", this.category)
        .finally(() => {
            this.showAlert();
        })
        .then((response) => {
          this.message = response.data.message;
        }, err => {
          this.alertType = 'danger';
          this.message = 'Fail on store category';
        });


      } else {
        this.message = "Name not be is Empty"
        this.alertType = 'warning';
        this.showAlert();
        return ;
      }
    }
  },
  mounted() {
    let { id } = this.$route.params;
    let token = sessionStorage.getItem("jwt");

    axios.defaults.headers.common["Content-Type"] = "application/json";
    axios.defaults.headers.common["Authorization"] = "Bearer " + token;

    this.title = 'Create Category';
    if (id) {
      this.title = 'Update Category';
      axios.get('/api/category/' +id).then((response) => {
        this.category = response.data.data;
      });
    }
  },

  computed: {
    state() {
      return (this.category.name && this.category.name.length >= 4);
    },

    invalidFeedback() {
      if (!this.category.name) {
        return 'Plaese enter something'
      } else if (this.category.name.length > 0) {
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
