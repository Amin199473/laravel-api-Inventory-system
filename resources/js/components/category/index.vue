<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AddCategory" class="btn btn-primary">Add Category</router-link>
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
										<h6 class="m-0 font-weight-bold text-primary">Category List</h6>
									</div>
									<div class="table-responsive">
										<table class="table align-items-center table-flush">
											<thead class="thead-light">
												<tr>
													<th>Name</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="category in filterSearch" :key="category.id">
													<td>{{ category.name}}</td>
													<td>
														<router-link :to="{name:'editCategory' , params:{id:category.id}}" class="btn btn-sm btn-primary mr-2">Edit</router-link>
														<a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">Delete</a>
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
			categories: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.categories.filter((category) => {
				return category.name.match(this.searchTerm);
			});
		},
	},
	methods: {
		allCategory() {
			axios
				.get("/api/category/")
				.then((response) => {
					this.categories = response.data;
				})
				.catch((error) => error.response.data);
		},
		deleteCategory(id) {
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
						.delete("/api/category/"+id)
						.then(() => {
							this.categories = this.categories.filter((category) => {
								return category.id != id;
							});
						})
						.catch(() => {
							this.$router.push({name:'AllCategory'});
						});
					Swal.fire("Deleted!", "Your Data has been deleted.", "success");
				}
			});
		},
	},
	created() {
		return this.allCategory();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
