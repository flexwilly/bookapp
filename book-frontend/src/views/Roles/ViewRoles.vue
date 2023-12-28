<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-11 mx-auto">
          <div class="card">
            <div class="card-header">All Roles</div>
            <div class="card-body">
              <router-link
                class="btn btn-success btn-sm my-2 float-end"
                to="/role/create"
                ><i class="bi bi-plus-circle"></i>Add New Role</router-link
              >
              <table class="table table-striped table-bordered">
                <thead>
                  <th scope="col">S#</th>
                  <th scope="col">Name</th>
                  <th scope="col" colspan="3">Action</th>
                </thead>
                <tbody>
                  <tr v-for="role in roles" :key="role.id">
                    <td>{{ role.id }}</td>
                    <td>{{ role.name }}</td>
                    <td>
                      <router-link
                        class="btn btn-warning btn-sm"
                        :to="'/role/show/'+role.id"
                        ><i class="bi bi-eye"></i>ShowRole</router-link
                      >
                    </td>
                    <td>
                      <router-link
                        class="btn btn-success btn-sm"
                        :to="'/role/edit/'+role.id"
                        ><i class="bi bi-pencil-square"></i
                        >EditRole</router-link
                      >
                    </td>
                    <td>
                      <button
                        v-on:click="deleteRole(role.id)"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="bi bi-trash"></i>Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
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
        name:"ViewUsers",
        data(){
          return{
            roles:[]
          }
        },
        methods:{
          async deleteRole(id){
           if(confirm('Are you sure?')){
            await axios.delete('http://127.0.0.1:8000/api/role/'+ id,{headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
              if(response.data.status === true){
                alert(response.data.message);
                this.loadData();
              }else{
                alert(response.data.message);
              }
            }).catch((error)=>{
              alert(error.message);
            });
          }
          },async loadData(){
            let result = await axios.get("http://127.0.0.1:8000/api/role",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}});
          this.roles = result.data.roles;
          }

        },
        async mounted(){
          let result = await axios.get("http://127.0.0.1:8000/api/role",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}});
          //console.log(result);
          this.roles = result.data.roles;
        }
}
</script>
