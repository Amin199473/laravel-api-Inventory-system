<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/Employees" class="btn btn-primary">Pay Salary</router-link>
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
										<h6 class="m-0 font-weight-bold text-primary">All Salary Details</h6>
									</div>
									<div class="table-responsive">
										<table class="table align-items-center table-flush">
											<thead class="thead-light">
												<tr>
													<th>Month Name</th>
													<th>Details</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="salary in filterSearch" :key="salary.id">
													<td>{{ salary.salary_month}}</td>
													<td>
														<router-link :to="{name:'ViewSalary' , params:{id:salary.salary_month}}" class="btn btn-sm btn-primary mr-2">View Salary</router-link>
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
				return salary.salary_month.match(this.searchTerm);
			});
		},
	},
	methods: {
		allSalary() {
			axios
				.get("/api/salary/")
				.then((response) => {
					this.salaries = response.data;
				})
				.catch((error) => error.response.data);
		},
	},
	created() {
		return this.allSalary();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
