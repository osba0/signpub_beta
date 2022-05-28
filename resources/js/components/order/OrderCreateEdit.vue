<template>
    <form
        id="app"
        @submit.prevent="saveOrder"
        :action="'/order/' + order.id"
        method="post"
    >
         <div class="mb-3">
            <label for="matiere" class="mb-0 font-weight-semi-bold">Matiére</label>
            <div class="bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <select
                    id="matieres"
                    v-model="order.matiere"
                    type="text"
                    name="matiere"
                    class="form-select px-2 w-100 border-0 shadow-none"
                    @change="otherMatieres(this)"
                >
                    <option value=''>Choisir</option>
                    <option :value='matiere' v-for="matiere in listMatiere">
                        {{ matiere.name }}
                    </option> 
                </select>
            </div>
             <template v-if="showOhter">
                <div class="mt-2 bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="other"
                    v-model="order.otherMatiere"
                    type="text"
                    name="other"
                    placeholder="Précisez la matiére"
                    class="form-control border-0 shadow-none bg-transparent"
                    autocomplete="off"
                >
                </div>
            </template>
        </div>

        <div class="mb-3">
            <div>
                <label for="long" class="mb-0 font-weight-semi-bold">Longeur (en métre)</label>
                <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                    <input
                        id="long"
                        v-model="order.long"
                        type="text"
                        name="long"
                        placeholder="Entrer la longueur"
                        class="form-control border-0 shadow-none bg-transparent"
                        required
                        autocomplete="off"
                    >
                </div>
            </div>
            
        </div>

        <div class="mb-3">
            <label for="larg" class="mb-0 font-weight-semi-bold">Largeur (en métre)</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="larg"
                    v-model="order.larg"
                    type="text"
                    name="large"
                    placeholder="Entrer la largeur"
                    class="form-control border-0 shadow-none bg-transparent"
                    required
                    autocomplete="off"
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="unit" class="mb-0 font-weight-semi-bold">Nombre de copie</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="unit"
                    v-model="order.unit"
                    type="number"
                    name="unit"
                    placeholder=""
                    class="form-control border-0 shadow-none bg-transparent"
                    required
                    autocomplete="off"
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="unit" class="mb-0 font-weight-semi-bold">Commentaire</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <textarea 
                    id="commentaire"
                    v-model="order.commentaire"
                    type="number"
                    name="commentaire"
                    placeholder=""
                    class="form-control border-0 shadow-none bg-transparent"
                    autocomplete="off"
                ></textarea>
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
            <span v-if="isloading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Créer
        </button>
    </form>
</template>

<script>
const Swal = require('sweetalert2');
export default {
    name: "UserCreateEdit",
    props: {
        userData: {type: Object, required: false},
        listMatiere: {type: Array, required: true},
        route: {type: String, required: true},
        urlBack: {type: String, required: true}
    },
    data() {
        return {
            errors: [],
            order: {
                id: '',
                matiere: '',
                idMatiere:0,
                long: '',
                larg: '',
                unit: 1,
                commentaire: '',
                otherMatiere: ''
            },
            showOhter: false,
            isloading: false
        }
    },
    methods: {
        otherMatieres(){
            this.order.idMatiere = this.order.matiere.id;
            if(this.order.matiere.name=='Autre'){ 
                this.showOhter = true;
            }else{
                this.showOhter = false;
            }
        },
        saveOrder() {
            this.isloading=true;  
            axios.post(this.route, this.order)
                .then(response => {
                    var self=this;
                    setTimeout(function(){
                       self.isloading=false;   
                    },500);
                     Swal.fire({
                      title: 'Succés',
                      text: "Commande crée avec succés!",
                      icon: 'success'
                    }).then((result) => {
                        window.location.href = this.urlBack;
                    });

                })
                .catch(error => {
                    setTimeout(function(){
                       self.isloading=false;   
                    },500);
                    Swal.fire({
                      title: 'Error',
                      text: error.response,
                      icon: 'error'
                    }).then((result) => {
                      
                    });
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
