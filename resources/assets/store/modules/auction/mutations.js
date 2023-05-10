export default {
	SET_AUCTIONS: (state, payload) => {
		state.auctions = payload.auctions
	},
	SET_TENDERS: (state, payload) => {
		state.tenders = payload.auctions
	},
	SET_SALES: (state, payload) => {
		state.sales = payload.auctions
	},	
	SET_AUCTION: (state, payload) => {
		state.item = payload.auction
	},
	SET_RATES: (state, payload) => {
		state.rates = payload.rates
	},
};
