<template>
    <div class="user-view" v-if="user">

        
        <div class="row">
 
        	<div class="col-md-7">
        		<div class="rounded border bg-white p-3">
        			<table class="border table table-striped fs-6 mb-0 ">
        				<tbody>
        				<tr>
        					<th class="py-1">Nom & Prénom </th>
        				</tr>
        				<tr><td class="ps-2 fs-4 fw-light">
	        				<template v-if="isAdmin==0 && is_modify">
		        				<input type="text" name="name" v-model="user.name">
		        			</template>
		        			<template v-else>
		        				{{ user.name }}
		        			</template>
        			    </td></tr>
        				<tr>
        					<th class="py-1">Identifiant </th>
        				</tr>
        				<tr><td class="ps-2 fs-4 fw-light">{{ user.username }}</td></tr>
        				<tr>
        					<th class="py-1">Email </th>
        				</tr>
        				<tr><td class="ps-2 fs-4 fw-light">{{ user.email }}</td></tr>
        				<tr>
        					<th class="py-1">Profil </th>
        				</tr>
        				<tr><td class="ps-2 fs-4 fw-light">{{ user.role }}</td></tr>
        				<template v-if="isAdmin==0">
        					<tr>
	        					<th class="py-1">Type de compte</th>
	        				</tr>
	        				<tr>
	        					<td class="ps-2 fs-4 fw-light">{{ infoClient.typeCompte }}</td>
	        				</tr>
	        				<tr>
	        					<th class="py-1">Entreprise</th>
	        				</tr>
	        				<tr><td class="ps-2 fs-4 fw-light">
	        					<template v-if="isAdmin==0 && is_modify">
		        					<input type="text" name="name" v-model="infoClient.enterprise">
			        			</template>
			        			<template v-else>
			        				{{ infoClient.enterprise }}
			        			</template>
	        				
	        				</td></tr>
	        				<tr>
	        					<th class="py-1">Adresse</th>
	        				</tr>
	        				<tr><td class="ps-2 fs-4 fw-light">
	        					<template v-if="isAdmin==0 && is_modify">
		        					<input type="text" name="name" v-model="infoClient.address">
			        			</template>
			        			<template v-else>
			        				{{ infoClient.address }}
			        			</template>
	        				</td></tr>
	        				<tr>
	        					<th class="py-1">Téléphone</th>
	        				</tr>
	        				<tr><td class="ps-2 fs-4 fw-light">

	        					<template v-if="isAdmin==0 && is_modify">
		        					<div class="d-flex">
		        						<input type="text" class="me-2" name="name" v-model="infoClient.phone_code" style="width: 50px">
		        						<input type="text" name="name" v-model="infoClient.phoneUnique"></div>
			        			</template>
			        			<template v-else>
			        				{{ infoClient.phone }}
			        			</template>
	        				</td></tr>
        				</template>
        				</tbody>
        			</table>
        			<div v-if="isAdmin==0" class="pt-3">
        				<button class="btn btn-lg btn-warning" v-if="!is_modify" @click="modify">Modifier</button>
        				<button class="btn btn-lg btn-success me-3" v-if="is_modify" @click="save">Enregister</button>
        				<button class="btn btn-lg btn-secondary" v-if="is_modify" @click="cancel">Annuler</button>
        			</div>
        		</div>
        	</div>
        </div>

    </div>
</template>

<script type="text/ecmascript-6">
const Swal = require('sweetalert2');
export default {
    components: {},
    name: "AccountUser",
    props: {
        dataUser: {type: Object, required: false, default() {return {}}},
        route:  {type: String, required: true},
        isAdmin: {type: Number, required: true},
    },
    data() {
        return {
           user: {},
            infoClient: {
                typeCompte: '',
                enterprise:'',
                address: '',
                phone: '',
                phoneUnique: ''
            },
            is_modify: false
        }

    },
    methods: {
        setInfo(user){

            this.infoClient.typeCompte = '';
            this.infoClient.enterprise = '' ;
            this.infoClient.address = '' ;
            this.infoClient.phone = '' ;
            
            let self = this;
            axios.get(`client-infos/${user.id}`)
                .then(res => {
                    console.log(res);
                    self.infoClient.typeCompte = res.data.typeCompte;
                    self.infoClient.enterprise = res.data.company;
                    self.infoClient.phone = res.data.phone_code+res.data.phone;
                    self.infoClient.address = res.data.address;
                    self.infoClient.phoneUnique =  res.data.phoneUnique;
                    self.infoClient.phone_code =  res.data.phone_code;
                })
                .catch(error => {
                 
                });
           
        },
        modify(){
        	this.is_modify = true;
        },
         cancel(){
        	this.is_modify = false;
        },
        save(){
        	 axios.put(this.route, {user: this.user, infos: this.infoClient})
                .then(response => {
                    let self = this;
                    console.log(response);
                    if(response.data.code==0){
                        Swal.fire({
                          title: 'Succés!',
                          text: 'Modifié avec succés.',
                          type: 'success'
                        }).then(function() {
                            location.reload();
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
        }

    },
    watch: {
        
    },
    beforeMount() {
       
    },
    mounted() {
       this.user = this.dataUser.data[0];
       console.log(this.user, this.isAdmin);
       if(this.isAdmin==0){
       	this.setInfo(this.user);
       }
    }
}
</script>

