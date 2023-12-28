import { createRouter, createWebHistory } from "vue-router";

import Login from "../views/Login";
import Register from "../views/Register";
import Dashboard from "../views/Dashboard";
import ViewRoles from "../views/Roles/ViewRoles";
import CreateRole from "../views/Roles/CreateRole";
import ShowRole from "../views/Roles/ShowRole";
import EditRole from "../views/Roles/EditRole";
import ViewPermissions from "../views/Permissions/ViewPermissions";
import CreatePermission from "../views/Permissions/CreatePermission";
import ShowPermission from "../views/Permissions/ShowPermission";
import EditPermission from "../views/Permissions/EditPermission";

import ViewUsers from "../views/Users/ViewUsers";
import CreateUser from "../views/Users/CreateUser";
import ShowUser from "../views/Users/ShowUser";
import EditUser from "../views/Users/EditUser";

import ViewBooks from "../views/Books/ViewBooks";
import CreateBook from "../views/Books/CreateBook";
import ShowBook from "../views/Books/ShowBook";
import EditBook from "../views/Books/EditBook";

import ViewStudentBooks from "../views/BookLoan/ViewStudentBooks";
import ViewBookLoans from "../views/BookLoan/ViewBookLoans";
import LoanBook from "../views/BookLoan/LoanBook";
import EditBookLoan from "../views/BookLoan/EditBookLoan";

const routes = [
  {
    name: "Login",
    path: "/",
    component: Login,
  },

  {
    name: "Register",
    path: "/register",
    component: Register,
  },
  {
    name: "Dashboard",
    path: "/dashboard",
    component: Dashboard,
    meta: {
      requiresAuth: true,
    },
  },
  //Roles
  {
    name: "ViewRoles",
    path: "/role/index",
    component: ViewRoles,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "CreateRole",
    path: "/role/create",
    component: CreateRole,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "EditRole",
    path: "/role/edit/:id",
    component: EditRole,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "ShowRole",
    path: "/role/show/:id",
    component: ShowRole,
    meta: {
      requiresAuth: true,
    },
  },
  //Permissions
  {
    name: "ViewPermissions",
    path: "/permission/index",
    component: ViewPermissions,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "CreatePermission",
    path: "/permission/create",
    component: CreatePermission,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "EditPermission",
    path: "/permission/edit/:id",
    component: EditPermission,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "ShowPermission",
    path: "/permission/show/:id",
    component: ShowPermission,
    meta: {
      requiresAuth: true,
    },
  },

  //Users

  {
    name: "ViewUsers",
    path: "/user/index",
    component: ViewUsers,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "CreateUser",
    path: "/user/create",
    component: CreateUser,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "EditUser",
    path: "/user/edit/:id",
    component: EditUser,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "ShowUser",
    path: "/user/show/:id",
    component: ShowUser,
    meta: {
      requiresAuth: true,
    },
  },

  //Books
  {
    name: "ViewBooks",
    path: "/book/index",
    component: ViewBooks,
    meta: {
      requiresAuth: true,
    },
  },

  {
    name: "CreateBook",
    path: "/book/create",
    component: CreateBook,
    meta: {
      requiresAuth: true,
    },
  },

  {
    name: "EditBook",
    path: "/book/edit/:id",
    component: EditBook,
    meta: {
      requiresAuth: true,
    },
  },

  {
    name: "ShowBook",
    path: "/book/show/:id",
    component: ShowBook,
    meta: {
      requiresAuth: true,
    },
  },

  //Student Books

  {
    name: "ViewStudentBooks",
    path: "/student/book/index",
    component: ViewStudentBooks,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "ViewBookLoans",
    path: "/student/bookloans",
    component: ViewBookLoans,
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: "LoanBook",
    path: "/student/book/loan/:id",
    component: LoanBook,
    meta: {
      requiresAuth: true,
    },
  },

  {
    name: "EditBookLoan",
    path: "/student/bookloan/edit/:id",
    component: EditBookLoan,
    meta: {
      requiresAuth: true,
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = localStorage.getItem("token");
    if (token) {
      // User is authenticated, proceed to the route
      next();
    } else {
      // User is not authenticated, redirect to login
      next("/");
    }
  } else {
    // Non-protected route, allow access
    next();
  }
});

export default router;
