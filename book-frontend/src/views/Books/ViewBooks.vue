<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-11 mx-auto">
          <div class="card">
            <div class="card-header">All Books</div>
            <div class="card-body">
              <router-link
                class="btn btn-success btn-sm my-2 float-end"
                to="/book/create"
                ><i class="bi bi-plus-circle"></i>Add New Book</router-link
              >
              <table class="table table-striped table-bordered">
                <thead>
                  <th scope="col">S#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Publisher</th>
                  <th scope="col">ISBN</th>
                  <th scope="col">Category</th>
                  <th scope="col">SubCategory</th>
                  <th scope="col">Description</th>
                  <th scope="col">Pages</th>
                  <th scope="col" colspan="3">Action</th>
                </thead>
                <tbody>
                  <tr v-for="book in books" :key="book.id">
                    <td>{{ book.id }}</td>
                    <td>{{ book.name }}</td>
                    <td>{{ book.publisher }}</td>
                    <td>{{ book.isbn }}</td>
                    <td>{{ book.category }}</td>
                    <td>{{ book.sub_category }}</td>
                    <td>{{ book.description }}</td>
                    <td>{{ book.pages }}</td>
                    <td>
                      <router-link
                        class="btn btn-warning btn-sm"
                        :to="'/book/show/'+book.id"
                        ><i class="bi bi-eye"></i>ShowBook</router-link
                      >
                    </td>
                    <td>
                      <router-link
                        class="btn btn-success btn-sm"
                        :to="'/book/edit/'+book.id"
                        ><i class="bi bi-pencil-square"></i
                        >EditBook</router-link
                      >
                    </td>
                    <td>
                      <button
                        class="btn btn-danger btn-sm"
                        v-on:click="deleteBook(book.id)"
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
        name:"ViewBooks",
        data(){
                return{
                        books:[]
                }
        },
        methods:{
         async loadData(){
              await axios.get("http://127.0.0.1:8000/api/book",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}})
              .then((response)=>{
                  this.books = response.data.books;
              })
              .catch((error)=>{
                alert(error.message);
              });
          },
         async deleteBook(id){
          if(confirm('Are you sure?')){
             await axios.delete('http://127.0.0.1:8000/api/book/'+ id,{headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
              if(response.data.status === true){
                                alert(response.data.message);
                                this.loadData();

                        }
             }).catch((error)=>{
              alert(error.message);

             });
            }
          }
        },
        mounted(){
          this.loadData();
        },
}
</script>
