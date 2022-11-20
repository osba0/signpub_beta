 <template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="text-warning border-bottom border-warning border-2 mb-4">Surface / Tireur</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="bg-white border p-3 rounded">
                    <div class="d-flex justify-content-between filtreTireur">
                        <div>
                            <label>Date début</label>
                            <datepicker  requiert v-model="surface.dateDebut" format='dd/MM/yyyy' :format="customFormatter" placeholder="jj/mm/aaaa"></datepicker>
                        </div>
                        <div class="px-3">
                            <label>Date Fin</label>
                            <datepicker v-model="surface.dateFin" format='dd/MM/yyyy' :format="customFormatterDateFin" placeholder="jj/mm/aaaa"></datepicker>
                        </div>
                        <div> 
                            <label>Liste des Tireurs</label>
                            <select
                            id="tireur"
                            v-model="surface.tireur"
                            type="text"
                            name="tireur"
                            class="form-select px-2 w-100 border-0 shadow-none"
                            >
                            <option value=''>Tous</option>
                            <option :value='tireur.id' v-for="tireur in listTireurs">
                                {{ tireur.name }}
                            </option> 
                        </select>
                        </div>
                    </div>
                     <div class="text-center border-top mt-3">
                       <button @click="search()" class="btn btn-success mt-2 "> <span v-if="isloading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Afficher</button>
                    </div>
                </div>  
            </div>
          
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-7">
                <table class="border table table-striped">
                    <thead><tr><td>Tireur</td><td>Total Tirage</td><td>Surface Totale</td></tr></thead>
                    <tbody>
                        <tr v-for="result in tableData">
                            <td>{{result.user}}</td>
                            <td>{{result.total_unite}}</td>
                            <td>{{result.total_surface}} m<sup>2</sup></td>
                        </tr>
                         <tr v-if="tableData.length == 0">
                            <td colspan="3">Aucun résultat</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
     
    </div>
</template>

<script type="text/ecmascript-6">
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';

const Swal = require('sweetalert2');
export default { 
    name: "StatistiqueSurfaceTireur",    
    components: {
        Datepicker
      },
    props: {
        //url: {type: String, required: true},
        urlBack: {type: String, required: true},
        listTireurs: {type: Array, required: true},
        idTireurs: {type: Array, required: true}
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
            tableData: [],

            surface: {
                dateDebut: new Date(new Date().setDate(new Date().getDate()-1)),
                dateFin:  new Date() ,
                tireur: ''
            },
            isloading: false,
            
        };
    },
    methods: {
         customFormatter(date) {
          this.surface.dateDebut = moment(date).format('YYYY-MM-DD 00:00:00');
          return moment(date).format('YYYY-MM-DD');
        },
        customFormatterDateFin(date){
            this.surface.dateFin = moment(date).format('YYYY-MM-DD 23:59:59');
            return moment(date).format('YYYY-MM-DD');
        },
        search(){
            this.isloading=true;
            axios.post('statistique/search', {"filtre": this.surface, "allTireurs": this.idTireurs})
            .then(response => {
                var self=this;
                setTimeout(function(){
                   self.isloading=false;   
                },500);
              
                if(response.data.code==0){
                  this.tableData = response.data.result;
                  console.log(this.tableData );

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
