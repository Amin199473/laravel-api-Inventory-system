<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div>
					<router-link to="/AddExpense" class="btn btn-primary">Add Expense</router-link>
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
										<h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
									</div>
									<div class="table-responsive">
										<table class="table align-items-center table-flush">
											<thead class="thead-light">
												<tr>
													<th>details</th>
													<th>amount</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="expense in filterSearch" :key="expense.id">
													<td>{{ expense.details}}</td>
													<td>{{ expense.amount}}</td>
													<td>
														<router-link :to="{name:'editExpense' , params:{id:expense.id}}" class="btn btn-sm btn-primary mr-2">Edit</router-link>
														<a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger">Delete</a>
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
			expenses: [],
			searchTerm: "",
		};
	},
	computed: {
		filterSearch() {
			return this.expenses.filter((expense) => {
				return expense.details.match(this.searchTerm);
			});
		},
	},
	methods: {
		allExpense() {
			axios
				.get("/api/expense/")
				.then((response) => {
					this.expenses = response.data;
				})
				.catch((error) => error.response.data);
		},
		deleteExpense(id) {
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
						.delete("/api/expense/"+id)
						.then(() => {
							this.expenses = this.expenses.filter((Expense) => {
								return Expense.id != id;
							});
						})
						.catch(() => {
							this.$router.push({name:'AllExpense'});
						});
					Swal.fire("Deleted!", "Your Data has been deleted.", "success");
				}
			});
		},
	},
	created() {
		return this.allExpense();
	},
};
</script>


<style scoped>
#em_photo {
	height: 60px;
	width: 60px;
}
</style>
