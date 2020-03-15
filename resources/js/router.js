import VueRouter from 'vue-router' 
import store from './store'

import mainApp from './mainApp'
import DashboardComponent from './components/DashboardComponent'
import ShopComponent from './components/ShopComponent'
import AddItemComponent from './components/AddItemComponent'
import LoginComponent from './components/LoginComponent'

export const router = new VueRouter({ 
    mode: 'history', 
    
    routes: [ 
        {
            path: '/', 
            component: mainApp,
            props: {loginComponent: LoginComponent},
    
            children: [
                {
                    path: 'dashboard',
                    component: DashboardComponent,
                    beforeEnter: (to, from, next) => {
                        if (!window.auth.check()) {
                            next({
                                path: '/'
                            });
                            return;
                        }
                        next();
                    }
                },

                {
                    path: 'shop',
                    component: ShopComponent,
                },

                {
                    path: 'add-item',
                    component: AddItemComponent,
                    beforeEnter: (to, from, next) => {
                        if (!window.auth.check()) {
                            next({
                                path: '/'
                            });
                            return;
                        }
                        next();
                    }
                },
            ]
        },
    ]
})

router.beforeEach((to, from, next) => {
    // Start the route progress bar.
    NProgress.start()
    
    next()
    
})

router.afterEach((to, from) => {
    // Complete the animation of the route progress bar.
    NProgress.done()
})