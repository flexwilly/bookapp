<template>
  <section class="mb-4 mt-4">
    <div class="row">
      <div class="col-md-3 m-2 mb-3" v-for="book in books" :key="book.id">
        <div class="card" style="width: 18rem;">
          <img
            :src="'http://127.0.0.1:8000/storage/images/'+book.image"
            class="card-img-top"
            height="150px"
          />
          <div class="card-body">
            <h5 class="card-title">{{ book.name }}</h5>
            <p class="card-text">
              {{ book.description }}
            </p>
            <p class="card-text">
              <span class="badge bg-primary">{{ book.category }}</span>
            </p>
            <router-link
              class="btn btn-warning btn-sm"
              :to="'/student/book/loan/'+book.id"
              ><i class="bi bi-eye"></i>ShowBook</router-link
            >
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import axios from 'axios';
export default{
        name:"ViewStudentBooks",
        data(){
                return{
                        books:[]
                }
        },
        methods:{
         async loadData(){
              await axios.get("http://127.0.0.1:8000/api/book",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}})
              .then((response)=>{
                console.log(response.data)
                  this.books = response.data.books;
              })
              .catch((error)=>{
                alert(error.message);
              });
          },
        },
        mounted(){
          this.loadData();
        },
}
</script>
