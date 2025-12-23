import Vue from "vue";

export default {
    namespaced: true,

    state() {
        return {};
    },

    actions: {

        fetch(data) {
            return Vue.auth.fetch(data);
        },

        refresh(data) {
            console.log('assd', data)
            return Vue.auth.refresh(data);
        },

        login(ctx, data) {
            data = data || {};


            return new Promise((resolve, reject) => {
                Vue.auth
                    .login({
                        url: "auth/login",
                        data: data.data, // Axios
                        remember: data.remember,
                        staySignedIn: data.staySignedIn
                    })
                    .then(res => {
                        if (data.remember) {
                            Vue.auth.remember(
                                JSON.stringify({
                                    username: ctx.getters.user.username
                                })
                            );
                        }

                        // Avoid NavigationDuplicated when already on /home
                        const currentName = Vue.router?.currentRoute?.name;
                        if (currentName !== "home") {
                            Vue.router.push({ name: "home" }).catch(err => {
                                // Ignore redundant navigation errors
                                if (
                                    err &&
                                    (err.name === "NavigationDuplicated" ||
                                        (typeof err.message === "string" &&
                                            err.message.includes(
                                                "Avoided redundant navigation"
                                            )))
                                ) {
                                    return;
                                }
                                throw err;
                            });
                        }

                        resolve(res);
                    }, reject);
            });
        },

        register(ctx, data) {
            data = data || {};

            return new Promise((resolve, reject) => {
                Vue.auth
                    .register({
                        url: "auth/register",
                        data: data.body, // Axios
                        autoLogin: false
                    })
                    .then(res => {

                        if(res.status == 1) {
                            if (data.autoLogin) {
                                ctx.dispatch("login", data).then(resolve, reject);
                            }
                        } else {
                            return res
                        }
                    }, reject);
            });
        },

        impersonate(ctx, data) {
            var props = this.getters["properties/data"];

            Vue.auth.impersonate({
                url: "auth/" + data.user.id + "/impersonate",
                redirect: "user-account"
            });
        },

        unimpersonate(ctx) {
            Vue.auth.unimpersonate({
                redirect: "admin-users"
            });
        },

        logout(ctx) {
            return Vue.auth.logout();
        }
    },

    getters: {
        user() {
            return Vue.auth.user();
        },

        impersonating() {
            return Vue.auth.impersonating();
        }
    }
};
