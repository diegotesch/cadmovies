<template>
    <div>
      <b-jumbotron header="Movie Library" lead="Your personal movie library">


        <div class="row" v-if="!isLoggedIn">
          <p>For more information, login or register</p>

          <b-button variant="primary" href="#">Login</b-button>
          <b-button variant="success" href="#">Register</b-button>
        </div>

        <div class="row" v-if="isLoggedIn">
          <div class="col-md-3" v-for="category in listCategories" :key="category.id">
            <b-card
              :header="category.name"
              class="text-center"
            >
              <b-list-group flush>
                <b-list-group-item v-for="movie in category.movies" :key="movie.id">{{ movie.name }}</b-list-group-item>
              </b-list-group>
            </b-card>
          </div>

        </div>

      </b-jumbotron>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        isLoggedIn: false,
        listCategories: [],

        athors: [],
        fields: [
          {
            key: 'name',
            sortable: true,
            label: 'Athor Name'
          },
          {
            key: 'birthdate',
            sortable: true,
            label: 'Age',
            formatter: (value, key, item) => {
              let diff = Date.now() - new Date(item.birthdate)
              return Math.abs(new Date(diff).getUTCFullYear() - 1970);
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

      getCategories() {
        this.getHeadersAuth()

        axios.get("api/category").then((response) => {
          let { data: cat } = response.data;
          this.listCategories = cat;
        });
      },

      getHeadersAuth() {
        let token = sessionStorage.getItem("jwt");

        axios.defaults.headers.common["Content-Type"] = "application/json";
        axios.defaults.headers.common["Authorization"] = "Bearer " + token;
      }
    },
    mounted() {
      this.isLoggedIn = sessionStorage.getItem("jwt");

      this.getCategories();
    },
    beforeRouteEnter(to, from, next) {
      if (!sessionStorage.getItem("jwt")) {
        return next("login");
      }

      next();
    },
  }
</script>
