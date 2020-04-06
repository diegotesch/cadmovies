<template>
  <div class="container">
    <div class="row">
      <h3>Categories</h3>
    </div>

    <div class="row">
      <router-link to="/category" class="btn btn-success" >New Category</router-link>
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
          <b-table :select-mode="selectMode" selectable @row-selected="onRowSelected" striped hover :items="categories" :fields=fields>

          </b-table>
        </b-col>
        <b-col>
          <div class="v-buttons">
            <b-button :disabled="!selected" class="b-button" pill variant="success" @click="editCategory">
              <b-icon icon="pencil-square"></b-icon>
            </b-button>
            <b-button :disabled="!selected" class="b-button" pill variant="danger" @click="deleteCategory">
              <b-icon icon="trash"></b-icon>
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
      categories: [],
      fields: [
        {
          key: 'name',
          sortable: true,
          label: 'Category Name'
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
        this.$router.push(`/categories`)
      }
    },

    onRowSelected(row) {
      this.selected = row;
    },
    editCategory() {
      this.$router.push(`/category/${this.selected[0].id}`)
    },
    deleteCategory() {
      let token = sessionStorage.getItem("jwt");

      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] = "Bearer " + token;

      axios.delete(`/api/category/${this.selected[0].id}`)
      .finally(() => {
        this.showAlert()
      })
      .then((response) => {
        this.message = 'Category deleted successfuly!'
      }, error => {
        this.message = 'Error, category not exists!'
        this.alertType = 'danger'
      });
    }
  },
  mounted() {
    let token = sessionStorage.getItem("jwt");

    axios.defaults.headers.common["Content-Type"] = "application/json";
    axios.defaults.headers.common["Authorization"] = "Bearer " + token;

    axios.get("api/category").then((response) => {
      let { data: ctgs } = response.data;
      this.categories = ctgs;
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
