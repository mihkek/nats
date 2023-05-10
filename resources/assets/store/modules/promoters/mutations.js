export default {
	SET_PROMOTER: (state, payload) => {
		state.item = payload.promoter
		state.item.scripts_rate = Number(state.item.scripts_rate)
	},
	SET_PROMOTERS: (state, payload) => {
		state.items = payload.promoters
	},
	SET_PROMOTER_USERS: (state, payload) => {
		state.users = payload.users
	},
};
