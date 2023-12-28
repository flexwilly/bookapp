<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Create User</div>
              <div class="float-end">
                <router-link to="/user/index" class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <form @submit.prevent="createUser">
                <div class="row mb-3">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Name</label
                  >
                  <div class="col-md-6">
                    <input
                      type="text"
                      name="name"
                      id="name"
                      class="form-control"
                      v-model="user.name"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Email</label
                  >
                  <div class="col-md-6">
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="form-control"
                      v-model="user.email"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Password</label
                  >
                  <div class="col-md-6">
                    <input
                      type="password"
                      name="password"
                      id="password"
                      class="form-control"
                      v-model="user.password"
                      required
                    />
                  </div>
                </div>

                <div class="row mb-3">
                  <label
                    for="roles"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Assign Role</label
                  >
                  <div class="col-md-6">
                    <select
                      class="form-select"
                      aria-label="Assign Roles"
                      id="roles"
                      name="roles"
                      size="2"
                      v-model="user.role"
                      required
                    >
                      <option
                        selected
                        v-for="role in roles"
                        :key="role.id"
                        :value=" role.id"
                      >
                        {{ role.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <button
                    type="submit"
                    class="btn btn-success btn-sm col-md-3 offset-md-5"
                  >
                    Create User
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
import axios from 'axios'
export default{
        name:"CreateUser",
        data(){
            return{
                user:
                  {
                        name:null,
                        email:null,
                        password:null,
                        role:null
                  },

                roles:[],


            }
        },
        methods:{

              async createUser(){
                 console.log(this.user);
                await axios.post("http://127.0.0.1:8000/api/user",this.user,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        if(response.data.status === true){
                            alert(response.data.message)
                            this.$router.push({name:'ViewUsers'});
                        }else{
                                alert(response.data.message);
                        }
                }).catch((error)=>{
                        alert(error.message);
                });
             },


              async getRoles(){
                await axios.get("http://127.0.0.1:8000/api/role",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).
                then((response)=>{
                  // console.log(response.data.roles);
                   this.roles = response.data.roles
                })
                .catch((error)=>{
                        alert(error.message);
                });
              }
        },
         mounted(){
             this.getRoles();
        }
}
</script>
