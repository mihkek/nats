export default {
	SET_CONFIGER_SUBDIVISIONS: (state, payload) => {
		state.items = payload.subdivisions
		state.items.map(item => {
			item.title = item.name
			item.value = item.id
		})
	},
	SET_CONFIGER_SUBDIVISION: (state, payload) => {
		state.item = payload.subdivision
	},
};
