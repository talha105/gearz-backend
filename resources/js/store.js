export default {
    state: {
        authUser: "",
        locale: 'en',
        oldURL: {},
        genreStatus : false,
        authorized : false,
        currentAdmin : '',
        currentPermissions : '',
        banners : []
    },
    mutations: {
    login(state , payload) {
          state.authUser = payload;
      },
    logout(state) {
          state.authUser = '';
        //   console.log(state , payload , 'Store')
      },
    localeUpdate(state , payload) {
          state.locale = payload;
          //   console.log(state , payload , 'Store')
        },
    setPrevRoute(state , payload) {
        // state.oldURL = payload;
        console.log(payload)
        //   state.prevRoute = payload;
      },
      setGenreStatus(state , payload) {
        state.genreStatus = payload;
      },
      setBanners(state , payload) {
        state.banners = payload;
      },
      setCurrentAdmin(state , payload){
        state.currentAdmin = payload
      },
      setCurrentAdminPermissions(state , payload){
        state.currentPermissions = payload
      },
      setUnauthorized(state , payload){
        state.authorized = payload
      },
    //   resetState(state){
    //     state.authUser = ''
    //     state.locale = 'en'
    //     state.oldURL = ''
    //     state.genreStatus = false
    //     state.authorized = false
    //     state.currentAdmin = ''
    //     state.currentPermissions = ''
    //     state.banners = []
    //   },

    },
    getters: {
        // admin
        getCurrentAdmin(state){
            if(state.currentAdmin){
                return state.currentAdmin
            }else{
                return false
            }
          },


        isAuthenticated(state){
            if(state.authUser){
                return state.authUser;
            }else{
                return false
            }
        },
        // someMethod: (state) => (id) => {

        hasPermission : (state) => (permission) => {

            // console.log(state , permission)
            let isAllowed = false
            if(!state.currentAdmin.is_super_admin){

                if(state.currentAdmin && state.currentPermissions){
                    state.currentPermissions.map( per => {
                        if(per == permission){
                            isAllowed = true
                        }
                    })
                }
            }
            if(state.currentAdmin.is_super_admin){
                isAllowed = true
            }
            return isAllowed;
        },
        getCurrentPermissions(state){
            if(state.currentPermissions){
                return state.currentPermissions
            }else{
                return []
            }
        },
        isAuthorized(state){
            if(state.authorized){
                return true
            }else{
                return false
            }
        },
        getCurrentLocale(state){
            return state.locale
        },
        getGenreStatus(state){
            return state.genreStatus
        },
        getBanners(state){
            return state.banners
        },
        rtl(state){
            if(state.locale && state.locale == 'ar'){
                return true;
            }else{
                return false
            }
        },
        ltr(state){
            if(!state.locale || state.locale == 'en'){
                return true;
            }else{
                return false
            }
        },
        getPrevRoute(state){
            if(state.prevRoute){
                return state.prevRoute;
            }else{
                return false
            }
        },
    }
}
