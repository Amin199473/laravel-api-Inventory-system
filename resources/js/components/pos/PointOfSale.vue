<template>
	<div class="container-fluid" id="container-wrapper">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">POS</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="./">Home</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
			</ol>
		</div>

		<div class="row mb-3">
			<!-- Area Chart -->
			<div class="col-xl-5 col-lg-5">
				<div class="card mb-4">
					<div
						class="
							card-header
							py-3
							d-flex
							flex-row
							align-items-center
							justify-content-between
						"
					>
						<h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
						<a href="" class="btn btn-info"
							><span style="color: white">Add Customer</span></a
						>
					</div>
					<div class="card">
						<div class="table-responsive" style="font-size: 12px">
							<table class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th>Name</th>
										<th>Qty</th>
										<th>Price</th>
										<th>Total</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="cart in carts" :key="cart.id">
										<td>
											<b>{{ cart.product_name }}</b>
										</td>
										<td id="btn-style">
											<input
												type="text"
												readonly
												:value="cart.product_quantity"
												style="width: 30px; margin-right: 2px"
											/>
											<button
												@click.prevent="increment(cart.id)"
												class="btn btn-sm btn-success ml-1"
											>
												+
											</button>
											<button
												@click.prevent="decrement(cart.id)"
												class="btn btn-sm btn-danger ml-1"
												v-if="cart.product_quantity >= 2"
											>
												-
											</button>
											<button
												class="btn btn-sm btn-danger ml-1"
												disabled
												v-else
											>
												-
											</button>
										</td>
										<td>{{ cart.product_price }}$</td>
										<td>{{ cart.subtotal }}$</td>
										<td>
											<a
												@click="removeItem(cart.id)"
												class="btn btn-sm btn-primary text-white"
												><i class="fa fa-trash" aria-hidden="true"></i
											></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="card-footer">
							<ul class="list-group">
								<li
									class="
										list-group-item
										d-flex
										justify-content-between
										align-item-center
									"
								>
									Total Qty: <strong>{{ totalQty }}</strong>
								</li>
								<li
									class="
										list-group-item
										d-flex
										justify-content-between
										align-item-center
									"
								>
									Sub Total: <strong>{{ subtotal }}$</strong>
								</li>
								<li
									class="
										list-group-item
										d-flex
										justify-content-between
										align-item-center
									"
								>
									Vat: <strong>{{ vats.vat }}%</strong>
								</li>
								<li
									class="
										list-group-item
										d-flex
										justify-content-between
										align-item-center
									"
								>
									Total: <strong>{{ totalAmount }}$</strong>
								</li>
							</ul>
							<br /><br />
							<form @submit.prevent="orderDone">
								<label>Customer Name</label>
								<select class="form-control" v-model="customer_id">
									<option
										v-for="customer in customers"
										:key="customer.id"
										:value="customer.id"
									>
										{{ customer.name }}
									</option>
								</select>

								<label>Pay</label>
								<input
									type="text"
									class="form-control"
									required=""
									v-model="pay"
								/>

								<label>Due</label>
								<input
									type="text"
									class="form-control"
									required=""
									v-model="due"
								/>

								<label>Pay By</label>
								<select class="form-control" v-model="payby">
									<option value="HandCash">Hand Cash</option>
									<option value="Cheaque">Cheaque</option>
									<option value="GiftCard">Gift Card</option>
								</select>

								<br />
								<button type="submit" class="btn btn-success">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- Pie Chart -->
			<div class="col-xl-7 col-lg-7">
				<div class="card mb-4">
					<div
						class="
							card-header
							py-3
							d-flex
							flex-row
							align-items-center
							justify-content-between
						"
					>
						<h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
					</div>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a
								class="nav-link active"
								id="home-tab"
								data-toggle="tab"
								href="#home"
								role="tab"
								aria-controls="home"
								aria-selected="true"
								>All Products</a
							>
						</li>
						<li
							class="nav-item"
							v-for="category in categories"
							:key="category.id"
						>
							<a
								class="nav-link"
								id="profile-tab"
								data-toggle="tab"
								href="#profile"
								role="tab"
								aria-controls="profile"
								aria-selected="false"
								@click="subProduct(category.id)"
								>{{ category.name }}</a
							>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div
							class="tab-pane fade show active"
							id="home"
							role="tabpanel"
							aria-labelledby="home-tab"
						>
							<div class="card-body">
								<div class="row">
									<input
										type="text"
										class="form-control"
										placeholder="search"
										style="width: 560px"
										v-model="searchTerm"
									/>
									<div
										class="col-lg-3 col-md-3 col-sm-6 col-6"
										v-for="product in filterSearch"
										:key="product.id"
									>
										<button
											class="btn btn-sm"
											@click.prevent="addToCart(product.id)"
										>
											<div class="card" style="width: 8.5rem">
												<img
													:src="product.image"
													class="card-img-top"
													id="em_photo"
												/>
												<div class="card-body">
													<h6 class="card-title">
														{{ product.product_name }}
													</h6>
													<span
														class="badge badge-success"
														v-if="product.product_quantity >= 1"
														>Available {{ product.product_quantity }}</span
													>
													<span class="badge badge-danger" v-else
														>Stock Out</span
													>
												</div>
											</div>
										</button>
									</div>
								</div>
							</div>
						</div>
						<div
							class="tab-pane fade"
							id="profile"
							role="tabpanel"
							aria-labelledby="profile-tab"
						>
							<div class="card-body">
								<div class="row">
									<input
										type="text"
										class="form-control"
										placeholder="search"
										style="width: 560px"
										v-model="searchTerm"
									/>
									<div
										class="col-lg-3 col-md-3 col-sm-6 col-6"
										v-for="product in getfilterSearch"
										:key="product.id"
									>
										<button
											class="btn btn-sm"
											@click.prevent="addToCart(product.id)"
										>
											<div class="card" style="width: 8.5rem">
												<img
													:src="product.image"
													class="card-img-top"
													id="em_photo"
												/>
												<div class="card-body">
													<h6 class="card-title">
														{{ product.product_name }}
													</h6>
													<span
														class="badge badge-success"
														v-if="product.product_quantity >= 1"
														>Available {{ product.product_quantity }}</span
													>
													<span class="badge badge-success" v-else
														>Stock Out</span
													>
												</div>
											</div>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Row-->
	</div>
