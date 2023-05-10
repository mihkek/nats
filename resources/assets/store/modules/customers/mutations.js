export default {
	SET_CUSTOMERS: (state, payload) => {
		state.items = payload.customers
	},
	SET_CUSTOMER: (state, payload) => {
		state.item = payload.customer
		if (state.item.id > 0) {
			state.item.subdivision_id = Number(payload.customer.subdivision_id)
		}
	},
	SET_CUSTOMERS_TYPES: (state, payload) => {
		state.types = payload.types
	},
	SET_SUBSCRIPTION_PRICE: (state, payload) => {
		state.pricelist = payload.pricelist.price
	},
	SET_CUSTOMER_SUBSCRIPTIONS: (state, payload) => {
		state.subscriptions = payload.subscriptions
	},
	SET_CUSTOMERS_GROUPS: (state, payload) => {
		state.groups = payload.groups
	},
	SET_CUSTOMERS_GROUP: (state, payload) => {
		state.group = payload.group
		if (state.group.id > 0) {
			state.group.subdivision_id = Number(state.group.subdivision_id)
		}
	},
	SET_CUSTOMERS_NOTIFICATIONS: (state, payload) => {
		state.notifications = payload.notifications
	},
};
