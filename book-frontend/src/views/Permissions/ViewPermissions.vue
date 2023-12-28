<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-11 mx-auto">
          <div class="card">
            <div class="card-header">All Permissions</div>
            <div class="card-body">
              <router-link
                class="btn btn-success btn-sm my-2 float-end"
                to="/permission/create"
                ><i class="bi bi-plus-circle"></i>Add New
                Permission</router-link
              >
              <table class="table table-striped table-bordered">
                <thead>
                  <th scope="col">S#</th>
                  <th scope="col">Name</th>
                  <th scope="col" colspan="3">Action</th>
                </thead>
                <tbody>
                  <tr v-for="permission in permissions" :key="permission.id">
                    <td>{{ permission.id }}</td>
                    <td>{{ permission.name }}</td>
                    <td>
                      <router-link
                        class="btn btn-warning btn-sm"
                        :to="'/permission/show/'+permission.id"
                        ><i class="bi bi-eye"></i>ShowPermission</router-link
                      >
                    </td>
                    <td>
                      <router-link
                        class="btn btn-success btn-sm"
                        :to="'/permission/edit/'+permission.id"
                        ><i class="bi bi-pencil-square"></i
                        >EditPermission</router-link
                      >
                    </td>
                    <td>
                      <button
                        v-on:click="deletePermission(permission.id)"
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
        name:"ViewPermission",
        data(){
                return{
                    permissions:[]
                }
        },
        methods:{
           async deletePermission(id){
             if(confirm('Are you sure?')){
                await axios.delete('http://127.0.0.1:8000/api/permission/'+ id,{headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        if(response.data.status === true){
                                alert(response.data.message);
                                this.loadData();

                        }
                }).catch((error)=>{
                        alert(error.message);
                });
        }

           },
          async loadData(){
                await axios.get("http://127.0.0.1:8000/api/permission",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
               this.permissions = response.data.permissions;
            }).catch((error)=>{
                alert(error.message)
            })
           },
        },
        async mounted(){
            this.loadData();
        }
}
</script>
