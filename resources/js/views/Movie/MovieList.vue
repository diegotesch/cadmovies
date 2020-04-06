<template>
  <div class="container">
    <div class="row">
      <h3>Movies</h3>
    </div>

    <div class="row mb-3">
      <router-link to="/movie" class="btn btn-success" >New Movie</router-link>
    </div>

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

    <b-container>
      <b-row>
        <b-col cols="10">
          <b-table :select-mode="selectMode" selectable @row-selected="onRowSelected" striped hover :items="movies" :fields=fields>

          </b-table>
        </b-col>
        <b-col>
          <div class="v-buttons">
            <b-button :disabled="!selected" class="b-button" pill variant="success" @click="editMovie">
              <b-icon icon="pencil-square"></b-icon>
            </b-button>
            <b-button :disabled="!selected" class="b-button" pill variant="info"
            @click="addCast">
              <b-icon icon="people-fill"></b-icon>
            </b-button>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      movies: [],
      fields: [
        {
          key: 'name',
          sortable: true,
          label: 'Movie Name'
        },
        {
          key: 'category_name',
          sortable: true,
          label: 'Category'
        },
        {
          key: 'starring',
          sortable: true,
          label: 'Starring Date',
          formatter: (value, key, item) => {
            let data = new Date(item.starring)
            return `${data.getDay()}/${data.getMonth()}/${data.getFullYear()}`
          }
        },
        {
          key: 'profit',
          sortable: true,
          label: 'Profit',
          formatter: (value, key, item) => {
            return `$ ${item.profit}`
          }
        }
      ],
      selectMode: 'single',
      selected: false,
      dismissTime: 0,
      progress: 0,
      counter: 0,
      alertType: 'success',
      message: '',
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

    onRowSelected(row) {
      this.selected = row;
    },

    editMovie() {
      this.$router.push(`/movie/${this.selected[0].id}`)
    },

    addCast() {
      this.$router.push(`/movie/${this.selected[0].id}/cast`)
    },

    getHeadersAuth() {
      let token = sessionStorage.getItem("jwt");

      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    }
  },
  mounted() {
    this.getHeadersAuth();

    axios.get("/api/movie").then((response) => {
      let { data: mv } = response.data;
      this.movies = mv;
    }, err => {
      console.error(err);
    });
  },
  beforeRouteEnter(to, from, next) {
    if (!sessionStorage.getItem("jwt")) {
      return next("login");
    }

    next();
  },
};
</script>
