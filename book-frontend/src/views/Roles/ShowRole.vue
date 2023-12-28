<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-9 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Role</div>
              <div class="float-end">
                <router-link to="/role/index" class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Name:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  {{ role.name }}
                </div>
              </div>
              <div class="row mb-3">
                <label
                  for="roles"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Permissions:</strong></label
                >
                <div
                  class="col-md-6"
                  style="line-height: 35px;"
                  v-if="role.name =='Super Admin'"
                >
                  <span class="badge bg-primary" id="permissions">All</span>
                </div>
                <div
                  class="col-md-6"
                  style="line-height: 35px;"
                  v-else
                  v-for="perm in role_permissions
                  "
                  :key="perm.name"
                >
                  <span
                    class="badge bg-primary"
                    id="permissions"
                    >{{ perm.name }}</span
                  >
                </div>
              </div>
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
        name:"ShowRole",
        data(){
          return{
            role:[],
            role_permissions:[],
            userrole:'',
          }
        },



        mounted(){
                axios.get("http://127.0.0.1:8000/api/role/"+this.$route.params.id,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                     //   console.log(response);
                this.role = response.data.role;
                this.role_permissions = response.data.rolePermissions;

           })
         }
}
</script>
