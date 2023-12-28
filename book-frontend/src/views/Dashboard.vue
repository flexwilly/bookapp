<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card">
            <div class="card-header">Book Loan System</div>
            <div class="card-body">
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Welcome </strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  {{ user.name }}
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
        name:'Dashboard',
        data(){
          return{
            user:[]
          }
        },
        methods:{
          async getLoggedInUser(){
            if(localStorage.getItem("token") !== null){
        await axios.get("http://127.0.0.1:8000/api/auth/user",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
          this.user=response.data.user;
        }).catch((error)=>{
          alert(error.message);
          this.$router.push({name:'Login'});
        })

        }
           }
        },
        mounted(){
          if (localStorage.getItem('reloaded')) {
        // The page was just reloaded. Clear the value from local storage
        // so that it will reload the next time this page is visited.
        localStorage.removeItem('reloaded');
        } else {
        // Set a flag so that we know not to reload the page twice.
        localStorage.setItem('reloaded', '1');
        location.reload();
          }
          this.getLoggedInUser();
        }

        }
</script>
