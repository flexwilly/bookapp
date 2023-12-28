<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Edit Book</div>
              <div class="float-end">
                <router-link to="/book/index" class="btn btn-primary btn-sm"
                  >&larr; Back</router-link
                >
              </div>
            </div>
            <div class="card-body">
              <form @submit.prevent="editBook" enctype="multipart/form-data">
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
                  <button
                    type="submit"
                    class="btn btn-success btn-sm col-md-3 offset-md-5"
                  >
                    Edit Book
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
        name:"EditBook",
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
                        added_by:null,
                    }
                }
        },

        methods:{

               async editBook(){
                    console.log(this.book);
                  const config = {
                    headers: {
                        'Authorization' : `Bearer ${localStorage.getItem("token")}`
                    }
                };

               await axios.put("http://127.0.0.1:8000/api/book/"+this.$route.params.id,this.book,config).then((response)=>{
                  if(response.data.status === true){
                    alert(response.data.message);
                    this.$route.push({name:'ViewBooks'})
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
                async populateForm(){
                  await axios.get("http://127.0.0.1:8000/api/book/"+this.$route.params.id,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                  console.log(response);
                  // this.rolePermissions = response.data.permissions;
                  this.book = response.data.book;
        });
                }
        },
        mounted(){
          this.getUser();
          this.populateForm();
        }

      }
</script>
