<template>
    <form
        id="app"
        @submit.prevent="updateOrder"
        :action="'/order/' + order.id"
        method="post"
    >
        <div class="mb-3">
            <label for="matiere" class="mb-0 font-weight-semi-bold">Matiére</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1"> 
                <select
                    id="matieres"
                    v-model="order.type_id"
                    type="text"
                    name="matiere"
                    class="form-select px-2 w-100 border-0 shadow-none"
                    @change="otherMatieres($event)"
                >
                    <option value=''>Choisir</option>
                    <option :value='matiere.id' v-for="matiere in listMatiere">
                        {{ matiere.name }}
                    </option>
                </select>
            </div>
             <template v-if="(order.autre_matiere!=' ' && showOhter) || showOhter">
                <div class="mt-2 bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <input
                    id="other"
                    type="text"
                    v-model="order.autre_matiere"
                    name="otherMatiere"
                    placeholder="Précisez la matiére"
                    class="form-control border-0 shadow-none bg-transparent"
                   
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
                        placeholder="Enter la longueur"
                        class="form-control border-0 shadow-none bg-transparent"
                        required
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
                    placeholder="Enter la largeur"
                    class="form-control border-0 shadow-none bg-transparent"
                    required
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
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="unit" class="mb-0 font-weight-semi-bold">Commentaire</label>
            <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                <textarea 
                    id="commentaire"
                    v-model="order.comment"
                    type="number"
                    name="commentaire"
                    placeholder=""
                    class="form-control border-0 shadow-none bg-transparent"
                    required
                ></textarea>
            </div>
        </div>

        <p>
            <input
                type="hidden"
                name="_token"
            >
        </p>

        <button type="submit" class="btn btn-success btn-lg">
           <span v-if="isloading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Modifier
        </button>
    </form>
</template>

<script>
const Swal = require('sweetalert2');
export default {
    name: "OrderEdit",
    props: {
        listMatiere: {type: Array, required: true},
        route: {type: String, required: true},
        dataOrder: {type: Object, required: true}, 
        urlBack: {type: String, required: true}
    },
    data() {
        return {
            errors: [],
            order: this.dataOrder,
            showOhter: false,
            isloading: false 
        }
    },
    methods: {
        otherMatieres(event){
            var text = event.target.options[event.target.options.selectedIndex].text;
            if(text=='Autre'){ 
                this.showOhter = true;
            }else{
                this.showOhter = false;
            }
        },
        updateOrder() {
            this.isloading=true;   
            axios.put(this.route, this.order)
                .then(response => {
                   
                    var self=this;
                    setTimeout(function(){
                       self.isloading=false;   
                    },500);
                     Swal.fire({
                      title: 'Succés',
                      text: "Commande modifiée avec succés!",
                      icon: 'success'
                    }).then((result) => {
                       // window.location.href = this.urlBack;
                       location.reload();
                    });
                })
                .catch(error => {
                    
                });
        },
    },
    created() {
        this.showOhter = (this.dataOrder.autre_matiere !=' '? true: false);
        if (typeof this.userData !== "undefined") {
            this.user = this.userData;
            this.user.roles = this.userData.roles
        }
    }
}
</script>
