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
                       
                       

                         <div class="d-flex align-items-center">
                            <input name="name" v-model="filters.search" class="form-control w-200 ml-3" placeholder="Search for ID"/>
                            <!--button class="btn-primary btn ml-2 rounded-lg shadow-sm font-weight-bold">Search</button-->
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

                        <div v-for="(status, index) in orderStatus" v-bind:value="index">

                             <template v-if="item.status==index">
                            
                                <span class="text-primary"> {{ status  }}</span>
                            </template>
                            
                        </div>
                       
                       
                    </slot> 
                    <slot v-if="column.label === 'Client'">
                         <template v-if="isAdmin">  
                            <a class="text-primary align-middle" title="Fiche client" @click="setInfo(item.infouser)" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="material-symbols-outlined align-middle">
                            perm_contact_calendar
                            </span></a>
                           </template>
                           <span class="align-middle">{{ item.user }}</span>
                    </slot> 
                    <slot v-if="column.label === 'Action'">
                    <div class="justify-content-end align-items-center d-flex">
                         
                           <template v-if="item.status==currentStatus"> 
                                <button class="btn btn-success btn-sm"  @click="showConfirm(item.id)">Valider</button>
                           </template>
                           <template v-if="canEdit"> 
                                <a class="btn-default bg-transparent text-primary btn-sm" title="Modifier" :href="'/admin/orders/'+item.id+'/edit'"><span class="material-symbols-outlined">edit_note</span></a>
                           </template>
                            <template v-if="item.status==attenteLivraison">  
                                <button class="btn btn-success btn-sm"  @click="showConfirmLivraison(item.id)">Livré</button>
                            </template>
                           
                            
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
                <div class="mb-2" title="Type de commpte">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">badge</span>
                    <label class="ps-3">{{ infoClient.typeCompte }}</label>
                </div>
                <div class="mb-2" title="Nom & Prénom">
                    <span class="material-symbols-outlined fs-1 align-middle p-2 bg-light">account_circle_full</span>
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
    },
    data() {
        return {
            perPage: ["25", "50", "100"],
            orderBy: "created_at",
            orderDir: "desc",
            columns: [
                {
                    label: 'Réf CMD',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Client',
                    orderable: false,
                },
                {
                    label: 'Matiere',
                    name: 'type',
                    orderable: true,
                },
                {
                    label: 'Dimension',
                    orderable: false,
                },
                {
                    label: 'Nbre Copie',
                    name: 'unit',
                    orderable: false,
                },
                {
                    label: 'Commentaire',
                    name: 'comment',
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
                length: 25
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
        showConfirm(id){
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

                axios.put(`change-status/${id}/${this.valueStatus}`)
                .then(res => {
                    Swal.fire(
                      'Succés!',
                      'Commande validé avec succés.',
                      'success'
                    );
                })
                .catch(error => {
                    EventBus.$emit(ALERT_MSG, {
                        message: error.response.data.message || error.response.data || 'Error',
                        messageType: 'error',
                    });
                });

               
              }
            });
        },
        showConfirmLivraison(id){
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

                axios.put(`change-status/${id}/${this.orderLivre}`)
                .then(res => {
                    Swal.fire(
                      'Succés!',
                      'Commande validé avec succés.',
                      'success'
                    );
                })
                .catch(error => {
                    EventBus.$emit(ALERT_MSG, {
                        message: error.response.data.message || error.response.data || 'Error',
                        messageType: 'error',
                    });
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
