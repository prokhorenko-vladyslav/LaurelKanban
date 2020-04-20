import Home from '../Components/Pages/Home';
import Login from '../Components/Pages/Login';

export default [ {
        path: '/',
        component: Home,
        name: 'kanban.home'
    },
    {
        path: '/login',
        component: Login,
        name: 'kanban.login'
    }
];
