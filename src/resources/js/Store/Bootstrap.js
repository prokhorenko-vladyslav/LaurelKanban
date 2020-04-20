export default {
    namespaced: true,
    transport: {
        namespaced: true,
        modules: {
            LoadingPool: () => import( './Additional/LoadingPool' ),
            Desk: () => import( './Kanban/Desk' ),
            Collumn: () => import( './Kanban/Collumn' ),
            Card: () => import( './Kanban/Card' )
        }
    }
};