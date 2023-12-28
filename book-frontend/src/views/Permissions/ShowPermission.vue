<template>
  <section class="mt-4 mb-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Permission</div>
              <div class="float-end">
                <router-link
                  to="/permission/index"
                  class="btn btn-primary btn-sm"
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
                  {{ permission.name }}
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
        name:"ShowPermission",
        data(){
                return{
                        permission:[],
                }
        },
        async mounted(){
                await axios.get("http://127.0.0.1:8000/api/permission/"+this.$route.params.id,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        this.permission = response.data.permission;
                }).catch((error)=>{
                        alert(error.message);
                })
        }
}
</script>
