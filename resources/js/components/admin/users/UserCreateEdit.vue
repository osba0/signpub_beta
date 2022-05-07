<template>
    <form
        id="app"
        @submit.prevent="saveUser"
        :action="'/user/' + user.id"
        method="post"
    >
         <div class="mb-3">
            <label for="full_name" class="mb-0 font-weight-semi-bold">Nom & Prenom</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="full_name"
                    v-model="user.full_name"
                    type="text"
                    name="full_name"
                    placeholder="Enter full name"
                    class="form-control border-0 shadow-none bg-transparent"
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="mb-0 font-weight-semi-bold">Email</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="email"
                    v-model="user.email"
                    type="email"
                    name="email"
                    placeholder="Enter email"
                    class="form-control border-0 shadow-none bg-transparent"
                    required
                >
            </div>
        </div>

        <div class="mb-3" v-if="user.id === ''">
            <label for="password" class="mb-0 font-weight-semi-bold">Password</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="password"
                    v-model="user.password"
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="form-control border-0 shadow-none bg-transparent"
                >
            </div>
        </div>
        <div class="mb-3" v-if="user.id === ''">
            <label for="password" class="mb-0 font-weight-semi-bold">Confirmer Mot de passe</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="password_confirm"
                    v-model="user.confirm"
                    type="password"
                    name="confirm"
                    placeholder="Confirmer Mot de passe"
                    class="form-control border-0 shadow-none bg-transparent"
                >
            </div>
        </div>

        <div class="mb-3" v-if="user.id !== ''">
            <label for="password" class="mb-0 font-weight-semi-bold">New Password</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="new_password"
                    v-model="user.new_password"
                    type="password"
                    name="password"
                    placeholder="New Password"
                    class="form-control border-0 shadow-none bg-transparent"
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="roles" class="mb-0 font-weight-semi-bold">Role</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <select
                    id="roles"
                    v-model="user.roles"
                    type="text"
                    name="roles"
                    class="form-select px-2 w-100 border-0 shadow-none"
                    size="2"
                >
                    <option v-for="(role, index) in userRoles" v-bind:value="index">
                        {{ role }}
                    </option>
                </select>
            </div>
        </div>

        <p>
            <input
                type="hidden"
                name="_token"
            >
        </p>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Submit
        </button>
    </form>
</template>

<script>

export default {
    name: "UserCreateEdit",
    props: {
        userData: {type: Object, required: false},
        userRoles: {type: Object, required: true},
        route: {type: String, required: true},
        urlBack: {type: String, required: true}
    },
    data() {
        return {
            errors: [],
            user: {
                id: '',
                email: '',
                name: '',
                new_password: '',
                confirm: '',
                full_name: '',
                roles: [],
                status: ''
            }
        }
    },
    methods: {
        saveUser() {
            axios.post(this.route, this.user)
                .then(response => {
                   
                    console.log(response);

                    window.location.href = this.urlBack;
                })
                .catch(error => {
                    let message = '';
                    if (typeof error.response.data.errors === "object") {
                        for (const [key, value] of Object.entries(error.response.data.errors)) {
                            message = message + "\r\n" + value;
                        }
                        EventBus.$emit(ALERT_MSG, {
                            message: message,
                            messageType: 'error',
                            messageTime: 8000
                        });
                    } else {
                        EventBus.$emit(ALERT_MSG, {
                            message: error.response.data,
                            messageType: 'error',
                            messageTime: 8000
                        });
                    }
                    console.log(error.response)
                });
        },
    },
    created() {
        if (typeof this.userData !== "undefined") {
            this.user = this.userData;
            this.user.roles = this.userData.roles
        }
    }
}
</script>
