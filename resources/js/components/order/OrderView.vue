<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/order" class="btn btn-primary">Go Back</router-link>
				</div>
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Order Detail</h1>
									</div>
									<div class="row">
										<div class="col-lg-6 mb-4">
											<div class="card">
												<div
													class="
														card-header
														py-3
														d-flex
														flex-row
														align-items-center
														justify-content-between
													"
												>
													<h6 class="m-0 font-weight-bold text-primary">
														Order Detail
													</h6>
												</div>
												<div class="table-responsive">
													<ul class="list-group">
														<li class="list-group-item">
															<b>Name:</b> {{ order.customer.name }}
														</li>
														<li class="list-group-item">
															<b>Phone:</b> {{ order.customer.phone }}
														</li>
														<li class="list-group-item">
															<b>Address:</b> {{ order.customer.address }}
														</li>
														<li class="list-group-item">
															<b>Date:</b> {{ order.order_date }}
														</li>
														<li class="list-group-item">
															<b>Pay Through:</b> {{ order.payby }}
														</li>
													</ul>
												</div>
												<div class="card-footer"></div>
											</div>
										</div>
										<div class="col-lg-6 mb-4">
											<div class="card">
												<div
													class="
														card-header
														py-3
														d-flex
														flex-row
														align-items-center
														justify-content-between
													"
												>
													<h6 class="m-0 font-weight-bold text-primary">
														Order Details
													</h6>
												</div>
												<div class="table-responsive">
													<ul class="list-group">
														<li class="list-group-item">
															<b>Sub Total:</b> {{ order.subtotal }}$
														</li>
														<li class="list-group-item">
															<b>Vat:</b> {{ order.vat }}%
														</li>
														<li class="list-group-item">
															<b>Total:</b> {{ order.total }}$
														</li>
														<li class="list-group-item">
															<b>Pay Amount:</b> {{ order.pay }}$
														</li>
														<li class="list-group-item">
															<b>Due Amount:</b> {{ order.due }}$
														</li>
													</ul>
												</div>
												<div class="card-footer"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 mb-4">
											<!-- Simple Tables -->
											<div class="card">
												<div
													class="
														card-header
														py-3
														d-flex
														flex-row
														align-items-center
														justify-content-between
													"
												>
													<h6 class="m-0 font-weight-bold text-primary">
														Order Details
													</h6>
												</div>
												<div class="table-responsive">
													<table class="table align-items-center table-flush">
														<thead class="thead-light">
															<tr>
																<th>Product Name</th>
																<th>Product Code</th>
																<th>Image</th>
																<th>Qty</th>
																<th>Price</th>
																<th>SubTotal</th>
															</tr>
														</thead>
														<tbody>
															<tr v-for="detail in details" :key="detail.id">
																<td>{{ detail.product.product_name }}</td>
																<td>{{ detail.product.product_code }}</td>
																<td>
                                                                    <img :src="detail.product.image" style="width:50px;heigh:50px">
                                                                </td>
																<td>{{ detail.product_quantity }}</td>
																<td>{{ detail.product_price }}$</td>
																<td>{{ detail.subtotal }}$</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="card-footer"></div>
											</div>
										</div>
									</div>
									<hr />
									<div class="text-center"></div>
								</div>
							</div>
						</div>
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
			order: [],
			details: [],
		};
	},
	created() {
		let id = this.$route.params.id;
		axios
			.get("/api/order/" + id)
			.then((response) => {
				this.order = response.data;
			})
			.catch((error) => {
				console.log(error);
			});

		axios
			.get("/api/order/details/" + id)
			.then((response) => {
				this.details = response.data;
			})
			.catch((error) => {
				console.log(error);
			});
	},
	methods: {},
};
</script>


<style scoped>
</style>
