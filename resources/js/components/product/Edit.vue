<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AllProduct" class="btn btn-primary">All Product</router-link>
				</div>
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Edit Product</h1>
									</div>
									<form class="user" @submit.prevent="productUpdate" enctype="multipart/form-data">
										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<label for="product_name">Product Name</label>
													<input
														id="product_name"
														type="text"
														class="form-control"
														placeholder="Enter Product Name"
														v-model="form.product_name"
													/>
													<small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
												</div>
												<div class="col-md-6">
													<label for="product_code">Product Code</label>
													<input
														id="product_code"
														type="text"
														class="form-control"
														placeholder="Enter Prodcut Code"
														v-model="form.product_code"
													/>
													<small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<label for="category">Product Category</label>
													<select class="form-control" id="category" v-model="form.category_id">
														<option
															v-for="category in categories"
															:key="category.id"
															:value="category.id"
														>{{category.name}}</option>
													</select>
												</div>
												<div class="col-md-6">
													<label for="supplier">Product Supplier</label>
													<select class="form-control" id="supplier" v-model="form.supplier_id">
														<option
															v-for="supplier in suppliers"
															:key="supplier.id"
															:value="supplier.id"
														>{{supplier.name}}</option>
													</select>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="form-row">
												<div class="col-md-4">
													<label for="root">Product Root</label>
													<input
														id="root"
														type="text"
														class="form-control"
														placeholder="Enter Product root"
														v-model="form.root"
													/>
													<small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>
												</div>
												<div class="col-md-4">
													<label for="buying_price">Buying Price</label>
													<input
														id="buying_price"
														type="text"
														class="form-control"
														placeholder="Enter Buying price"
														v-model="form.buying_price"
													/>
													<small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
												</div>
												<div class="col-md-4">
													<label for="selling_price">Selling price</label>
													<input
														id="selling_price"
														type="text"
														class="form-control"
														placeholder="Enter Selling Price"
														v-model="form.selling_price"
													/>
													<small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<label for="buying_date">Buying Date</label>
													<input
														id="buying_date"
														type="date"
														class="form-control"
														placeholder="Enter Date"
														v-model="form.buying_date"
													/>
													<small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
												</div>
												<div class="col-md-6">
													<label for="product_quantity">Product Quantity</label>
													<input
														id="product_quantity"
														type="text"
														class="form-control"
														placeholder="Enter product Quantity"
														v-model="form.product_quantity"
													/>
													<small
														class="text-danger"
														v-if="errors.product_quantity"
													>{{ errors.product_quantity[0] }}</small>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<input type="file" class="custom-file-input" id="customFile" @change="onFileSelected" />
													<small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
													<label class="custom-file-label" for="customFile">Choose Image</label>
												</div>

												<div class="col-md-6">
													<img :src="form.image" style="height: 80px; width: 80px;" v-if="!form.newImage"/>
													<img :src="form.newImage" style="height: 80px; width: 80px;" v-else />
												</div>
											</div>
										</div>

										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block">Update</button>
										</div>
									</form>
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
			form: {
				product_name: null,
				product_code: null,
				category_id: null,
				supplier_id: null,
				root: null,
				selling_price: null,
				buying_price: null,
				buying_date: null,
				image: null,
				newImage: null,
				product_quantity: null,
			},
			categories: [],
			suppliers: [],
			errors: {},
		};
	},
	created() {
		let id = this.$route.params.id;
		axios
			.get("/api/product/" + id)
			.then((response) => {
				this.form = response.data;
			})
			.catch((error) => {
				console.log(error);
			});


		axios.get("/api/category").then((res) => {
			this.categories = res.data;
		});

		axios.get("/api/supplier").then((res) => {
			this.suppliers = res.data;
		});
	},
	methods: {
		productUpdate() {
			let id = this.$route.params.id;
			axios
				.patch("/api/product/" + id, this.form)
				.then((res) => {
					this.$router.push({ name: "AllProduct" });
					Notification.success();
				})
				.catch((error) => {
					this.errors = error.response.data.errors;
				});
		},
		onFileSelected(event) {
			let file = event.target.files[0];
			if (file.size > 1048770) {
				return Notification.image_validation();
			}

			let reader = new FileReader();
			reader.onload = (event) => {
				this.form.newImage = event.target.result;
			};
			reader.readAsDataURL(file);
		},
	},
};
</script>


<style scoped>
</style>
