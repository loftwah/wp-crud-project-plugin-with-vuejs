import Dashboard from './Components/Dashboard';
import Settings from './Components/Settings';
import Supports from './Components/Supports';

import AllPosts from './Components/allPosts';
import EditPost from './Components/EditPost';
import AddNewPost from './Components/AddNewPost';

export const routes = [
    {
        path: "/",
        name: "all_posts",
        component: AllPosts
    },

    {
        path: "/add_new_post",
        name: "add_new_post",
        component: AddNewPost
    },

    {
        path: "/edit_Post/:id",
        name: "edit_post",
        component: EditPost
    },

   
    // {
    //     path: '/dashboard',
    //     name: 'dashboard',
    //     component: Dashboard
    // },
    // {
    //     path: '/settings',
    //     name: 'settings',
    //     component: Settings
    // },
    // {
    //     path: '/supports',
    //     name: 'supports',
    //     component: Supports
    // },

];
