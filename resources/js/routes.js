import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './views/Home';
import Friends from './views/Friends';
import FriendRequests from './views/FriendRequests';
import Profile from './views/Profile';
import StatusShow from './views/StatusShow';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    base: process.env.APP_URL,
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/amigos',
            name: 'friends',
            component: Friends
        },
        {
            path: '/solicitudes',
            name: 'friendRequests',
            component: FriendRequests
        },
        {
            path: '/estado/:id',
            name: 'status.show',
            component: StatusShow,
            props: true
        },
        {
            path: '/:slug',
            name: 'profile',
            component: Profile,
            props: true
        },
        
    ]
});