<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/Stock" class="btn btn-primary">Go Back</router-link>
				</div>
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Edit Stocke</h1>
									</div>
									<form class="user" @submit.prevent="stockUpdate">
										<div class="form-group">
											<div class="form-row">
												<div class="col-md-12">
													<label for="product_quantity">Product Stock</label>
													<input
														id="product_quantity"
														type="text"
														class="form-control"
														placeholder="Enter Product Name"
														v-model="form.product_quantity"
													/>
													<small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
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
				product_quantity: null,
			},
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
	},
	methods: {
		stockUpdate() {
			let id = this.$route.params.id;
			axios
				.post("/api/stock/update/" + id, this.form)
				.then((res) => {
					this.$router.push({ name: "Stock" });
					Notification.success();
				})
				.catch((error) => {
					this.errors = error.response.data.errors;
				});
		}
	},
};
</script>


<style scoped>
</style>
