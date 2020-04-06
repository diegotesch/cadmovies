<template>
  <div>
    <div>
      <b-navbar type="dark" variant="dark">
        <b-navbar-nav>
          <router-link to="/" class="navbar-brand">Home</router-link>
          <router-link to="/login" class="navbar-brand" v-if="!isLoggedIn"
            >Login</router-link
          >
          <router-link to="/register" class="navbar-brand" v-if="!isLoggedIn"
            >Register</router-link
          >

          <!-- Navbar dropdowns -->
          <b-nav-item-dropdown v-if="isLoggedIn" text="Category" right>
            <b-dropdown-item>
              <router-link to="/categories">All Categories</router-link>
            </b-dropdown-item>
            <b-dropdown-item>
              <router-link to="/category">New Category</router-link>
            </b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown v-if="isLoggedIn" text="Athor" right>
            <b-dropdown-item>
              <router-link to="/athors">All Athors</router-link>
            </b-dropdown-item>
            <b-dropdown-item>
              <router-link to="/athor">New Athor</router-link>
            </b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown v-if="isLoggedIn" text="Movie" right>
            <b-dropdown-item>
              <router-link to="/movies">All Movies</router-link>
            </b-dropdown-item>
            <b-dropdown-item>
              <router-link to="/movie">New Movie</router-link>
            </b-dropdown-item>
          </b-nav-item-dropdown>

          <a @click="logout" class="navbar-brand" v-if="isLoggedIn"
            >Logout</a>


        </b-navbar-nav>
      </b-navbar>
    </div>
    <main class="py-4">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: null,
      name: null,
    };
  },

  methods: {
    logout() {
      sessionStorage.removeItem("user");
      sessionStorage.removeItem("jwt");
      this.$router.go("/login");
    }
  },

  mounted() {
    this.isLoggedIn = sessionStorage.getItem("jwt");
    this.name = sessionStorage.getItem("user");
  },
};
</script>
