<template>
    <div class="orders-view" v-if="order">
    	<div class="row mb-4">
            <div  class="col-md-5">
                <div class="h2 m-0 fw-light">
                     Commande #{{ order.id }} - {{ order.created_at }}
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12">
        		<div class="bg-white p-3 mb-4 border rounded">
        			
        			<ul class="list-unstyled d-flex ul-step mb-0">
		                <li class="rounded px-3 py-2 me-3  border-3 position-relative" :class="order.status > 1 ? 'text-center text-dark border-bottom border-success  bg-light-green' : 'bg-light text-secondary border-bottom fw-light'">
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle text-success" v-if="order.status > 1">check_circle</span>
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle" v-else>radio_button_checked</span>
		                    <label>En Validation</label>
		                     <div class="progress position-absolute progress_status" v-if="order.status == 1">
							  <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
							</div>
		                </li>
		                <li v-if="isdecoupeOrder != 1" class="rounded px-3 py-2 me-3  border-3 position-relative" :class="order.status > 2 ? 'text-center text-dark border-bottom border-success  bg-light-green' : 'bg-light text-secondary border-bottom fw-light'">
		                	<span class="material-symbols-outlined m-0 pe-2 align-middle text-success" v-if="order.status > 2">check_circle</span>
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle" v-else>radio_button_checked</span> En Salle de Tirage
		                    <div class="progress position-absolute progress_status" v-if="order.status == 2">
							  <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
							</div>
		                </li>

		                 <li v-if="isdecoupeOrder==1" class="rounded px-3 py-2 me-3  border-3 position-relative" :class="order.status > 2 && order.status != 21 ? 'text-center text-dark border-bottom border-success  bg-light-green' : 'bg-light text-secondary border-bottom fw-light'">
		                	<span class="material-symbols-outlined m-0 pe-2 align-middle text-success" v-if="order.status > 2 && order.status != 21">check_circle</span>
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle" v-else>radio_button_checked</span> En Salle de Découpe
		                    <div class="progress position-absolute progress_status" v-if="order.status == 21">
							  <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
							</div>
		                </li>
		                <li class="rounded px-3 py-2 me-3 border-3 position-relative"  :class="order.status > 3 && order.status != 21 ? 'text-center text-dark border-bottom border-success  bg-light-green' : 'bg-light text-secondary border-bottom fw-light'">
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle text-success" v-if="order.status > 3 && order.status != 21">check_circle</span>
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle" v-else>radio_button_checked</span>
		                   En Finition
		                    <div class="progress position-absolute progress_status" v-if="order.status == 3">
							  <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
							</div>
		                </li>
		                <li class="rounded px-3 py-2 me-3 border-3 position-relative"  :class="order.status > 4 && order.status != 21? 'text-center text-dark border-bottom border-success  bg-light-green' : 'bg-light text-secondary border-bottom fw-light'">
		                  <span class="material-symbols-outlined m-0 pe-2 align-middle text-success" v-if="order.status > 4 && order.status != 21">check_circle</span>
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle" v-else>radio_button_checked</span>
		                   Prête pour livraison
		                    <div class="progress position-absolute progress_status" v-if="order.status == 4">
							  <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
							</div>
		                </li>
		                <li class="rounded px-3 py-2 me-3 border-3 position-relative" :class="order.status >= 5 && order.status != 21? 'text-center text-dark border-bottom border-success  bg-light-green' : 'bg-light text-secondary border-bottom fw-light'">
		                   <span class="material-symbols-outlined m-0 pe-2 align-middle text-success" v-if="order.status >= 5 && order.status != 21">check_circle</span>
		                    <span class="material-symbols-outlined m-0 pe-2 align-middle" v-else>radio_button_checked</span>
		                   Livré
		                    <!--div class="progress position-absolute progress_status" v-if="order.status == 5">
							  <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
							</div-->
		                </li>
	               
           		 </ul>
        		</div>
        		
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-5">

        		<div class="rounded border bg-white p-3 bottom-30-xs">
        			<h5>Journal</h5>
        			<table class="table table-striped fs-6 mb-0 ">
        				<thead>
	        				<tr><th>Etat</th><!--th>Utilisateur</th--><th>Date</th></tr>
	        			</thead>
	        			<tbody>
	        				<tr v-for="log in orderLogs">
	        					<td>
			                       
			                        <div v-for="(status, index) in statusLog" v-bind:value="index">

			                             <template v-if="log.status==index">
			                            
			                                <span class="badge bg-secondary"> {{ status  }}</span>
			                            </template>
			                            
			                        </div>
			                    </td>
			                    <!--td>
			                        {{ log.user }}
			                    </td-->
			                     <td>
			                        {{ log.date }}
			                    </td>
	        				</tr>
	        			</tbody>
        			</table>
        			
        		</div>
        	</div>
        	<div class="col-md-7">
        		<div class="rounded border bg-white p-3">
        			<table class="table table-striped fs-6 mb-0 ">
        				<tbody>
        				<tr>
        					<th class="py-2 text-secondary">Etat actuel: </th>
        					<td> 
        						<div v-for="(status, index) in orderStatus" v-bind:value="index">
		                            <template v-if="order.status==index">
		                                <span class="text-primary"> {{ status  }}</span>
		                            </template>
		                        </div>
		                    </td>
        				</tr>
        				<tr>
        					<th class="py-1">Matiére: </th>
        					<td class="ps-2">{{ order.type_id }}</td>
        				</tr>
        				<tr>
        					<th class="py-1">Longueur: </th>
        					<td class="ps-2">{{ order.long }} m</td>
        				</tr>
        				<tr>
        					<th class="py-1">Largeur: </th>
        					<td class="ps-2">{{ order.larg }} m</td>
        				</tr>
        				<tr>
        					<th class="py-1">Surface: </th>
        					<td class="ps-2">{{ order.long * order.larg }} m<sup>2</sup></td>
        				</tr>
        				<tr>
        					<th class="py-1">Nombre de copie: </th>
        					<td class="ps-2">{{ order.unit }}</td>
        				</tr>
        				<tr>
        					<th class="py-1">commentaire: </th>
        					<td class="ps-2">{{ order.comment }}</td>
        				</tr></tbody>
        			</table>
        			
        		</div>
        	</div>
        </div>

    </div>
</template>

<script type="text/ecmascript-6">

export default {
    components: {},
    name: "OrderShow",
    props: {
        orderData: {type: Object, required: false, default() {return {}}},
        orderStatus: {type: Object, required: true},
        orderLogs: {type: Array, required: true}, 
        statusLog:  {type: Object, required: true},
        isdecoupeOrder:  {type: Number, required: true},
    },
    data() {
        return {
           order: {},
        }

    },
    methods: {
        
    },
    watch: {
        
    },
    beforeMount() {
       
    },
    mounted() {
       this.order = this.orderData;
    }
}
</script>

