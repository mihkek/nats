export default {
	SET_ORDERERS: (state, payload) => {
		state.items = payload.orderers
		state.status_options.map(status => {
			if (status.title == status.text) {
				status.title = '<span class="no_translate">'+status.text+'</span>'
			}
		})
		state.items.map(item => {
			state.status_options.map(status => {
				if (status.id == item.status) {
					item.order_status = status
				}
			})
		})
	},
	SET_ORDERER: (state, payload) => {
		state.item = payload.orderer
		state.item.customer_review_rate = Number(payload.orderer.customer_review_rate)
		state.status_options.map(status => {
			if (status.title == status.text) {
					status.title = '<span class="no_translate">'+status.text+'</span>'
			}
			if (status.id == state.item.status) {
				state.item.orderer_status = status.title
			}
		})
	},
	SET_ORDERER_ADDITIONAL_PLACES: (state, payload) => {
		state.additional_places = payload.orderer_additional_places
	},
	SET_ORDERER_STATUSES: (state, payload) => {
		state.statuses = payload.statuses
	},
};
