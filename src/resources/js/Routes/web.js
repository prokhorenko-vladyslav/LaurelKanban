import Home from '../Components/Pages/Home';
import Login from '../Components/Pages/Login';
import Register from "../Components/Pages/Register";
import Desks from "../Components/Pages/Desks";
import Desk from "../Components/Pages/Desk";

export default [ {
        path: '/',
        component: Home,
        name: 'kanban.home'
    },
    {
        path: '/login',
        component: Login,
        name: 'kanban.login'
    },
    {
        path: '/register',
        component: Register,
        name: 'kanban.register'
    },
    {
        path: '/desks',
        component: Desks,
        name: 'kanban.desks'
    },
    {
        path: '/desks/:desk',
        component: Desk,
        name: 'kanban.desk'
    },
];
