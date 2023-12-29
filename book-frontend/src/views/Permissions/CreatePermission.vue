<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Create Permission</div>
              <div class="float-end">
                <router-link
                  to="/permission/index"
                  class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <form @submit.prevent="createPermission">
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
                      v-model="permission.name"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <button
                    type="submit"
                    class="btn btn-success btn-sm col-md-3 offset-md-5"
                  >
                    Add Permission
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
export default{
        name:"CreatePermission",
        data(){
                return {
                        permission:{
                                name:null
                        }
                }
        },
        methods:{
               async createPermission(){
                await axios.post("http://127.0.0.1:8000/api/permission",this.permission,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        if(response.data.success === true){
                                alert(response.data.message);
                        }else{
                                alert(response.data.message);
                        }

                }).catch((error)=>{
                        alert(error.message)
                });
               }
        }
}
</script>
