<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6 m-auto">
          <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
              <form @submit.prevent="login">
                <div class=" mb-3">
                  <input
                    type="text"
                    name="email"
                    id="email"
                    class="form-control"
                    placeholder="Enter Email"
                    v-model="user.email"
                  />
                </div>
                <div class=" mb-3">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Enter Password"
                    v-model="user.password"
                  />
                </div>
                <div class="mb-3">
                  <button
                    type="submit"
                    name="submit"
                    id="submit"
                    class="btn btn-primary float-start col-4"
                  >
                    Login
                  </button>
                  <router-link
                    to="/register"
                    class="nav-link text-primary float-end col-6"
                  >
                    Dont have an account?
                  </router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import axios from 'axios';
export default{
        name:"Login",
        data(){
                return{
                        user:{
                                email:null,
                                password:null
                        },

                }
        },
        methods:{
              async login(){
                await axios.post("http://127.0.0.1:8000/api/login",this.user).then(response =>{
                        if(response.data.status === true){
                                localStorage.setItem("token",response.data.token);
                                this.$router.push({name:"Dashboard"});
                        }else{
                                 console.log(response.data.message);
                        }
                 }).catch((error)=>{
                        alert("Invalid username/password");
                 });
               }
        },mounted(){
          if (localStorage.getItem('reloaded')) {
        // The page was just reloaded. Clear the value from local storage
        // so that it will reload the next time this page is visited.
        localStorage.removeItem('reloaded');
        } else {
        // Set a flag so that we know not to reload the page twice.
        localStorage.setItem('reloaded', '1');
        location.reload();

        }
      }

}
</script>
