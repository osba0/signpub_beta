 <template>
    <div>
        <data-table
            :columns="columns"
            :url="url"
            :per-page="perPage"
            :order-by="orderBy"
            :order-dir="orderDir"
            :filters="filters"
            ref="orderTable"
            :translate="translate"
        >
         <div slot="filters" slot-scope="{ tableFilters, perPage, tableData }">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <select class="form-control form-select" @change="selectLength($event)" v-model="filters.length">
                            <option v-for="(size, index) in perPage" :value="size">
                             {{ size }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-9 d-flex align-items-center justify-content-end">
                        <div class="col-md-8 d-flex align-items-end justify-content-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutClient">
                              Ajouter un client 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
           
            <tbody slot="body" slot-scope="{ data }">
            <tr :key="item.id" v-for="item in data" class="tr-data">
                <td
                    :key="column.name"
                    v-for="column in columns"
                    class="laravel-vue-datatable-td"
                >
                    <data-table-cell
                        :value="item"
                        :name="column.name"
                        :meta="column.meta"
                    >
                    </data-table-cell>
                    <!--slot v-if="column.label === 'Site'">
                       <span class="font-weight-semi-bold">{{ item.site_name }}</span>
                    </slot-->
                    <slot v-if="column.label === ''">
                         <template v-if="item.logo!='' && item.logo!=null">     
                            <img :src="'/assets/logoClients/'+item.logo" width='50'/>
                         </template>
                    </slot>
                    <slot v-if="column.label === 'Action'">

                        <div class="justify-content-start align-items-center d-flex">
                          <a class="btn text-primary cursor-pointer text-decoration-none" title="Fiche client" @click="setInfo(item)" data-bs-toggle="modal" data-bs-target="#ficheClient"><span class="material-symbols-outlined">visibility</span></a>
                          <a title="Editer"  @click="edit(item)" class="btn px-0 text-warning bg-transparenttext-primary"><span class="material-symbols-outlined"  data-bs-toggle="modal" data-bs-target="#ajoutClient">border_color</span></a>
                         <button class="btn text-danger" title="Supprimer" @click="deleteClient(item)"><span class="material-symbols-outlined">delete</span></button>
                                               
                            
                       </div>
                    </slot>
                </td>
            </tr>
            </tbody>

        </data-table>
        <!--Modal Ajout commande-->
        <div class="modal fade" id="ajoutClient" tabindex="-1" aria-labelledby="modalClient" aria-hidden="true" data-bs-backdrop="static">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalClient">
                        <template v-if="isEdit">Modifier</template>
                        <template v-else>Nouveau Client</template>
                    
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="saveClient"
                        :action="'/clients/save'"
                        enctype="multipart/form-data"
                        method="post">
                      <div class="modal-body">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Type de compte</label>

                            <div class="col-md-6 d-flex align-items-center">
                                <div class="bg-light px-2 rounded me-3 d-flex">
                                    <input id="particulier" type="radio"  value="1" class="form-check-input" name="formClient" v-model="formClient.typeCompte"> 
                                    <label class="form-check-label fw-light ps-2" for="particulier">
                                        Particulier
                                    </label>  
                                </div>
                                <div class="bg-light px-2 rounded me-3 d-flex">
                                    <input id="revendeur" type="radio" value="2" class="form-check-input" name="formClient" v-model="formClient.typeCompte">
                                    <label class="form-check-label fw-light ps-2" for="revendeur">
                                        Revendeur
                                    </label>   
                                </div>
                                <div class="bg-light px-2 rounded me-3 d-flex">
                                    <input id="entreprise" type="radio" value="3"  class="form-check-input" name="formClient" v-model="formClient.typeCompte">
                                    <label class="form-check-label fw-light ws-nowrap ps-2" for="entreprise">
                                        Entreprise / Association
                                    </label>   
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nom & Prénom</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" v-model="formClient.name" required autocomplete="name" autofocus>
                            </div>
                        </div>

                         <div class="row mb-3">
                            <label for="compagnie" class="col-md-4 col-form-label text-md-end">Société</label>

                            <div class="col-md-6">
                                <input id="compagnie" type="text" class="form-control" name="company" v-model="formClient.company">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Adresse</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" v-model="formClient.address" >
                            </div>
                        </div>

                         

                         <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Téléphone</label>

                            <div class="col-md-6 d-flex">  
                                <div class="col-3">
                                    <div class="input-group-desc">
                                    <input class="form-control" type="text" name="area_code" v-model="formClient.area_code">
                                    <label class="fw-light fs-6">Indicatif</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="input-group-desc ps-2">
                                    <input class="form-control" type="text" name="phone" v-model="formClient.phone">
                                    <label class="fw-light fs-6">Numéro de téléphone</label>
                                    </div>
                                </div>
                                   
                            </div>
                          
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" v-model="formClient.email" required autocomplete="email">

                               
                            </div>
                        </div>
                        <div class="row mb-3">
                             <label for="photos" class="col-md-4 col-form-label text-md-end" >Logo</label>
                             <div class="col-md-6">
                               
                                 <input type="file" id="file" name="file"   :disabled = "isEdit && hasLogo" ref="file" v-on:change="handleFileUpload()"/>

                                  <template v-if="isEdit && hasLogo">
                                    <div class="d-flex align-items-center">
                                        <img :src="'/assets/logoClients/'+logoName" height="20"/>
                                        <span class="ml-1 small"></span>
                                        <button class="btn p-0 ms-2" title="Supprimer le logo" type="button" v-on:click="removeLogo(logoName)"><i aria-hidden="true" class="fa fa-close text-danger"></i></button>
                                    </div>
                                   
                                </template>
                            </div>
                        </div>


                       
                      <div class="modal-footer">
                        <template v-if="isEdit">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                             <button
                                type="submit"
                                class="btn btn-success"
                            >
                                <span v-if="isloading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Enregister
                            </button>
                        </template>
                        <template v-else>
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                             <button
                                type="submit"
                                class="btn btn-success"
                            >
                                <span v-if="isloading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Créer le compte
                            </button>
                        </template>
                       
                      </div>
                  </div>  
              </form>
            </div>
          </div>
        </div>
         <!-- Modal Fiche Client-->
        <div class="modal fade" id="ficheClient" tabindex="-1" aria-labelledby="ficheClientLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="ficheClientLabel"><span class="p-2 bg-light material-symbols-outlined fs-2 me-2 align-middle">contacts</span> Fiche Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body ps-3">
                <div class="mb-2" title="Type de compte">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">badge</span>
                    <label class="ps-3">{{ infoClient.typeCompte }}</label>
                </div>
                <div class="mb-2" title="Nom & Prénom">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">account_circle</span>
                    <label class="ps-3">{{ infoClient.name }}</label>
                </div>
                 <div class="mb-2" title="Société">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">business_center</span>
                    <label class="ps-3">{{ infoClient.enterprise }}</label>
                    <template v-if="infoClient.logo!='' && infoClient.logo!=null">     
                            <img :src="'/assets/logoClients/'+infoClient.logo" width='50' class="ms-3" />
                         </template>
                </div>
                 <div class="mb-2" title="Adresse">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">person_pin_circle</span>
                    <label class="ps-3">{{ infoClient.address }}</label>
                </div>
                 <div class="mb-2" title="Téléphone">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">contact_phone</span>
                    <label class="ps-3">{{ infoClient.phone }}</label>
                </div>
                 <div class="mb-2" title="Email">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">alternate_email</span>
                    <label class="ps-3">{{ infoClient.email }}</label>
                </div>
                 <div class="mb-2" title="Date inscription">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">event_available</span>
                    <label class="ps-3">{{ infoClient.date }}</label>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">
const Swal = require('sweetalert2');
export default { 
    name: "UserDataTable",    
    
    props: {
        url: {type: String, required: true}
    },
    data() {
        return {
            perPage: ["25", "50", "100"],
            orderBy: "created_at",
            orderDir: "desc",
            columns: [
                {
                    label: '',
                    //name: 'logo',
                    orderable: false,
                },
                {
                    label: 'Client',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Identifiant',
                    name: 'username',
                    orderable: true,
                },
                {
                    label: 'Mot de passe',
                    name: 'password',
                    orderable: true,
                },
                {
                    label: 'Entreprise',
                    name: 'company',
                    orderable: true,
                },
                {
                    label: 'Type de compte',
                    name: 'typecompte',
                    orderable: true,
                },
                {
                    label: 'Telephone',
                    name: 'phone',
                    orderable: true,
                },
               /* {
                    label: 'Adresse',
                    name: 'address',
                    orderable: false,
                },*/
                {
                    label: 'Total commande',
                    name: 'total_cmd',
                    orderable: false,
                },
                /*{
                    label: 'Status',
                    name: 'is_online',
                    orderable: false,
                },
                {
                    label: 'Date inscription',
                    name: 'created_at',
                    orderable: false,
                },*/
                {
                    label: 'Action',
                    orderable: false,
                },
                
            ],
            infoClient: {
                typeCompte: '',
                name: '',
                enterprise:'',
                address: '',
                email: '',
                phone: '',
                date: '',
                logo:''
                
            },
            filters: {
                search: '',
                length: 25
            },
            translate: {
                nextButton: '❯',
                previousButton: '❮',
                placeholderSearch: 'Rechercher'
            },
            tableData: {}, 
            formClient: {
                typeCompte: 1,
                name: '',
                company: '',
                address: '',
                area_code: '221',
                phone: '',
                email: '',
                logo: '',
                id:'',
                userId: ''
            },
            isloading: false,
            hasImage: false,
            attachments: [],
            isEdit: false,
            hasLogo: false,
        };
    },
    methods: {
        selectLength(event) {
            this.filters.length = event.target.value;
            return true;
        },
         handleFileUpload(){
           this.formClient.logo = this.$refs.file.files[0];
          
        },
        showOrder(item) {
            window.open('/order-get/' + item.id, '_self');
        },
        paginationChangePage(page) {
            return this.$refs.orderTable.paginationChangePage(page);
        },
        deleteClient(user){
            Swal.fire({
              title: "Etes-vous sûr de vouloir supprimé <u>"+user.name+"</u>?",
              text: "La suppression est définitive!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oui, supprimé!'
            }).then((result) => {
              if (result.isConfirmed) {


                axios.delete('clients/delete-client/'+user.user)
                .then(response => {
                    if(response.data.code==0){
                         Swal.fire({
                            title: 'Supprimé!',
                            text:   user.name+' a été supprimé.',
                            icon:  'success'
                            }).then((result) => {
                        location.reload();
                    });

                    }else{
                        Swal.fire(
                          'Error!',
                        '',
                          'error'
                        ); 
                    }
                })
                .catch(error => {
                    
                });
               
              }
            });
        },
        saveClient() {
            

            this.isloading = true;



            const data = new FormData();
            data.append('typeCompte', this.formClient.typeCompte);
            data.append('name', this.formClient.name);
            data.append('company', this.formClient.company);
            data.append('address', this.formClient.address);
            data.append('area_code', this.formClient.area_code);
            data.append('phone', this.formClient.phone);
            data.append('email', this.formClient.email);
            data.append('file', this.formClient.logo);

            var route='save';

            if(this.isEdit){
                route='edit';
                data.append('idClient', this.formClient.id);
                data.append('nameLogo', this.logoName);
                data.append('userClient', this.formClient.userId)
            }

            
            axios.post('/clients/'+route, data)
                .then(response => {
                    let self = this;
    
                    if(response.data.code==0){
                        Swal.fire({
                          title: 'Succés!',
                          text: !this.isEdit?'Client crée avec succés.':'Modifié avec success',
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

                    this.isloading = false;

                   
                })
                .catch(error => {
                   this.isloading = false;
                });
        },
         setInfo(client){
            console.log(client);
            this.infoClient.typeCompte = client.typecompte;
            this.infoClient.name = client.name ;
            this.infoClient.enterprise = client.company ;
            this.infoClient.address = client.address ;
            this.infoClient.email = client.email ;
            this.infoClient.phone = client.phone_code+' '+client.phone ;
            this.infoClient.date = client.created_at ;
            this.infoClient.logo = client.logo;
            
           
        },
        removeImage(){
            this.hasImage = false;
            this.formClient.logo = "";
        },
        edit(client){
            this.isEdit = true;
           
            this.isloading = false;
            
            this.formClient.typeCompte = client.type_id; 
            this.formClient.name = client.name;
            this.formClient.company = client.company;
            this.formClient.address =  client.address ;
            this.formClient.area_code = client.phone_code;
            this.formClient.phone = client.phoneOnly;
            this.formClient.email= client.email;
            this.logoName = client.logo;
            this.formClient.id= client.id;
             this.formClient.userId = client.user;   
       
            if(client.logo==null || client.logo==''){
               
                this.hasLogo=false;
                this.logoName = '';
            }else{
            
                this.hasLogo=true;
                this.logoName = client.logo;
            }
        },
        removeLogo(logo){

                Vue.swal.fire({
                  title: 'Confirmez la suppression du logo',
                  text: '', //logo,
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Oui, supprimer!'
                }).then((result) => {
                  if (result.isConfirmed) {
                        this.hasLogo = false;
                        this.formClient.file = '';
                        this.logoName = '';

                        const data = new FormData();
                        data.append('logo', logo);

                        axios.post('/admin/clients/remove-logo-client', data)
                        .then(response => {})
                        .catch(error => {
                           this.isloading = false;
                        });
                          
                    }
                });
            }
    },
    watch: {
        activeStatus: function () {
            let self = this;
            axios.get(`clients/client-list?search=${self.search}&dir=desc&column=imported_at&length=10&draw=0&page=1`)
                .then(res => {
                    //
                })
                .catch(error => {
                    EventBus.$emit(ALERT_MSG, {
                        message: error.response.data.message || error.response.data || 'Error',
                        messageType: 'error',
                    });
                });
        }
    }
   
};
</script>
