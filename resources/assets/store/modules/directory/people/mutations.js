export default {
	SET_DIRECTORY_PEOPLE: (state, payload) => {
		state.items = payload.people
	},
	SET_DIRECTORY_PERSON: (state, payload) => {
		state.item = payload.person
	},
	SET_DIRECTORY_PERSON_BUSY_TIMES: (state, payload) => {
		state.busy_times = payload.busy_times
	},
	SET_DIRECTORY_PERSON_BUSY_CALENDAR_TIMES: (state, payload) => {
		state.busy_calendar_times = payload.busy_times
	},
};
