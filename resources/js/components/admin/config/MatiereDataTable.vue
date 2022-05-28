 <template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h3 class="text-warning border-bottom border-warning border-2 mb-4">Liste des Matiéres</h3>
            </div>
            <div class="col-md-3 text-end mb-3">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMatiereModal">
                    <span class="material-symbols-outlined align-middle">add</span>  Ajouter une nouvelle matiére</a>
            </div>
        </div>
        <div class="row justify-content-center">
        <div class="col-md-12">
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
                            <!--input name="name" v-model="filters.search" class="form-control w-200 ml-3" placeholder="Search for ID"/>
                            <button class="btn-primary btn ml-2 rounded-lg shadow-sm font-weight-bold">Search</button-->
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
                    <slot v-if="column.label === 'Autre'">
                      <input type="radio" name="isOther" @change="setOhter(item.id)"  :checked="item.isOther === 1">
                      
                    </slot>
                    <slot v-if="column.label === 'Etat'">
                     <toggle-button @change="onChangeEventHandler(item,  $event)" :value="item.status === 1" :labels="{checked: 'On', unchecked: 'Off'}" style="margin-left: 20px" />
                    </slot>
                     <slot v-if="column.label === 'Action'">
                    <div class="justify-content-start align-items-center d-flex">
                         <button class="btn text-danger" title="Supprimer" @click="deleteMatiere(item)"><span class="material-symbols-outlined">delete</span></button>
                            
                      
  
        <!--toggle-button :labels="{checked: 'Itsolutionstuff.com', unchecked: 'HDTuto.com'}" width="150" style="margin-left: 20px" />
  
        <toggle-button :labels="{checked: 'Yes', unchecked: 'No'}" style="margin-left: 20px" /-->
                           
                            
                       </div>
                    </slot>
                </td>
            </tr>
            </tbody>

        </data-table>
        </div>
        </div>
          <!-- Modal -->
        <div class="modal fade" id="newMatiereModal" tabindex="-1" aria-labelledby="newMatiereModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newMatiereModalLabel">Nouvelle Matiére</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body ps-4">
                <div>
                    <label for="long" class="mb-0 font-weight-semi-bold">Nom</label>
                    <div class="d-flex bg-white align-items-center py-1 border rounded-lg border-2 div-focus flex-1">
                        <input
                            id="name"
                            v-model="name"
                            type="text"
                            name="name"
                            placeholder="Enter le nom de la matiére"
                            class="form-control border-0 shadow-none bg-transparent"
                            required
                        >
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="saveMatiere()">Enregistrer</button>
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
    name: "MatiereDataTable",    
    
    props: {
        url: {type: String, required: true},
        urlBack: {type: String, required: true},
    },
    data() {
        return {
            perPage: ["10", "20", "50"],
            orderBy: "created_at",
            orderDir: "desc",
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Matiéres',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Etat',
                    orderable: true,
                },
                {
                    label: 'Autre',
                    orderable: true,
                },
                {
                    label: 'Date de création',
                    name: 'created_at',
                    orderable: true,
                },
                {
                    label: 'Action',
                    orderable: false,
                },
                
            ],
            filters: {
                search: '',
                length: 10
            },
            translate: {
                nextButton: '❯',
                previousButton: '❮',
                placeholderSearch: 'Rechercher'
            },
            tableData: {},
            name
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
        saveMatiere(){
            axios.post('config/store-matiere', {"name": this.name})
            .then(response => {
                if(response.data.code==0){
                    Swal.fire({
                      title: 'Succés',
                      text: "Matiére validé avec succés.",
                      icon: 'success'
                    }).then((result) => {
                        window.location.href = this.urlBack;
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
        setOhter(id){
            axios.post('config/update-other', {"id": id})
                .then(response => {
                   
                })
                .catch(error => {
                    
                });
        },
        onChangeEventHandler(matiere, event){
           
             axios.post('config/status-matiere', {"id": matiere.id, "status": event.value})
                .then(response => {
                   
                })
                .catch(error => {
                    
                });
        },
        deleteMatiere(matiere){
            Swal.fire({
              title: "Etes-vous sûr de vouloir supprimé <u>"+matiere.name+"</u>?",
              text: "La suppression est définitive!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oui, supprimé!'
            }).then((result) => {
              if (result.isConfirmed) {


                axios.delete('config/delete-matiere/'+matiere.id)
                .then(response => {
                    if(response.data.code==0){
                         Swal.fire({
                            title: 'Supprimé!',
                            text:   matiere.name+' a été supprimé.',
                            icon:  'success'
                            }).then((result) => {
                        window.location.href = this.urlBack;
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
