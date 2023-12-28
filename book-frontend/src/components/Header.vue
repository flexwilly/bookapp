<template>
  <div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand me-auto" href="#">Book App</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-center"
          id="navbarNavAltMarkup"
        >
          <ul class="navbar-nav ">
            <li
              class="nav-item dropdown"
              v-if="role.toString() == 'Super Admin'"
            >
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ user }}
              </a>
              <ul class="dropdown-menu">
                <li v-for=" admin in superAdminRoutes" :key="admin.name">
                  <router-link
                    :to="admin.link"
                    class="dropdown-item"
                    >{{ admin.name }}</router-link
                  >
                </li>
                <li class="nav-item">
                  <button class="nav-link mx-auto" @click="logout">
                    Logout
                  </button>
                </li>
              </ul>
            </li>
            <li
              class="nav-item dropdown"
              v-else-if="role.toString() == 'Admin'"
            >
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ user }}
              </a>
              <ul class="dropdown-menu">
                <li v-for=" admin in adminRoutes" :key="admin.name">
                  <router-link
                    :to="admin.link"
                    class="dropdown-item"
                    >{{ admin.name }}</router-link
                  >
                </li>
                <li class="nav-item">
                  <button class="nav-link mx-auto" @click="logout">
                    Logout
                  </button>
                </li>
              </ul>
            </li>
            <li
              class="nav-item dropdown"
              v-else-if="role.toString() == 'Student'"
            >
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ user }}
              </a>
              <ul class="dropdown-menu">
                <li v-for=" student in studentRoutes" :key="student.name">
                  <router-link
                    :to="student.link"
                    class="dropdown-item"
                    >{{ student.name }}</router-link
                  >
                </li>
                <li class="nav-item">
                  <button class="nav-link mx-auto" @click="logout">
                    Logout
                  </button>
                </li>
              </ul>
            </li>
            <li
              class="nav-item"
              v-else
              v-for="guest in guestRoutes"
              :key="guest.name"
            >
              <router-link
                class="nav-link"
                :to="guest.link"
                >{{ guest.name }}</router-link
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
import axios from 'axios';
export default{
     name:"Header",
     data(){
      return{
        superAdminRoutes:[
          {name:"ManageUsers",link:"/user/index"},
          {name:"ManageRoles",link:"/role/index"},
          {name:"ManagePermissions",link:"/permission/index"},
          {name:"ManageBooks",link:"#"},
          {name:"ManageBookLoans",link:"#"},
        ],
        adminRoutes:[
        {name:"ManageUsers",link:"/user/index"},
        {name:"ManageBooks",link:"/book/index"},
        {name:"ManageBookLoans",link:"#"},

      ],
        studentRoutes:[
        {name:"ViewBooks",link:"/student/book/index"},
        {name:"MyLoanedBooks",link:"/student/bookloans"},
        ],
        guestRoutes:[
        {name:"Login",link:"/"},
        {name:"Register",link:"/register"},
        ],
        user:[],
        role:[],
      }
     },
     methods:{
      async logout(){
        await axios.get('http://127.0.0.1:8000/api/logout',{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}})

        .then((response)=> {
                        alert(response.data.message)
                        localStorage.clear();
                        this.$router.push({name:"Login"});
                }).catch((error)=>{
                  alert(error.message);
                });

      },
      async getLoggedInUser(){
        if(localStorage.getItem("token") !== null){
        await axios.get("http://127.0.0.1:8000/api/auth/user",{ headers: {"Authorization" :`Bearer ${localStorage.getItem("token")}`}}).then((response)=>{
          this.user=response.data.user.name;
          this.role = response.data.role;
        }).catch((error)=>{
          alert(error.message);
          this.$router.push({name:'Login'});
        })

        }
      }
      },
      mounted(){
        this.getLoggedInUser();


      }

}
</script>
