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
                    placeholder="Entrer le nom complet"
                    class="form-control border-0 shadow-none bg-transparent"
                    autocomplete="off" 
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="username" class="mb-0 font-weight-semi-bold">Identifiant</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="username"
                    v-model="user.username"
                    type="username"
                    name="username"
                    placeholder="Entrer username"
                    class="form-control border-0 shadow-none bg-transparent"   
                    required
                    autocomplete="off"
                >
            </div>
        </div>

        <!--div class="mb-3">
            <label for="email" class="mb-0 font-weight-semi-bold">Email</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="email"
                    v-model="user.email"
                    type="email"
                    name="email"
                    placeholder="Entrer email"
                    class="form-control border-0 shadow-none bg-transparent"
                    required
                    autocomplete="off"
                >
            </div>
        </div-->

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
                    autocomplete="off"
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
                    autocomplete="off"
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
                    autocomplete="off"
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
                 
                >
                    <option v-for="(role, index) in userRoles" v-bind:value="index">
                        {{ role }}
                    </option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="mb-0 font-weight-semi-bold">Peux recevoir des notifications client?</label>
            <div class="d-flex align-items-center py-1 div-focus flex-1">
                <input class="form-check-input m-0" type="radio" value="" id="oui" value="1" v-model="user.notifcationClient">
                <label class="form-check-label ps-2" for="oui">
                    Oui
                </label>
                <input class="form-check-input m-0 ms-4" type="radio" value="" id="non" value="0" v-model="user.notifcationClient">
                <label class="form-check-label ps-2" for="non">
                    Non
                </label>
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
            class="btn btn-success btn-lg"
        >
            Valider
        </button>
    </form>
</template>

<script>
const Swal = require('sweetalert2');
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
                status: '',
                notifcationClient: 0,
                username: ''
            }
        }
    },
    methods: {
        saveUser() {
            if(this.user.password != this.user.confirm){
                Swal.fire(
                  'Error!',
                  'Les mots de passe sont différents',
                  'error'
                );

                return false;
            }
            axios.post(this.route, this.user)
                .then(response => {
                    let self = this;
                    console.log(response);
                    if(response.data.code==0){
                        Swal.fire({
                          title: 'Succés!',
                          text: 'Utilisateur crée avec succés.',
                          type: 'success'
                        }).then(function() {
                            window.location.href = self.urlBack;
                        });
                        
                    }else{
                         Swal.fire(
                          'Error!',
                          response.data.message,
                          'error'
                        );
                    }

                   
                })
                .catch(error => {
                   
                });
        },
    },
    created() {
        if (typeof this.userData !== "undefined") {
            this.user = this.userData;
            this.user.roles = this.userData.roles;
        }
    }
}
</script>
