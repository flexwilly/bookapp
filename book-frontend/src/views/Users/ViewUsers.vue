<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">All Users</div>
            <div class="card-body">
              <router-link
                class="btn btn-success btn-sm my-2 float-end"
                to="/user/create"
                ><i class="bi bi-plus-circle"></i>Add New User</router-link
              >
              <table class="table table-striped table-bordered">
                <thead>
                  <th scope="col">S#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col" colspan="3">Action</th>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                      <router-link
                        class="btn btn-warning btn-sm"
                        :to="'/user/show/'+user.id"
                        ><i class="bi bi-eye"></i>ShowUser</router-link
                      >
                    </td>
                    <td>
                      <router-link
                        class="btn btn-success btn-sm"
                        :to="'/user/edit/'+user.id"
                        ><i class="bi bi-pencil-square"></i
                        >EditUser</router-link
                      >
                    </td>
                    <td>
                      <button
                        v-on:click="deleteUser(user.id)"
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
            users:[]
          }
        },
        methods:{
         async deleteUser(id){
            if(confirm('Are you sure?')){
              await axios.delete('http://127.0.0.1:8000/api/user/'+ id,{headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
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
          },
          async loadData(){
            await axios.get("http://127.0.0.1:8000/api/user",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
              //console.log(response.data.users);
                 this.users = response.data.users;
          }).catch((error)=>{
            alert(error.message)
          });
          }
        },

        async mounted(){
          this.loadData();
        }
}
</script>
