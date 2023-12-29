<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Create Book</div>
              <div class="float-end">
                <router-link to="/book/index" class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <form @submit.prevent="createBook" enctype="multipart/form-data">
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
                      v-model="book.name"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Publisher</label
                  >
                  <div class="col-md-6">
                    <input
                      type="text"
                      name="publisher"
                      id="publisher"
                      class="form-control"
                      v-model="book.publisher"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="isbn"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >ISBN</label
                  >
                  <div class="col-md-6">
                    <input
                      type="text"
                      name="isbn"
                      id="isbn"
                      class="form-control"
                      v-model="book.isbn"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="category"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Category</label
                  >
                  <div class="col-md-6">
                    <select
                      class="form-select"
                      aria-label="Default select example"
                      v-model="book.category"
                      required
                    >
                      <option selected>Open this select menu</option>
                      <option value="Fiction">Fiction</option>
                      <option value="Non-Fiction">Non-Fiction</option>
                      <option value="Edited">Edit</option>
                      <option value="Referrence">Reference</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="subcategory"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >SubCategory</label
                  >
                  <div class="col-md-6">
                    <select
                      class="form-select"
                      aria-label="Default select example"
                      v-model="book.subcategory"
                      required
                    >
                      <option selected>Open this select menu</option>
                      <option value="Comedy">Comedy</option>
                      <option value="Fantasy">Fantasy</option>
                      <option value="Romance">Romance</option>
                      <option value="Historical">Historical</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="description"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Description</label
                  >
                  <div class="col-md-6">
                    <textarea
                      class="form-control"
                      rows="5"
                      v-model="book.description"
                      required
                    ></textarea>
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="description"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Page Number</label
                  >
                  <div class="col-md-6">
                    <input
                      type="number"
                      name="pages"
                      id="isbn"
                      min="1"
                      class="form-control"
                      v-model="book.pages"
                      required
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <label
                    for="formFile"
                    class="col-md-4 col-form-label text-md-end text-start"
                    >Image</label
                  >
                  <div class="col-md-6">
                    <input
                      class="form-control"
                      type="file"
                      id="formFile"
                      accept="image/*"
                      name="image"
                      required
                      v-on:change="onFileChange"
                    />
                  </div>
                </div>
                <div class="row mb-3">
                  <button
                    type="submit"
                    class="btn btn-success btn-sm col-md-3 offset-md-5"
                  >
                    Create Book
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
        name:"CreateBook",
        data(){
                return{
                    book:{
                        name:null,
                        publisher:null,
                        isbn:null,
                        category:null,
                        subcategory:null,
                        description:null,
                        pages:null,
                        image:null,
                        added_by:null,
                    }
                }
        },

        methods:{
                 onFileChange(e){
                   //console.log(e.target.files[0]);
                    this.book.image = e.target.files[0];
                 },
               async createBook(){
                  const data = new FormData();
                  data.append('image',this.book.image);
                  data.append('name',this.book.name);
                  data.append('publisher',this.book.publisher);
                  data.append('isbn',this.book.isbn);
                  data.append('category',this.book.category);
                  data.append('sub_category',this.book.subcategory);
                  data.append('description',this.book.description);
                  data.append('pages',this.book.pages);
                  data.append('added_by',this.book.added_by)

                  const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'Authorization' : `Bearer ${localStorage.getItem("token")}`
                    }
                };

               await axios.post("http://127.0.0.1:8000/api/book",data,config).then((response)=>{
                  if(response.data.status === true){
                    alert(response.data.message);
                    this.$router.push({name:'ViewBooks'})
                  }else{
                    alert(response.data.message);
                  }
                }).catch((error)=>{
                  alert(error.message);
                })
                },
                async getUser(){
                  if(localStorage.getItem("token") !== null){
                    let response  = await axios.get("http://127.0.0.1:8000/api/auth/user",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}});
                     //console.log(response.data);
                      this.book.added_by = response.data.user.id;
                }
        },
        },
        mounted(){
          this.getUser();
        }

      }
</script>
