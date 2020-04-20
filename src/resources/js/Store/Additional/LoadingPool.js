export default {
    state: {
        loadingPool: 0,
        loadingPoolTimerTime: 0,
        loadingPoolTimerInstance: false,
        loadingPoolTimerTimeout: 1000
    },
    mutations: {
        incrementLoadingPool: ( state ) => state.loadingPool++,
        decrementLoadingPool: ( state ) => state.loadingPool--,
        updateLoadingPoolTimerTime: ( state, milliseconds ) => state.loadingPoolTimerTime = milliseconds,
        setLoadingPoolTimerInstance: ( state, loadingPoolTimerInstance ) => state.loadingPoolTimerInstance = loadingPoolTimerInstance,
        clearLoadingPoolTimerInstance: state => clearInterval( state.loadingPoolTimerInstance )
    },
    getters: {
        getLoadingPool: state => state.loadingPool,
        getLoadingPoolTimerInstance: state => state.loadingPoolTimerInstance,
        getLoadingPoolTimerTime: state => state.loadingPoolTimerTime,
        getLoadingPoolTimerTimeout: state => state.loadingPoolTimerTimeout,
    },
    actions: {
        addToLoadingPool( {
            commit,
            getters,
            dispatch
        } ) {
            if ( parseInt( getters[ 'getLoadingPool' ] ) === 0 )
                dispatch( 'startInterval' );
            commit( 'incrementLoadingPool' );
        },
        removeFromLoadingPool( {
            commit,
            getters,
            dispatch
        } ) {
            commit( 'decrementLoadingPool' );
            console.log( parseInt( getters[ 'getLoadingPool' ] ) === 0, getters[ 'getLoadingPoolTimerInstance' ] );
            if ( parseInt( getters[ 'getLoadingPool' ] ) === 0 && getters[ 'getLoadingPoolTimerInstance' ] )
                dispatch( 'stopInterval' );
        },
        startInterval( {
            commit,
            getters
        } ) {
            commit(
                'setLoadingPoolTimerInstance',
                setInterval( () => {
                    return commit( 'updateLoadingPoolTimerTime', parseFloat( getters[ "getLoadingPoolTimerTime" ] ) + getters[ 'getLoadingPoolTimerTimeout' ] )
                }, getters[ 'getLoadingPoolTimerTimeout' ] )
            );
        },
        stopInterval( {
            commit,
            getters
        } ) {
            if ( parseInt( getters[ 'getLoadingPoolTimerTime' ] ) < getters[ 'getLoadingPoolTimerTimeout' ] )
                setTimeout( () => commit( 'clearLoadingPoolTimerInstance' ), getters[ 'getLoadingPoolTimerTimeout' ] - parseInt( getters[ 'getLoadingPoolTimerTime' ] ) );
            else
                commit( 'clearLoadingPoolTimerInstance' );
        }
    }
}