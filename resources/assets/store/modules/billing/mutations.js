export default {
	SET_BILLING_HISTORY: (state, payload) => {
		state.history = payload.history
		state.total = payload.total
	},
	SET_SUBSCRIPTION_HISTORY: (state, payload) => {
		state.subscriptions_history = payload.history
	},
};
