<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AddProduct" class="btn btn-primary">Add Product</router-link>
				</div>
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
										<h6 class="m-0 font-weight-bold text-primary">Stock</h6>
									</div>
									<div class="table-responsive">
										<table class="table align-items-center table-flush">
											<thead class="thead-light">
												<tr>
													<th>Product Name</th>
													<th>Code</th>
													<th>Image</th>
													<th>Category</th>
													<th>Buying Price</th>
													<th>Status</th>
													<th>Quantity</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="product in filterSearch" :key="product.id">
													<td>{{ product.product_name}}</td>
													<td>{{product.product_code}}</td>
													<td>
														<img :src="product.image" alt id="em_photo" />
													</td>
													<td>{{product.category.name}}</td>
													<td>{{product.buying_price}}</td>
													<td v-if="product.product_quantity>=1">
														<span class="badge badge-success">Available</span>
													</td>
													<td v-else>
														<span class="badge badge-danger">Stock Out</span>
													</td>
													<td>{{product.product_quantity}}</td>
													<td>
														<router-link
															:to="{name:'EditStock' , params:{id:product.id}}"
															class="btn btn-sm btn-primary mr-2"
														>Edit</router-link>
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
			products: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.products.filter((product) => {
				return product.product_name.match(this.searchTerm);
			});
		},
	},
	methods: {
		allProduct() {
			axios
				.get("/api/product/")
				.then((response) => {
					this.products = response.data;
				})
				.catch((error) => error.response.data);
		},
	},
	created() {
		return this.allProduct();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
