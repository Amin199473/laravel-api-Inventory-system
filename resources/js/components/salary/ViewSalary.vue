<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AllSalary" class="btn btn-primary">Go Back</router-link>
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
										<h6 class="m-0 font-weight-bold text-primary">Employee Salary Details</h6>
									</div>
									<div class="table-responsive">
										<table class="table align-items-center table-flush">
											<thead class="thead-light">
												<tr>
													<th>Name</th>
													<th>Month</th>
													<th>Amount</th>
													<th>Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="salary in filterSearch" :key="salary.id">
													<td>{{ salary.employee.name }}</td>
													<td>{{ salary.salary_month }}</td>
													<td>{{ salary.amount }}</td>
													<td>{{ salary.salary_date }}</td>
													<td>
														<router-link
															:to="{name:'EditSalary' , params:{id:salary.id}}"
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
			salaries: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.salaries.filter((salary) => {
				return salary.employee.name.match(this.searchTerm);
			});
		},
	},
	methods: {
		viewSalary() {
			let id = this.$route.params.id;
			axios
				.get("/api/salary/view/" + id)
				.then((res) => {
					this.salaries = res.data;
				})
				.catch((error) => {
					this.errors = error.response.data.errors;
				});
		},
	},
	created() {
		return this.viewSalary();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
