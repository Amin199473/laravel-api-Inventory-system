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
										<h6 class="m-0 font-weight-bold text-primary">Product List</h6>
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
													<th>Selling Price</th>
													<th>Root</th>
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
                                                    <td>{{product.selling_price}}</td>
                                                    <td>{{product.root}}</td>
													<td>
														<router-link
															:to="{name:'editProduct' , params:{id:product.id}}"
															class="btn btn-sm btn-primary mr-2"
														>Edit</router-link>
														<a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger">Delete</a>
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
		deleteProduct(id) {
			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!",
			}).then((result) => {
				if (result.isConfirmed) {
					axios
						.delete("/api/product/" + id)
						.then(() => {
							this.products = this.products.filter((product) => {
								return product.id != id;
							});
						})
						.catch(() => {
							this.$router.push({ name: "AllProduct" });
						});
					Swal.fire("Deleted!", "Your Data has been deleted.", "success");
				}
			});
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
