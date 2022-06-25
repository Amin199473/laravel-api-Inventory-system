<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AddCustomer" class="btn btn-primary">Add Customer</router-link>
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
										<h6 class="m-0 font-weight-bold text-primary">Simple Tables</h6>
									</div>
									<div class="table-responsive">
										<table class="table align-items-center table-flush">
											<thead class="thead-light">
												<tr>
													<th>Name</th>
													<th>Email</th>
													<th>Photo</th>
													<th>Phone</th>
													<th>address</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="customer in filterSearch" :key="customer.id">
													<td>{{ customer.name}}</td>
													<td>{{ customer.email}}</td>
													<td>
														<img :src="customer.photo" alt="" id="em_photo" />
													</td>
													<td>{{customer.phone}}</td>
													<td>{{customer.address}}</td>
													<td>
														<router-link :to="{name:'editCustomer' , params:{id:customer.id}}" class="btn btn-sm btn-primary mr-2">Edit</router-link>
														<a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger">Delete</a>
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
			customers: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.customers.filter((customer) => {
				return customer.name.match(this.searchTerm);
			});
		},
	},
	methods: {
		allCustomer() {
			axios
				.get("/api/customer/")
				.then((response) => {
					this.customers = response.data;
				})
				.catch((error) => error.response.data);
		},
		deleteCustomer(id) {
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
						.delete("/api/customer/"+id)
						.then(() => {
							this.customers = this.customers.filter((customer) => {
								return customer.id != id;
							});
						})
						.catch(() => {
							this.$router.push({name:'AllCustomer'});
						});
					Swal.fire("Deleted!", "Your Data has been deleted.", "success");
				}
			});
		},
	},
	created() {
		return this.allCustomer();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
