<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">My Book Loans</div>
              <div class="float-end">
                <router-link
                  to="/student/book/index"
                  class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <table class="table table-striped table-bordered">
                <thead>
                  <th scope="col">S#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Loan date</th>
                  <th scope="col">Due Date</th>
                  <th scope="col">Return Date</th>
                  <th scope="col">Extended</th>
                  <th scope="col">#</th>
                </thead>
                <tbody>
                  <tr v-for="book in bookLoans" :key="book.name">
                    <td>{{ book.id }}</td>
                    <td>{{ book.name }}</td>
                    <td>{{ book.loan_date }}</td>
                    <td>{{ book.due_date }}</td>
                    <td>{{ book.return_date }}</td>
                    <td>{{ book.extended }}</td>
                    <td>
                      <router-link
                        class="btn btn-success btn-sm"
                        :to="'/student/bookloan/edit/'+book.id"
                        ><i class="bi bi-pencil-square"></i
                        >EditBookLoan</router-link
                      >
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
        name:"ViewBookLoans",
        data(){
                return{
                  bookLoans:[]
                }
        },methods:{
           async getBookLoans(){
                await axios.get("http://127.0.0.1:8000/api/bookLoans",{headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                       // console.log(response.data);
                        this.bookLoans = response.data.books;
                }).catch((error)=>{
                    alert(error.message);
                });
           }
        },
        mounted(){
                this.getBookLoans();
        }

}
</script>
