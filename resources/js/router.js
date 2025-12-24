import VueRouter from "vue-router";

// Suppress VueRouter NavigationDuplicated and NavigationRedirected errors globally (Vue 2 + VueRouter 3)
// so redundant navigations (e.g. pushing to current route) and auth redirects don't surface as
// "Uncaught (in promise)" in console.
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location, onResolve, onReject) {
    if (onResolve || onReject) {
        return originalPush.call(this, location, onResolve, onReject);
    }
    return originalPush.call(this, location).catch(err => {
        if (
            err &&
            (err.name === "NavigationDuplicated" ||
                err.name === "NavigationRedirected" ||
                (typeof err.message === "string" &&
                    (err.message.includes("Avoided redundant navigation") ||
                        err.message.includes("Redirected when going from"))))
        ) {
            return err;
        }
        return Promise.reject(err);
    });
};

// layouts
import AppLayout from "./layouts/AppLayout";
import PlayLayout from "./layouts/PlayLayout";
import AuthLayout from "./layouts/AuthLayout";
import PageNotFound from "./layouts/PageNotFound";

// pages
import Home from "./pages/Home";
import Announcement from "./pages/Announcement";
import Login from "./pages/Login";
import Register from "./pages/Register";
import GameMain from "./pages/Game/Main";
import GameChannel from "./pages/Game/Channel";
import GameHall from "./pages/Game/Hall";
import GamePlay from "./pages/Game/Play";

import ResultMain from "./pages/Result/Main";
import MyBetsMain from "./pages/MyBets/Main";
import AccountMain from "./pages/Account/Main";
import ChangePassword from "./pages/Account/ChangePassword";
import RankBonus from "./pages/Account/RankBonus";
import InvestorDetail from "./pages/Account/InvestorDetail";
import EditProfile from "./pages/Account/EditProfile";
import MyDownline from "./pages/Account/MyDownline";

const router = new VueRouter({
    mode: "history",

    routes: [
        { path: "", redirect: "/home" },
        {
            path: "/home",
            component: AppLayout,
            children: [{ path: "", name: "home", component: Home }]
        },
        {
            path: "/announcement",
            component: AppLayout,
            meta: {
                auth: true
            },
            children: [{ path: "", name: "announcement", component: Announcement }]
        },
        {
            path: "/",
            component: AppLayout,
            meta: {
                auth: true
            },
            children: [
                { path: "trades", name: "trades", component: GameMain },
                {
                    path: "trades/:gameType",
                    name: "tradesChannel",
                    component: GameChannel
                },

                { path: "result", name: "result", component: ResultMain },
                { path: "my-trades", name: "my-trades", component: MyBetsMain },
                {
                    path: "my-downline",
                    name: "my-downline",
                    component: MyDownline
                },
                { path: "account", name: "account", component: AccountMain },
                {
                    path: "account/edit_profile",
                    name: "accountEdit",
                    component: EditProfile
                },
                {
                    path: "account/change_password",
                    name: "accountChangePassword",
                    component: ChangePassword
                },
                {
                    path: "account/rank_bonus",
                    name: "accountRankBonus",
                    component: RankBonus
                },
                {
                    path: "account/investor_detail",
                    name: "accountInvestorDetail",
                    component: InvestorDetail
                }
            ]
        },
        {
            path: "/trades/:gameType/:gameChannel",
            component: PlayLayout,
            meta: {
                auth: true
            },
            children: [{ path: "", name: "tradesPlay", component: GamePlay }]
        },
        {
            path: "/login",
            component: AuthLayout,
            meta: {
                auth: false
            },
            children: [{ path: "", name: "login", component: Login }]
        },
        {
            path: "/register/:referrer?",
            component: AuthLayout,
            meta: {
                auth: false
            },
            children: [{ path: "", name: "register", component: Register }]
        },
        { path: "*", component: PageNotFound }
    ]
});

export default router;
