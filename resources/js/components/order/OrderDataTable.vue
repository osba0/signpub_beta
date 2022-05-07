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
                            
                                <span class="badge bg-primary"> {{ status  }}</span>
                            </template>
                            
                        </div>
                       
                       
                    </slot>

                    <slot v-if="column.label === 'Action'">
                        <div class="text-end">
                            <template v-if="orderInite==item.status">
                                <a class="btn btn-success btn-sm"  :href="'/orders/'+item.id+'/edit'">Editer</a> 
                            </template>
                            
                            <button class="btn btn-error">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                       </div>
                    </slot>
                </td>
            </tr>
            </tbody>

        </data-table>
    </div>
</template>
<script type="text/ecmascript-6">

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
                    label: 'Réf CMD',
                    name: 'id',
                    orderable: true,
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
                    label: 'Status',
                    orderable: false,
                },
                {
                    label: 'Commentaire',
                    name: 'comment',
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
                length: 25
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
