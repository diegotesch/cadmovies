<template>
  <div class="container">

    <section v-if="erroed">
      <div class="row-fluid alert alert-danger">
        {{ message }}
      </div>
    </section>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form method="POST" action="/login">
              <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" v-model="password" required autocomplete >
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary" @click="handleSubmit">
                    Login
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data(){
      return {
        email : "",
        password : "",
        erroed: false,
        message: "jkhfkheskjhj"
      }
    },
    methods : {
      handleSubmit(e){
        e.preventDefault()

        if (this.password.length > 0) {
          axios.post('api/login', {
            email: this.email,
            password: this.password
          })
          .then(response => {
            this.erroed = false;
            this.message = '';

            sessionStorage.setItem('user',response.data.success.name)
            sessionStorage.setItem('jwt',response.data.success.token)

            if (sessionStorage.getItem('jwt') != null){
                this.$router.go('/')
            }
          }, err => {
            this.erroed = true;
            let {status, data: {error} } = err.response;

            this.message = status == 401 ? "E-mail address or Password invalid!" : error
          });
        }
      }
    },

    beforeRouteEnter (to, from, next) {
      if (sessionStorage.getItem('jwt')) {
        return next('/');
      }

      return next();
    }
    }
</script>
