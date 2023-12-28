<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6 m-auto">
          <div class="card">
            <div class="card-header">Register</div>
            <div class="card-body">
              <form @submit.prevent="register">
                <div class=" mb-3">
                  <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    placeholder="Enter Name"
                    v-model="user.name"
                  />
                </div>
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
                <div class=" mb-3">
                  <input
                    type="password"
                    name="c_password"
                    id="c_password"
                    class="form-control"
                    placeholder="Confirm Password"
                    v-model="user.c_password"
                  />
                </div>
                <div class="mb-3">
                  <button
                    type="submit"
                    name="submit"
                    id="submit"
                    class="btn btn-primary float-start col-4"
                  >
                    Register
                  </button>
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
        name:"Register",
        data(){
          return{
            user:{
              name:null,
              email:null,
              password:null,
              c_password:null
            },
          }
        },
        methods:{
          async register(){
            await axios.post('http://127.0.0.1:8000/api/register',this.user)
            .then((response)=>{
              if(response.data.status === true){
              localStorage.setItem("token",response.data.token);
                alert(response.data.message);
                this.$router.push({name:"Dashboard"});
                }else{
                alert(response.data.message);
              }
            }).catch((error)=>{
              alert(error.message);
            });
          }
        }
}
</script>
