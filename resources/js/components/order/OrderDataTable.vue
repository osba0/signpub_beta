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
            :classes="classes"
        >
         <div slot="filters" slot-scope="{ tableFilters, perPage, tableData }">
                <div class="row mb-2">
                    <div class="col-md-4 mb-xl-3">
                        Nbre de ligne par page
                        <select class="form-control form-select" @change="selectLength($event)" v-model="filters.length">
                            <option v-for="(size, index) in perPage" :value="size">
                             {{ size }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0 mt-xl-0 mt-xxl-0">
                        Filtre Etat
                        <select class="form-control form-select" v-model="filters.status">
                            <option value="0">Tout</option>
                            <option v-for="(etat, index) in orderStatus" :value="index">
                             {{ etat }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-end">
                         <!--div class="d-flex align-items-start flex-column">
                            Recherche
                            <input v-model="filters.search" class="form-control w-200 ml-3" placeholder="N°commande, matiére..."/>
                          
                        </div-->
                    </div>
                </div>
            </div>
            <tbody slot="body" slot-scope="{ data }">
            <tr v-if="tableData.length > 0">
                 <td colspan="8" align="center">Aucune commande disponible <a href="/orders/create">Créer une nouvelle commande</a></td>
            </tr>
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
                       <span class="font-weight-semi-bold">{{ (item.long * item.larg).toFixed(2) }}m<sup>2</sup> ({{ item.long }}x{{ item.larg }})</span>
                    </slot>
                    <slot v-if="column.label === 'Commentaire'">
                          <a class="btn btn-default" data-bs-toggle="modal" title="Cliquer pour afficher les commentaires" data-bs-target="#showComment" @click="showComment(item)">
                           {{ item.comment }}</a>
                    </slot>
                     <slot v-if="column.label === 'Etat'">

                        <div v-for="(status, value, index) in orderStatus" v-bind:value="index">
                            <template v-if="item.status==value">
                                <span class="rounded-pill badge " :class="'bg-'+etatColor[index]"> {{ status  }}</span>
                            </template>
                            
                        </div>
                       
                       
                    </slot>

                    <slot v-if="column.label === 'Action'">
                        <div class="justify-content-end align-items-center d-flex">
                            
                            <template v-if="orderInite==item.status">
                                <a class="btn-default bg-transparent text-primary btn-sm"  :href="'/orders/'+item.id+'/edit'"><span class="material-symbols-outlined">border_color</span></a> 
                                <button class="btn bg-transparent text-primary btn-sm" @click="deleteOrder(item)">
                                    <span class="material-symbols-outlined text-danger">delete</span>
                                </button>
                            </template>
                             <a class="btn-default bg-transparent text-dark btn-sm" title="Modifier" :href="'/orders/'+item.id"><span class="material-symbols-outlined">visibility</span></a>
                            
                       </div>
                    </slot>
                </td>
            </tr>
            </tbody>

        </data-table>
        
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
    name: "OrderDataTable",    
    
    props: {
        orderStatus: {type: Object, required: true},
        url: {type: String, required: true},
        orderInite: {type: Number, required: true},
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
                    label: 'Matiére',
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
                    label: 'Etat',
                    orderable: false,
                },
                {
                    label: 'Commentaire',
                   // name: 'comment',
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
                    class: { 
                        'btn': true,
                        'btn-primary': true,
                        'btn-sm': true,
                    } 
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
            classes: {
                "table-container": {
                    "table-responsive": true,
                }
            },
            tableData: {}, 
            etatColor: ['secondary fw-normal', 'info text-dark fw-normal', 'warning fw-normal', 'danger fw-normal', 'success fw-normal', 'primary fw-normal', 'dark text-white fw-normal'],
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
        deleteOrder(order){
            Swal.fire({
              title: "Etes-vous sûr de vouloir supprimé la <u>commande #"+order.id+"</u>?",
              text: "La suppression est définitive!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oui, supprimé!'
            }).then((result) => {
              if (result.isConfirmed) {


                axios.delete('order/delete/'+order.id)
                .then(response => {
                    if(response.data.code==0){
                         Swal.fire({
                            title: 'Supprimé!',
                            text:   'La commande #'+order.id+' a été supprimé.',
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
                  
                });
        }
    }
   
};
</script>
