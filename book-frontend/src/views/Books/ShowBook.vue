<template>
  <section class="mb-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="float-start">Book</div>
              <div class="float-end">
                <router-link to="/book/index" class="btn btn-primary btn-sm"
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
                  height="250px"
                />
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Name:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  {{ book.name }}
                </div>
              </div>
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Publisher:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  {{ book.publisher }}
                </div>
              </div>
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>ISBN:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  {{ book.isbn }}
                </div>
              </div>
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Category:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  <span class="badge bg-primary">{{ book.category }}</span>
                </div>
              </div>
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Sub Category:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  <span class="badge bg-success">{{ book.sub_category }}</span>
                </div>
              </div>
              <div class="row mb-3">
                <label
                  for="name"
                  class="col-md-4 col-form-label text-md-end text-start"
                  ><strong>Description:</strong></label
                >
                <div class="col-md-6" style="line-height: 35px;">
                  {{ book.description }}
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
        name:"ShowBook",
        data(){
                return{
                        book:[]
                }
        },
        async mounted(){
          await axios.get("http://127.0.0.1:8000/api/book/"+this.$route.params.id,{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
                        this.book = response.data.book;
                }).catch((error)=>{
                        alert(error.message);
                })
        }

}
</script>
