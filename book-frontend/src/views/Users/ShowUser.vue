<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">User</div>
              <div class="float-end">
                <router-link to="/user/index" class="btn btn-primary btn-sm"
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
                  {{ user.name }}
                </div>
              </div>
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Role:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  <span
                    class="badge bg-primary"
                    id="permissions"
                    >{{ role.toString() }}</span
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
import axios from 'axios'
export default{
        name:"ShowUser",
        data(){
                return {
                        user:[],
                        role:[],
                }

        },
        async mounted(){
                await axios.get("http://127.0.0.1:8000/api/user/"+this.$route.params.id,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        //console.log(response.data);
                        this.user = response.data.user;
                        this.role = response.data.roles;
                }).catch((error)=>{
                        alert(error.message);
                });
        }
}
</script>
