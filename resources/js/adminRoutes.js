import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

Vue.use(VueRouter)

const routes = [{
        path: '/admin',
        name: 'home',
        component: require('./admin/index.vue').default
    },
    {
        path: '/admin/dashboard',
        name: 'home',
        component: require('./admin/index.vue').default
    },

    {
        path: '/admin/pages',
        component: require('./admin/pages/index.vue').default
    },
    {
        path: '/admin/admins',
        component: require('./admin/admins/index.vue').default
    },
    {
        path: '/admin/roles',
        component: require('./admin/roles/Roles.vue').default
    },
    {
        path: '/admin/permissions',
        component: require('./admin/admins/permissions.vue').default
    },

    {
        path: '/admin/profile',
        component: require('./admin/admins/profile.vue').default
    },

    {
        path: '/admin/listings',
        component: require('./admin/listings/index.vue').default,
        meta: {
            permission: 'view listings'
        }
    },
    {
        path: '/admin/reported-listings',
        component: require('./admin/listings/reported.vue').default,
        meta: {
            permission: 'view reports'
        }

    },
    {
        path: '/admin/create-listing',
        component: require('./admin/listings/listing-form.vue').default,
        meta: {
            permission: 'create listings'
        }
    },
    {
        path: '/admin/edit-listing/:listing_id',
        component: require('./admin/listings/listing-form.vue').default,
        meta: {
            permission: 'edit listings'
        }
    },

    {
        path: '/admin/change-password',
        component: require('./admin/password/password.vue').default
    },

    {
        path: '/admin/utilities',
        component: require('./admin/utilities/index.vue').default
    },
    {
        path: '/admin/utility/:id/items',
        component: require('./admin/utilities/items.vue').default
    },

    {
        path: '/admin/sellers',
        component: require('./admin/sellers/index.vue').default,
        meta: {
            permission: 'view sellers'
        }
    },
    {
        path: '/admin/logo-update',
        component: require('./admin/logo-update').default
    },

    {
        path: '/admin/banners',
        component: require('./admin/banners/index.vue').default
    },
    {
        path: '/admin/push-notifications',
        component: require('./admin/push-notifications/index.vue').default,
        meta: {
            permission: 'view push notifications'
        }
    },

    {
        path: '/admin/users',
        component: require('./admin/users/index.vue').default,
        meta: {
            permission: 'view users'
        }
    },
    {
        path: '/admin/reviews',
        component: require('./admin/reviews/index.vue').default,
        meta: {
            permission: 'view reviews'
        }
    },
    {
        path: '/admin/display-blocks',
        component: require('./admin/blocks/index.vue').default,
        meta: {
            permission: 'view display blocks'
        }
    },
    {
        path: '/admin/queries',
        component: require('./admin/queries/index.vue').default,
        meta: {
            permission: 'view query'
        }
    },
    {
        path: '/admin/contact-details',
        component: require('./admin/pages/contact-details.vue').default
    },
    {
        path: '/admin/terms',
        component: require('./admin/pages/terms.vue').default
    },

    {
        path: '/admin/genres',
        name: 'category',
        component: require('./admin/genre/index.vue').default,
        meta: {
            permission: 'view genre'
        }
    },
    {
        path: '/admin/transmissions',
        name: 'transmissions',
        component: require('./admin/transmission/index.vue').default,
        meta: {
            permission: 'view transmission'
        }
    },
    {
        path: '/admin/categories',
        name: 'category',
        component: require('./admin/categories/index.vue').default,
        meta: {
            permission: 'view categories'
        }
    },
    {
        path: '/admin/create-category',
        component: require('./admin/categories/category-form.vue').default
    },

    {
        path: '/admin/categories/:cat_id/sub-categories',
        name: 'SubCategories',
        props: true,
        component: require('./admin/categories/sub-categories.vue').default
    },
    {
        path: '/admin/category/:cat_id/sub-category/:sub_id/sub-categories',
        name: 'SubSubCategories',
        props: true,
        component: require('./admin/categories/sub-sub-categories.vue').default
    },

    {
        path: '/admin/categories/:cat_id/features',
        name: 'category',
        props: true,
        component: require('./admin/categories/features.vue').default
    },

    {
        path: '/admin/makes',
        name: 'makes',
        props: true,
        component: require('./admin/makes/index.vue').default,
        meta: {
            permission: 'view makes'
        }
    },
    {
        path: '/admin/make/:make_id/models',
        name: 'models',
        props: true,
        component: require('./admin/makes/models.vue').default
    },
    {
        path: '/admin/model/:model_id/variants',
        name: 'vairnats',
        props: true,
        component: require('./admin/makes/variants.vue').default
    },
    {
        path: '/admin/settings',
        name: 'settings',
        props: true,
        component: require('./admin/settings/index.vue').default
    },
]

export const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: "active",
    // linkExactActiveClass: "active",
})

