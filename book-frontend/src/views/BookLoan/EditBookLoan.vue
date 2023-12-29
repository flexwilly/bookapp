<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Edit Book Loan</div>
              <div class="float-end">
                <router-link
                  to="/student/bookloans"
                  class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="float-start">
                  Your current due date is : {{ previousVals.due_date }}
                </p>
              </div>
              <form @submit.prevent="updateLoan">
                <div class="row mb-3">
                  <label
                    for="extended"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Do you want to extend?</label
                  >
                  <div class="col-md-6">
                    <select
                      name="extended"
                      class="form-select"
                      aria-label="Default select example"
                      v-model="bookLoan.extended"
                      required
                    >
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="description"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Extension date</label
                  >
                  <div class="col-md-6">
                    <input
                      type="date"
                      :min="previousVals.due_date"
                      name="extension_date"
                      id="due_date"
                      class="form-control"
                      v-model="bookLoan.extension_date"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <button class="btn btn-primary btn-sm col-md-3 offset-md-5 ">
                    Update
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
import axios from 'axios';
export default{
        name:"EditBookLoan",
        data(){
                return {
                        previousVals:{},
                        bookLoan:{
                          extended:null,
                          return_date:null,
                          extension_date:null,
                        }
          }
       },
       methods:{
           updateLoan(){
            let extdate = this.bookLoan.extension_date;
            this.bookLoan.return_date = extdate;
            console.log(this.bookLoan);
            axios.put("http://127.0.0.1:8000/api/bookLoans/"+this.$route.params.id,this.bookLoan,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                    if(response.data.status === true){
                      alert(response.data.message);
                      this.$router.push({name:'ViewBookLoans'});
                    }else{
                      alert(response.data.message);
                    }
            }).catch((error)=>alert(error.message))
           },
           async getLoanData(){
            await axios.get("http://127.0.0.1:8000/api/bookLoans/"+this.$route.params.id,{headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                if(response.data.status  === true){
                 // console.log(response.data.bookloan)
                  this.previousVals = response.data.bookloan;
                  //console.log(this.previousVals);
                }

               }).catch((error)=>{
                alert(error.message);
               });

           }

       },
        mounted(){
               this.getLoanData();
           }


}
</script>
