<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AllExpense" class="btn btn-primary">All Expense</router-link>
				</div>
				<div class="card shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="login-form">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Edit Expense</h1>
									</div>
									<form class="user" @submit.prevent="expenseUpdate" enctype="multipart/form-data">
										<div class="form-group">
											<div class="form-row">
												<div class="col-md-12">
													<label for="details"><b>Expense Details</b></label>
													<textarea id="details" class="form-control" rows="3" v-model="form.details"></textarea>
													<small class="text-danger" v-if="errors.details">{{ errors.details[0] }}</small>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-md-12">
													<label for="amount"><b>Expense Amount</b></label>
													<input
														id="amount"
														type="text"
														class="form-control"
														placeholder="Enter Expense Amount"
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
				details: "",
				amount: "",
			},
			errors: {},
		};
	},
	created() {
		let id = this.$route.params.id;
		axios
			.get("/api/expense/" + id)
			.then((response) => {
				this.form = response.data;
			})
			.catch((error) => {
				console.log(error);
			});
	},
	methods: {
		expenseUpdate() {
			let id = this.$route.params.id;
			axios
				.patch("/api/expense/" + id, this.form)
				.then((res) => {
					this.$router.push({ name: "AllExpense" });
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
