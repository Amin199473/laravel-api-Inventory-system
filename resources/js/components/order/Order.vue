<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<br />
				<input
					type="text"
					class="form-control"
					placeholder="search"
					style="width:300px"
					v-model="searchTerm"
				/>
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12 mb-4">
								<!-- Simple Tables -->
								<div class="card">
									<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-primary">Today Order</h6>
									</div>
									<div class="table-responsive">
										<table class="table align-items-center table-flush">
											<thead class="thead-light">
												<tr>
													<th>Name</th>
													<th>Total Amount</th>
													<th>Pay</th>
													<th>Due</th>
													<th>PayBy</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="order in filterSearch" :key="order.id">
													<td>{{ order.customer.name}}</td>
													<td>{{ order.total}}$</td>
													<td>{{ order.pay}}$</td>
													<td>{{ order.due}}$</td>
													<td>{{ order.payby}}</td>
													<td>
														<router-link :to="{name:'orderView' , params:{id:order.id}}" class="btn btn-sm btn-primary mr-2">View</router-link>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!--Row-->
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
export default {
	created() {
		if (!User.loggedIn()) {
			this.$router.push({ name: "/" });
		}
	},
	data() {
		return {
			orders: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.orders.filter((order) => {
				return order.customer.name.match(this.searchTerm);
			});
		},
	},
	methods: {
		allOrder() {
			axios
				.get("/api/orders/")
				.then((response) => {
                    // console.log(response);
					this.orders = response.data;
				})
				.catch((error) => error.response.data);
		},
	},
	created() {
		return this.allOrder();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
