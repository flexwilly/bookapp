<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Create Role</div>
              <div class="float-end">
                <router-link to="/role/index" class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <form @submit.prevent="createRole">
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
                      v-model="role.name"
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="permissions"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Permissions</label
                  >
                  <div class="col-md-6">
                    <select
                      class="form-select"
                      multiple
                      aria-label="Permissions"
                      id="permissions"
                      name="permissions[]"
                      v-model="role.permissions"
                      style="height:250px;"
                    >
                      <option
                        selected
                        v-for="perm in rolePermissions"
                        :key="perm.id"
                        :value=" perm.id"
                      >
                        {{ perm.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <button
                    type="submit"
                    class="btn btn-success btn-sm col-md-3 offset-md-5"
                  >
                    Add Role
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
import axios from'axios'
export default{
        name:"CreateRole",
        data(){
          return{
            role:
              {name:'',
               permissions:[]
              }

            ,
            rolePermissions:[],
          }
        },
        methods:{
           createRole(){
           // console.log(` Role: ${this.role.name} , Permissions: ${this.role.permissions}`);
               axios.post("http://127.0.0.1:8000/api/role",this.role,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}})
              .then((response)=>{
                if(response.data.status === true){
                  alert(response.data.message);
                  this.$router.push({name:'ViewRoles'});

                }else{
                  alert(response.data.message);
                }
              })
              .catch((error)=>{
                alert(error.message)
              });
           }

        },
        async mounted(){
          await axios.get("http://127.0.0.1:8000/api/role",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                this.rolePermissions = response.data.permissions;
        });
      }
}
</script>
