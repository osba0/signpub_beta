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
                >
                    <option value=''>Choisir</option>
                    <option :value='matiere.id' v-for="matiere in listMatiere">
                        {{ matiere.name }}
                    </option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <div>
                <label for="long" class="mb-0 font-weight-semi-bold">Longeur</label>
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
            <label for="larg" class="mb-0 font-weight-semi-bold">Largeur</label>
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
            order: this.dataOrder
        }
    },
    methods: {
        updateOrder() {
            axios.put(this.route, this.order)
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
