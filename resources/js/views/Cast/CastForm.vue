<template>
  <div class="container">
    <div class="row">
      <h3>{{ title }}</h3>
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
          <b-table
            ref="selectableTable"
            :select-mode="selectMode"
            selectable
            @row-selected="onRowSelected"
            hover
            :items="listAthors"
            :fields=fields
          >
            <template v-slot:cell(selected)="{ rowSelected }">
              <template v-if="rowSelected">
                <span aria-hidden="true">&check;</span>
                <span class="sr-only">Selected</span>
              </template>
              <template v-else>
                <span aria-hidden="true">&nbsp;</span>
                <span class="sr-only">Not selected</span>
              </template>
            </template>
          </b-table>
        </b-col>
        <b-col>
          <div class="v-buttons">
            <b-button :disabled="!selected.length" class="b-button" pill variant="success" @click="handleSubmit">
              <b-icon icon="cursor"></b-icon>
            </b-button>
            <b-button :disabled="!selected.length" class="b-button" pill variant="success" @click="selectAll">
              <b-icon icon="check-all"></b-icon>
            </b-button>
            <b-button :disabled="!selected.length" class="b-button" pill variant="danger"
            @click="clearAll">
              <b-icon icon="x-circle"></b-icon>
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
      movie: {},
      cast: {},
      movieName: '',
      listAthors: [],
      fields: [
        'Selected',
        {
          key: 'name',
          sortable: true,
          label: 'Athor Name'
        }
      ],
      selectMode: 'multi',
      selected: [],

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

    onRowSelected(items) {
      this.selected = items
    },

    clearAll() {
      this.$refs.selectableTable.clearSelected();
    },

    selectAll() {
      this.$refs.selectableTable.selectAllRows();
    },

    lessTime(dismissTime) {
      this.dismissTime = dismissTime;
      ++this.counter;
      this.progress = (this.counter * 100) / 3;
      if (!this.dismissTime && this.alertType == 'success') {
        this.$router.push(`/movie/${this.movie.id}`)
      }
    },

    getAthorsSelecteds() {
      if (this.selected.length)
        return this.selected.map(athor => athor.id);
      return [];
    },

    handleSubmit(e) {
      e.preventDefault();

      this.getHeaderAuth();

      if (!this.cast.id) {
        let send = [{"movie_id" : this.movie.id}, this.getAthorsSelecteds()];
        axios.post('/api/cast', send)
        .finally(() => {
            this.showAlert();
          })
        .then(response => {
          this.message = response.data.message;
          this.cast = response.data.created;
        }, err => {
          this.alertType = 'danger';
          this.message = 'Fail on store Cast';
        });
        return;
      }

      let send = [this.cast, this.getAthorsSelecteds()];
        axios.put('/api/cast', send)
        .finally(() => {
            this.showAlert();
          })
        .then(response => {
          this.message = response.data.message;
        }, err => {
          this.alertType = 'danger';
          this.message = 'Fail on update Cast';
        });
      return;

    },

    getHeaderAuth() {
      let token = sessionStorage.getItem("jwt");

      axios.defaults.headers.common["Content-Type"] = "application/json";
      axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    },

    getAthors() {
      this.getHeaderAuth();
      axios.get('/api/athor')
      .then(response => {
        this.listAthors = response.data.data;

      });
    },

    getMovie(id) {
      this.getHeaderAuth();
      axios.get(`/api/movie/${id}`)
      .then(response => {
        this.movie = response.data.data;
        this.getCast(this.movie.cast.id);
        this.movieName = this.movie.name;
        this.title = 'Create Cast for Movie ' + this.movieName;
      })
    },

    getCast(id) {
      this.getHeaderAuth();
      axios.get(`/api/cast/${id}`)
      .then(response => {
        this.cast = response.data.data;
        this.listAthors.forEach((item, index) => {
          if (this.cast.athors.some(at => at == item.id)) {
            this.$refs.selectableTable.selectRow(index)
          }
        })
      })
    }
  },
  mounted() {
    this.selected = [];
    let { id } = this.$route.params;

    this.getMovie(id);

    this.getAthors();

  },

  computed: {},

  beforeRouteEnter(to, from, next) {
    if (!sessionStorage.getItem("jwt")) {
      return next("login");
    }

    next();
  },
};
</script>
