export default {
	SET_USER_LIST: (state, payload) => {
		state.items = payload.users
	},
	SET_CONFIGER_USER: (state, payload) => {
		state.item = payload.user
	},
	SET_DIRECTORY_PERSON_USERS: (state, payload) => {
		state.directory_person_users = payload.users
	},
	SET_DIRECTORY_FIRM_USERS: (state, payload) => {
		state.directory_firm_users = payload.users
	},
	SET_CUSTOMER_USERS: (state, payload) => {
		state.customer_users = payload.users
	},
	SET_COMPANY_USERS: (state, payload) => {
		state.company_users = payload.users
	},
	SET_DIRECTORY_USERS: (state, payload) => {
		state.directory_users = payload.users
	},
	SET_MANAGERS_USERS: (state, payload) => {
		state.managers = payload.users
	},
};
