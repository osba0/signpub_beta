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
                    <div class="col-md-9 d-flex align-items-center justify-content-end d-none">
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
                </td>
            </tr>
            </tbody>

        </data-table>
    </div>
</template>
<script type="text/ecmascript-6">

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
                    label: 'ID',
                    name: 'id',
                    orderable: true,
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
                {
                    label: 'Adresse',
                    name: 'address',
                    orderable: false,
                },
                {
                    label: 'Total commande',
                    name: 'total_cmd',
                    orderable: false,
                },
                {
                    label: 'Status',
                    name: 'is_online',
                    orderable: false,
                },
                {
                    label: 'Date inscription',
                    name: 'created_at',
                    orderable: false,
                }/*,
                {
                    label: 'Action',
                    orderable: false,
                },*/
                
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
