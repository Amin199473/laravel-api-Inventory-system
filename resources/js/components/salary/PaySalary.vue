<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/Employees" class="btn btn-primary">Pay Salary</router-link>
				</div>
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Pay Salary</h1>
									</div>
									<form class="user" @submit.prevent="salaryPaid">
										<div class="form-group">
											<div class="form-row">
												<div class="col-md-6">
													<label for="category">
														<b>Name</b>
													</label>
													<input
														type="text"
														class="form-control"
														placeholder="Enter Full Name"
														v-model="form.name"
													/>
													<small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
												</div>
												<div class="col-md-6">
													<label for="category">
														<b>Email</b>
													</label>
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
													<label for="category">
														<b>Months</b>
													</label>
													<select class="form-control" id="salary_month" v-model="form.salary_month">
														<option value="January">January</option>
														<option value="February">February</option>
														<option value="March">March</option>
														<option value="April">April</option>
														<option value="May">May</option>
														<option value="June">June</option>
														<option value="July">July</option>
														<option value="August">August</option>
														<option value="September">September</option>
														<option value="October">October</option>
														<option value="November">November</option>
														<option value="December">December</option>
													</select>
													<small class="text-danger" v-if="errors.salary_month">{{ errors.salary_month[0] }}</small>
												</div>
												<div class="col-md-6">
													<label for="category">
														<b>Amount</b>
													</label>
													<input
														type="text"
														class="form-control"
														placeholder="Enter Amount"
														v-model="form.amount"
													/>
													<small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
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
				salary_month: "",
				amount: "",
			},
			errors: {},
		};
	},
	created() {
		let id = this.$route.params.id;
		axios
			.get("/api/employee/" + id)
			.then((response) => {
				this.form = response.data;
			})
			.catch((error) => {
				console.log(error);
			});
	},
	methods: {
		salaryPaid() {
			let id = this.$route.params.id;
			axios
				.post("/api/salary/paid/" + id, this.form)
				.then((res) => {
					if (res.data == "salary Already Paid") {
						this.$router.push({ name: "PaySalary", params: { id: id } });
						return Notification.SalaryExist();
					}
					this.$router.push({ name: "Employees" });
					Notification.success();
				})
				.catch((error) => {
					this.errors = error.response.data.errors;
				});
		},
	},
};
</script>


<style scoped>
</style>
