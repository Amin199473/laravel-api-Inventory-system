<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AddEmployee" class="btn btn-primary">Add Employee</router-link>
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
													<th>Salary</th>
													<th>Joining Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="employee in filterSearch" :key="employee.id">
													<td>{{ employee.name}}</td>
													<td>
														<img :src="employee.photo" alt="" id="em_photo" />
													</td>
													<td>{{employee.phone}}</td>
													<td>{{employee.salary}}</td>
													<td>{{employee.joiningDate}}</td>
													<td>
														<router-link :to="{name:'editEmployee' , params:{id:employee.id}}" class="btn btn-sm btn-primary mr-2">Edit</router-link>
														<a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</a>
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
			employees: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.employees.filter((employee) => {
				return employee.name.match(this.searchTerm);
			});
		},
	},
	methods: {
		allEmployee() {
			axios
				.get("/api/employee/")
				.then((response) => {
					this.employees = response.data;
				})
				.catch((error) => error.response.data);
		},
		deleteEmployee(id) {
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
						.delete("/api/employee/"+id)
						.then(() => {
							this.employees = this.employees.filter((employee) => {
								return employee.id != id;
							});
						})
						.catch(() => {
							this.$router.push({name:'AllEmployee'});
						});
					Swal.fire("Deleted!", "Your Data has been deleted.", "success");
				}
			});
		},
	},
	created() {
		return this.allEmployee();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
