export default {
	SET_DIRECTORY_FIRMS: (state, payload) => {
		state.items = payload.firms
	},
	SET_DIRECTORY_FIRM: (state, payload) => {
		state.item = payload.firm.firm
		state.item.orderers = payload.firm.orderers
		state.item.city_id = Number(state.item.city_id)
		state.item.type = Number(state.item.type)
		state.item.subdivision_id = Number(state.item.subdivision_id)
	},
	SET_DIRECTORY_FIRM_BUSY_TIMES: (state, payload) => {
		state.busy_times = payload.busy_times
	},
	SET_DIRECTORY_FIRM_BUSY_CALENDAR_TIMES: (state, payload) => {
		state.busy_calendar_times = payload.busy_times
	},
};