</template>

<script>
export default {
	created() {
		if (!User.loggedIn()) {
			this.$router.push({ name: "/" });
		}
	},
	created() {
		this.allProduct();
		this.allCategory();
		this.allCustomer();
		this.cartProduct();
		this.vat();
	},
	data() {
		return {
			customer_id: "",
			pay: "",
			due: "",
			payby: "",
			products: [],
			categories: [],
			getProducts: [],
			searchTerm: "",
			customers: [],
			errors: "",
			carts: [],
			vats: "",
		};
	},
	computed: {
		filterSearch() {
			return this.products.filter((product) => {
				return product.product_name.match(this.searchTerm);
			});
		},
		getfilterSearch() {
			return this.getProducts.filter((product) => {
				return product.product_name.match(this.searchTerm);
			});
		},
		totalQty() {
			let sum = 0;
			for (let i = 0; i < this.carts.length; i++) {
				sum += parseFloat(this.carts[i].product_quantity);
			}
			return sum;
		},
		subtotal() {
			let sum = 0;
			for (let i = 0; i < this.carts.length; i++) {
				sum += parseFloat(this.carts[i].subtotal);
			}
			return sum;
		},
		totalAmount() {
			let vat = (this.vats.vat / 100) * this.subtotal;
			let total = vat + this.subtotal;
			return total;
		},
	},
	methods: {
		addToCart(id) {
			axios
				.get("/api/addToCart/" + id)
				.then(() => {
					this.cartProduct();
					Notification.cartSuccess();
				})
				.catch((error) => console.log(error));
		},
		removeItem(id) {
			axios
				.get("/api/remove/cart/" + id)
				.then(() => {
					this.cartProduct();
					Notification.cartRemove();
				})
				.catch((error) => console.log(error));
		},
		cartProduct() {
			axios
				.get("/api/cart/products/")
				.then((response) => {
					this.carts = response.data;
				})
				.catch((error) => error.response.data);
		},
		increment(id) {
			axios
				.get("/api/cart/increment/" + id)
				.then(() => {
					this.cartProduct();
					Notification.success();
				})
				.catch((error) => error.response.data);
		},
		decrement(id) {
			axios
				.get("/api/cart/decrement/" + id)
				.then(() => {
					this.cartProduct();
					Notification.success();
				})
				.catch((error) => error.response.data);
		},
		vat() {
			axios
				.get("/api/vats/")
				.then((response) => {
					this.vats = response.data;
				})
				.catch((error) => error.response.data);
		},
		orderDone() {
			let data = {
				qty: this.totalQty,
				subtotal: this.subtotal,
				customer_id: this.customer_id,
				pay: this.pay,
				payby: this.payby,
				due: this.due,
				vat: this.vats.vat,
				total: this.totalAmount,
			};
			axios
				.post("/api/orderDone/", data)
				.then(()=>{
					Notification.success();
					this.$router.push({name: 'home'});
				})
				.catch((error) => {
					console.log(error);
				});
		},
		allProduct() {
			axios
				.get("/api/product/")
				.then((response) => {
					this.products = response.data;
				})
				.catch((error) => error.response.data);
		},
		allCategory() {
			axios
				.get("/api/category/")
				.then((response) => {
					this.categories = response.data;
				})
				.catch((error) => error.response.data);
		},
		allCustomer() {
			axios
				.get("/api/customer/")
				.then((response) => {
					this.customers = response.data;
				})
				.catch((error) => error.response.data);
		},
		subProduct(id) {
			axios
				.get("/api/getting/product/" + id)
				.then((response) => {
					this.getProducts = response.data;
				})
				.catch((error) => error.response.data);
		},
	},
};
</script>

<style scoped>
#em_photo {
	height: 80px;
	width: 130px;
}
#btn-style {
	padding-left: 0rem !important;
	padding-right: 0rem !important;
}
</style>
