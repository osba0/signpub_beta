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
                    <div class="col-md-4">
                         Nbre de ligne par page
                        <select class="form-control form-select" @change="selectLength($event)" v-model="filters.length">
                            <option v-for="(size, index) in perPage" :value="size">
                             {{ size }}
                            </option>
                        </select>
                    </div>
                    <template v-if="canFitreStatus == 1">
                     <div class="col-md-4 mt-3 mt-md-0 mt-xl-0 mt-xxl-0">
                        Filtre Etat
                        <select class="form-control form-select" v-model="filters.status">
                            <option value="0">Tout</option>
                            <option v-for="(etat, index) in orderStatus" :value="index">
                             {{ etat }}
                            </option>
                        </select>
                        </div>
                    </template>
                    <div class="col-md-9 d-flex align-items-center justify-content-end d-none">
                       
                       

                         <div class="d-flex align-items-center">
                            <input name="name" v-model="filters.search" class="form-control w-200 ml-3 d-none" placeholder="Search for ID"/>
                           
                        </div>
                    </div>
                </div>
            </div>
           
            <tbody slot="body" slot-scope="{ data }">
            <tr :key="item.id" v-for="item in data" class="tr-data">
                <td
                    :key="column.name"
                    v-for="column in columns"
                    class="laravel-vue-datatable-td align-middle"
                >
                    <data-table-cell
                        :value="item"
                        :name="column.name"
                        :meta="column.meta"
                    >
                    </data-table-cell>
                    <slot v-if="column.label === 'Dimension'">
                       <span class="font-weight-semi-bold">{{ item.long * item.larg }}m<sup>2</sup> ({{ item.long }}x{{ item.larg }})</span>
                    </slot>
                     <slot v-if="column.label === 'Status'">

                        <div v-for="(status, value, index) in orderStatus" v-bind:value="value">

                             <template v-if="item.status==value">
                            
                                <span class="rounded-pill badge " :class="'bg-'+etatColor[index]"> {{ status  }}</span>
                            </template>
                            
                        </div>
                       
                       
                    </slot> 
                    <slot v-if="column.label === 'Client'">
                           <template v-if="isAdmin">  
                                <div class="d-flex">
                                    <a class="d-flex text-primary align-middle cursor-pointer text-decoration-none" title="Fiche client" @click="setInfo(item.infouser)" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="material-symbols-outlined align-middle">perm_contact_calendar
                                    </span><span class="align-middle">{{ item.user }}</span></a>
                                </div>
                            </template>
                            <template v-else>  
                                <span class="align-middle">{{ item.user }}</span>
                            </template>  
                    </slot> 
                      <slot v-if="column.label === 'Commentaire'">
                                  <a class="btn btn-default" data-bs-toggle="modal" title="Cliquer pour afficher les commentaires" data-bs-target="#showComment" @click="showComment(item)">
                                   {{ item.comment }}</a>
                            </slot>
                    <slot v-if="column.label === 'Action'">
                    <div class="justify-content-end align-items-center d-flex">
                         
                            <template v-if="item.status==currentStatus">
                                 <span v-if="isloading==item.id" class="p-3 me-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <button v-if="isloading!=item.id" class="btn text-success" title="Valider" @click="showConfirm(item.id, item.infouser.id)">
                                    <span class="material-symbols-outlined">done_outline</span>
                                </button>
                            </template>
                           
                            <template v-if="canEdit && item.status == 1">
                                <a class="btn-default bg-transparent text-primary btn-sm" title="Modifier" :href="'/admin/orders/'+item.id+'/edit'"><span class="material-symbols-outlined">border_color</span></a>
                            </template>

                            <template v-if="item.status==attenteLivraison">  
                                <button class="btn btn-success btn-sm"  @click="showConfirmLivraison(item.id, item.infouser.id)">Livré</button>
                            </template>

                            <a class="btn-default bg-transparent text-dark btn-sm" title="Afficher" :href="'/order-get/'+item.id"><span class="material-symbols-outlined">visibility</span></a>
                           
                            
                       </div>
                    </slot>
                </td>
            </tr>
            </tbody>

        </data-table>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="p-2 bg-light material-symbols-outlined fs-2 me-2 align-middle">contacts</span> Fiche Client</h5>
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
           <!-- Modal -->
        <div class="modal fade" id="showComment" tabindex="-1" aria-labelledby="showCommentLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="showCommentLabel">Commande N°{{ commentDetail.id }} | Commentaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body ps-4">
                <div class="mt-3 maxHeightComment">
                   {{ commentDetail.comment }}
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-center">
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
    name: "OrderListDataTable",    
    
    props: {
        orderStatus: {type: Object, required: true},
        valueStatus: {type: Number, required: true},
        currentStatus: {type: Number, required: true},
        attenteLivraison: {type: Number, required: true},
        orderLivre: {type: Number, required: true},
        canEdit: {type: Number, required: true},
        url: {type: String, required: true},
        isAdmin: {type: Number, required: true},
        canFitreStatus: {type: Number, required: true},
    },
    data() {
        return {
            perPage: ["25", "50", "100"],
            orderBy: "created_at",
            orderDir: "desc",
            columns: [
                {
                    label: 'Réf',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Client',
                    orderable: false,
                },
                {
                    label: 'Matiere',
                    name: 'type_id',
                    orderable: true,
                },
                {
                    label: 'Dimension',
                    orderable: false,
                },
                {
                    label: 'Nbre_Copie',
                    name: 'unit',
                    orderable: false,
                },
                {
                    label: 'Commentaire',
                    //name: 'comment',
                    orderable: false,
                },
                {
                    label: 'Status',
                    orderable: false,
                },
                {
                    label: 'Date',
                    name: 'created_at',
                    orderable: false,
                },
                {
                    label: 'Action',
                    orderable: false,
                }
            ],
            filters: {
                search: '',
                length: 25,
                status: 0
            },
            translate: {
                nextButton: '❯',
                previousButton: '❮',
                placeholderSearch: 'Rechercher'
            },
            tableData: {}, 
            infoClient: {
                typeCompte: '',
                name: '',
                enterprise:'',
                address: '',
                email: '',
                phone: '',
                date: ''
            },
            etatColor: ['secondary fw-normal', 'info text-dark fw-normal', 'warning fw-normal', 'danger fw-normal', 'success fw-normal', 'primary fw-normal', 'dark fw-normal'],
            isloading: false,
            commentDetail: {
                id: '',
                comment: ''
            }
        };
    },
    methods: {
        selectLength(event) {
            this.filters.length = event.target.value;
            return true;
        },
        showOrder(item) {
            window.open('/order-get/' + item.id, '_self');
        },
        paginationChangePage(page) {
            return this.$refs.orderTable.paginationChangePage(page);
        },
        showComment(cmd){
            this.commentDetail.id= cmd.id;
            this.commentDetail.comment = cmd.full_comment;
        },
        showConfirm(id, user_id){
             this.isloading = id;

            Swal.fire({
              title: 'Confirmez la validation',
              text: "",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oui',
              cancelButtonText: 'Non'
            }).then((result) => {
              if (result.isConfirmed) { 
                axios.put(`change-status/${id}/${this.valueStatus}/${user_id}`)
                .then(res => {
                    Swal.fire({
                      title: 'Succés',
                      text: "Commande validé avec succés.",
                      icon: 'success'
                    }).then((result) => {
                        this.isloading = '';
                         location.reload();
                    });
                })
                .catch(error => {
                   
                });

               
              }else{
                this.isloading = '';
              }
            });
        },
        showConfirmLivraison(id, user_id){
             Swal.fire({
              title: 'Confirmez la livraison',
              text: "",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oui',
              cancelButtonText: 'Non'
            }).then((result) => {
              if (result.isConfirmed) {

                axios.put(`change-status/${id}/${this.orderLivre}/${user_id}`)
                .then(res => {
                    Swal.fire({
                      title: 'Succés',
                      text: "Opération effectué avec succés.",
                      icon: 'success'
                    }).then((result) => {
                         location.reload();
                    });
                })
                .catch(error => {
                   
                });

               
              }
            });
        },
        setInfo(user){

            this.infoClient.typeCompte = '';
            this.infoClient.name = user.name ;
            this.infoClient.enterprise = 'user.' ;
            this.infoClient.address = '' ;
            this.infoClient.email = user.email ;
            this.infoClient.phone = '' ;
            this.infoClient.date = user.created_at ;
            
            let self = this;
            axios.get(`client-infos/${user.id}`)
                .then(res => {
                    console.log(res);
                    self.infoClient.typeCompte = res.data.typeCompte;
                    self.infoClient.enterprise = res.data.company;
                    self.infoClient.phone = res.data.phone_code+res.data.phone;
                    self.infoClient.address = res.data.address;
                })
                .catch(error => {
                   console.log("dd");
                });
           
        }
    },
    watch: {
        activeStatus: function () {
            let self = this;
            axios.get(`orders/order-list?search=${self.search}&dir=desc&column=imported_at&length=10&draw=0&page=1`)
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
