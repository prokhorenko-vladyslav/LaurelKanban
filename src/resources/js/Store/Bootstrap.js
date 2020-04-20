export default {
    namespaced: true,
    transport: {
        namespaced: true,
        modules: {
            LoadingPool: () => import( './Additional/LoadingPool' ),
            Auth: () => import( './Kanban/Auth' ),
            Desk: () => import( './Kanban/Desk' ),
            Collumn: () => import( './Kanban/Collumn' ),
            Card: () => import( './Kanban/Card' )
        }
    }
};