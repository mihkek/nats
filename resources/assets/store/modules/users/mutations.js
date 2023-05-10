export default {
	SET_USER_TODAY_ORDERERS: (state, payload) => {
		state.today_orderers = payload.orderers
	},
	SET_USER_NEXT_ORDERER: (state, payload) => {
		state.next_orderer = payload.orderer
	},
	SET_USER_ACCOUNT_STATEMENT: (state, payload) => {
		state.account_statement = payload.account_statement
	},
};
