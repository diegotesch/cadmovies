<template>
  <div class="container">
    <div class="row">
      <h3>Athors</h3>
    </div>

    <div class="row mb-3">
      <router-link to="/athor" class="btn btn-success" >New Athor</router-link>
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
          <b-table :select-mode="selectMode" selectable @row-selected="onRowSelected" striped hover :items="athors" :fields=fields>

          </b-table>
        </b-col>
        <b-col>
          <div class="v-buttons">
            <b-button :disabled="!selected" class="b-button" pill variant="success" @click="editAthor">
              <b-icon icon="pencil-square"></b-icon>
            </b-button>
            <b-button :disabled="!selected" class="b-button" pill variant="danger"
            @click="deleteAthor">
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

    onRowSelected(row) {
      this.selected = row;
    },

    editAthor() {
      this.$router.push(`/athor/${this.selected[0].id}`)
    },

    deleteAthor() {
      this.getHeadersAuth();

      axios.delete(`/api/athor/${this.selected[0].id}`)
      .finally(() => {
        this.showAlert()
      })
      .then((response) => {
        this.message = 'Athor deleted successfuly!'
      }, error => {
        this.message = 'Error, Athor not exists!'
        this.alertType = 'danger'
      });
    },

    getHeadersAuth() {
      let token = sessionStorage.getItem("jwt");

      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    }
  },
  mounted() {
    this.getHeadersAuth();

    axios.get("api/athor").then((response) => {
      let { data: ath } = response.data;
      this.athors = ath;
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
