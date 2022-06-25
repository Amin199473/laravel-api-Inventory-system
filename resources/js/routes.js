import { createRouter, createWebHistory } from "vue-router";
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import ForgetPassword from './components/auth/ForgetPassword.vue';
import Logout from './components/auth/Logout.vue';
import Home from './components/home.vue';

// employee Routes
import AddEmployee from './components/employee/create.vue';
import AllEmployee from './components/employee/index.vue';
import EditEmployee from './components/employee/Edit.vue';
// employee Routes

// supplier Routes
import AddSupplier from './components/supplier/create.vue';
import AllSupplier from './components/supplier/index.vue';
import EditSupplier from './components/supplier/Edit.vue';
// supplier Routes

// Category Routes
import AddCategory from './components/category/create.vue';
import AllCategory from './components/category/index.vue';
import EditCategory from './components/category/Edit.vue';
// Category Routes

// Product Routes
import AddProduct from './components/product/create.vue';
import AllProduct from './components/product/index.vue';
import EditProduct from './components/product/Edit.vue';
import Stock from './components/product/Stock.vue';
import EditStock from './components/product/EditStock.vue';
// Product Routes

// Expense Routes
import AddExpense from './components/expense/create.vue';
import AllExpense from './components/expense/index.vue';
import EditExpense from './components/expense/Edit.vue';
// Expense Routes

// Salary Routes
import Employees from './components/salary/AllEmployee.vue';
import PaySalary from './components/salary/PaySalary.vue';
import AllSalary from './components/salary/index.vue';
import ViewSalary from './components/salary/ViewSalary.vue';
import EditSalary from './components/salary/EditSalary.vue';
// Salary Routes


// Customer Routes
import AddCustomer from './components/customer/create.vue';
import AllCustomer from './components/customer/index.vue';
import EditCustomer from './components/customer/Edit.vue';
// Customer Routes

//Pos Routes
import PointOfSale from './components/pos/PointOfSale.vue';
//Pos Routes

//order Routes
import Order from './components/order/Order.vue';
import OrderView from './components/order/OrderView.vue';
import OrderSearch from './components/order/OrderSearch.vue';
//order Routes

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: Login, name: '/' },
        { path: '/register', component: Register, name: 'register' },
        { path: '/ForgetPassword', component: ForgetPassword, name: 'forgetPassword' },
        { path: '/home', component: Home, name: 'home' },
        { path: '/logout', component: Logout, name: 'logout' },

        { path: '/AddEmployee', component: AddEmployee, name: 'AddEmployee' },
        { path: '/AllEmployee', component: AllEmployee, name: 'AllEmployee' },
        { path: '/editEmployee/:id', component: EditEmployee, name: 'editEmployee' },

        { path: '/AddSupplier/', component: AddSupplier, name: 'AddSupplier' },
        { path: '/AllSupplier/', component: AllSupplier, name: 'AllSupplier' },
        { path: '/editSupplier/:id', component: EditSupplier, name: 'editSupplier' },

        { path: '/AddCategory/', component: AddCategory, name: 'AddCategory' },
        { path: '/AllCategory/', component: AllCategory, name: 'AllCategory' },
        { path: '/editCategory/:id', component: EditCategory, name: 'editCategory' },

        { path: '/AddProduct/', component: AddProduct, name: 'AddProduct' },
        { path: '/AllProduct/', component: AllProduct, name: 'AllProduct' },
        { path: '/editProduct/:id', component: EditProduct, name: 'editProduct' },
        { path: '/Stock/', component: Stock, name: 'Stock' },
        { path: '/EditStock/:id', component: EditStock, name: 'EditStock' },

        { path: '/AddExpense/', component: AddExpense, name: 'AddExpense' },
        { path: '/AllExpense/', component: AllExpense, name: 'AllExpense' },
        { path: '/editExpense/:id', component: EditExpense, name: 'editExpense' },

        { path: '/Employees/', component: Employees, name: 'Employees' },
        { path: '/PaySalary/:id', component: PaySalary, name: 'PaySalary' },
        { path: '/AllSalary', component: AllSalary, name: 'AllSalary' },
        { path: '/ViewSalary/:id', component: ViewSalary, name: 'ViewSalary' },
        { path: '/EditSalary/:id', component: EditSalary, name: 'EditSalary' },

        { path: '/AddCustomer', component: AddCustomer, name: 'AddCustomer' },
        { path: '/AllCustomer', component: AllCustomer, name: 'AllCustomer' },
        { path: '/editCustomer/:id', component: EditCustomer, name: 'editCustomer' },

        { path: '/POS', component: PointOfSale, name: 'POS' },

        { path: '/order', component: Order, name: 'order' },
        { path: '/orderView/:id', component: OrderView, name: 'orderView' },
        { path: '/orderSearch', component: OrderSearch, name: 'orderSearch' },

    ]
})


export default router;
