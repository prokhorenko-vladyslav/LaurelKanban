import Home from '../Components/Pages/Home';
import Login from '../Components/Pages/Login';
import Register from "../Components/Pages/Register";

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
    }
];
