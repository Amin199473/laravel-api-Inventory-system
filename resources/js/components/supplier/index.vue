<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="AddSupplier" class="btn btn-primary">Add Supplier</router-link>
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
													<th>Photo</th>
													<th>Phone</th>
													<th>Shop Name</th>
													<th>Address</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="supplier in filterSearch" :key="supplier.id">
													<td>{{ supplier.name}}</td>
													<td>
														<img :src="supplier.photo" alt="" id="em_photo" />
													</td>
													<td>{{supplier.phone}}</td>
													<td>{{supplier.shopName}}</td>
													<td>{{supplier.address}}</td>
													<td>
														<router-link :to="{name:'editSupplier' , params:{id:supplier.id}}" class="btn btn-sm btn-primary mr-2">Edit</router-link>
														<a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger">Delete</a>
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
			suppliers: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.suppliers.filter((supplier) => {
				return supplier.name.match(this.searchTerm);
			});
		},
	},
	methods: {
		allSupplier() {
			axios
				.get("/api/supplier/")
				.then((response) => {
					this.suppliers = response.data;
				})
				.catch((error) => error.response.data);
		},
		deleteSupplier(id) {
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
						.delete("/api/supplier/"+id)
						.then(() => {
							this.suppliers = this.suppliers.filter((supplier) => {
								return supplier.id != id;
							});
						})
						.catch(() => {
							this.$router.push({name:'AllSupplier'});
						});
					Swal.fire("Deleted!", "Your Data has been deleted.", "success");
				}
			});
		},
	},
	created() {
		return this.allSupplier();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
