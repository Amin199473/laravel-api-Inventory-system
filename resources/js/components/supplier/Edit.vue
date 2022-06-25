<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AllSupplier" class="btn btn-primary">All Supplier</router-link>
				</div>
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Edit Supplier</h1>
									</div>
									<form class="user" @submit.prevent="supplierUpdate" enctype="multipart/form-data">
										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<input
														type="text"
														class="form-control"
														placeholder="Enter Full Name"
														v-model="form.name"
													/>
													<small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
												</div>
												<div class="col-md-6">
													<input
														type="email"
														class="form-control"
														placeholder="Enter Email"
														v-model="form.email"
													/>
													<small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<input
														type="text"
														class="form-control"
														placeholder="Enter Address"
														v-model="form.address"
													/>
													<small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
												</div>
												<div class="col-md-6">
													<input
														type="text"
														class="form-control"
														placeholder="Enter Shop Name"
														v-model="form.shopName"
													/>
													<small class="text-danger" v-if="errors.shopName">{{ errors.shopName[0] }}</small>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<input type="text" class="form-control" placeholder="Enter Phone" v-model="form.phone" />
													<small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
												</div>
												<div class="col-md-6"></div>
											</div>
										</div>

										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<input type="file" class="custom-file-input" id="customFile" @change="onFileSelected" />
													<small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
													<label class="custom-file-label" for="customFile">Choose file</label>
												</div>

												<div class="col-md-6" v-if="!form.newPhoto">
													<img :src="form.photo" style="height: 80px; width: 80px;" />
												</div>
                                                <div class="col-md-6" v-else>
													<img :src="form.newPhoto" style="height: 80px; width: 80px;" />
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
				name: "",
				email: "",
				phone: "",
				address: "",
				shopName: "",
				photo: "",
				newPhoto: "",
			},
			errors: {},
		};
	},
	created() {
		let id = this.$route.params.id;
		axios
			.get("/api/supplier/" + id)
			.then((response) => {
				this.form = response.data;
			})
			.catch((error) => {
				console.log(error);
			});
	},
	methods: {
		supplierUpdate() {
			let id = this.$route.params.id;
			axios
				.patch("/api/supplier/" + id, this.form)
				.then((res) => {
					this.$router.push({ name: "AllSupplier" });
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
				this.form.newPhoto = event.target.result;
			};
			reader.readAsDataURL(file);
		},
	},
};
</script>


<style scoped>
</style>
