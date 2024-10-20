import {createRouter, createWebHashHistory} from 'vue-router';
import App from './pages/App.vue';
import {useToast} from 'vue-toastification';
const routes = [
    {
        path: '/',
        name: 'app',
        component: App,
        meta: {hasAuth: false},
        children: [
            {
                path: '/balance',
                name: 'balance',
                meta: {hasAuth: true},
                component: () => import('./pages/Balance.vue')
            },
            {
                path: '/users',
                name: 'users',
                meta: {hasAuth: true},
                component: () => import('./pages/Users.vue')
            },
            {
                path: '/operations',
                name: 'operations',
                meta: {hasAuth: true},
                component: () => import('./pages/Operations.vue')
            },

        ],
    },
    {
        path: '/login',
        name: 'login',
        meta: {hasAuth: false},
        component: () => import('./pages/Login.vue'),
    },
    {
        path: '/reset-password',
        name: 'resetPassword',
        meta: {hasAuth: false},
        component: () => {},
        children: [
            {
                path: '/proof-identity',
                name: 'ProofIdentity',
                meta: {hasAuth: false},
                component: () => {},
            },
            {
                path: '/send-code',
                name: 'SendCode',
                meta: {hasAuth: false},
                component: () => {},
            },
            {
                path: '/validate-code',
                name: 'ValidateCode',
                meta: {hasAuth: false},
                component: () => {},
            },
            {
                path: '/change-password',
                name: 'ChangePassword',
                meta: {hasAuth: false},
                component: () => {},
            },
        ],
    },

];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    function checkPermission(allPerm, perm) {
        let result = false;
        for (let index = 0; index < perm.length; index++) {
            result = (allPerm.includes(perm[index]) || result);
        }
        return result
    }

    // await store.restored;
    if (to.matched.some(record => record.meta.hasAuth)) {
        const token = localStorage.getItem('token');
        if (token) {
            if (to.matched.some(record => record.meta.permission)) {
                let permission = JSON.parse(localStorage.getItem('permissions'));
                if (!permission || !checkPermission(permission, to.meta.permission)) {
                    useToast().error('Доступ запрещен');
                } else {
                    next();
                }
            } else {
                next();
            }
        } else {
            router.push({name: 'login'});
        }
    } else {
        next();
    }
});

export default router;
