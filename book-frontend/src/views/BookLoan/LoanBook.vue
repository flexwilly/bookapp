<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">{{ book.name }}</div>
              <div class="float-end">
                <router-link
                  to="/student/book/index"
                  class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="row mb-3 mt-3">
              <div class="col-md-6 mx-auto">
                <img
                  :src="'http://127.0.0.1:8000/storage/images/'+book.image"
                  class="card-img-top"
                  alt="My image"
                  width="100%"
                  height="200px"
                />
              </div>
            </div>
            <div class="card-body">
              <form @submit.prevent="loanBook">
                <div class="row mb-3">
                  <label
                    for="description"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Due date</label
                  >
                  <div class="col-md-6">
                    <input
                      type="date"
                      name="due_date"
                      id="due_date"
                      class="form-control"
                      v-model="bookLoan.due_date"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <button
                    class="btn btn-danger btn-sm col-md-3 offset-md-5"
                    type="submit"
                  >
                    Loan Book
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
        name:"LoanBook",
        data(){
                return{
                        book:[],
                        bookLoan:{
                             book_id:null,
                             user_id:null,
                             loan_date:null,
                             return_date:null,
                             due_date:null,
                             extended:null,
                             extension_date:null,
                             penalty_amount:null,
                             penalty_status:null,
                             status:null,
                        },
                }
        },methods:{
               async loanBook(){
                   this.bookLoan.return_date = this.bookLoan.due_date;
                   //console.log(this.bookLoan);
                 await axios.post("http://127.0.0.1:8000/api/bookLoans",this.bookLoan,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        if(response.data.status === true){
                                alert(response.data.message);
                                this.$router.push({name:'ViewBookLoans'});
                        }else{
                                alert(response.data.message);
                        }
                   }).catch((error)=>{
                        alert(error.message);
                   });
                },
               async getStudent(){
                        if(localStorage.getItem("token") !== null){
                        let response  = await axios.get("http://127.0.0.1:8000/api/auth/user",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}});
                        this.bookLoan.user_id=response.data.user.id;
                       // console.log(this.bookLoan.user_id);

                }

                },
               async loadBookData(){
                        await axios.get("http://127.0.0.1:8000/api/book/"+this.$route.params.id,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        this.book = response.data.book;
                        this.bookLoan.book_id = response.data.book.id;

                }).catch((error)=>{
                        alert(error.message);
                })
                },
                formatDate(date = new Date()) {
                  const year = date.toLocaleString('default', {year: 'numeric'});
                  const month = date.toLocaleString('default', {
                 month: '2-digit',
                 });
                 const day = date.toLocaleString('default', {day: '2-digit'});

                 return [year, month, day].join('-');
                 } ,
                setValues(){

                   this.bookLoan.loan_date = this.formatDate(new Date());
                   let defaultdate = this.bookLoan.loan_date;
                   //console.log(this.bookLoan.loan_date);

                   this.bookLoan.extended = "No";
                   this.bookLoan.extension_date =" ";
                   this.bookLoan.penalty_amount = "0";
                   this.bookLoan.penalty_status = 'No Penalty';
                   this.bookLoan.status = 'Taken';

                }
        },

        async mounted(){
            this.loadBookData();
            this.getStudent();
            this.setValues();
        }

}
</script>
