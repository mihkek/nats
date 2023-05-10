export default {
	SET_REQUESTERS: (state, payload) => {
		state.items = payload.requesters
		state.status_options.map(status => {
			if (status.title == status.text) {
				status.title = '<span class="no_translate">'+status.text+'</span>'
			}
		})
		state.items.map(item => {
			state.status_options.map(status => {
				if (status.id == item.status) {
					item.requester_status = status
				}
			})
		})
	},
	SET_REQUESTER_REPORT: (state, payload) => {
		state.report = payload.report
	},
	SET_REQUESTER_NOTIFICATIONS: (state, payload) => {
		state.notifications = payload.notifications
	},
	SET_REQUESTER: (state, payload) => {
		state.item = payload.requester
		/*item.customer_full_name = payload.requester.customer.full_name
		item.customer_user_id = payload.requester.customer.user.id
		item.customer_age = payload.requester.customer.age
		item.customer_gender = payload.requester.customer.gender
		item.customer_main_phone = payload.requester.customer.main_phone
		item.customer_main_email = payload.requester.customer.main_email
		item.customer_main_address = payload.requester.customer.main_address
		item.customer_main_city = payload.requester.customer.main_city
		item.customer_main_metro = payload.requester.customer.main_metro
		state.item = item*/
		state.status_options.map(status => {
			if (status.title == status.text) {
					status.title = '<span class="no_translate">'+status.text+'</span>'
			}
			if (status.id == state.item.status) {
				state.item.requester_status = status.title
			}
			let third_test = state.item.third_test.split(',')
			state.item.third_test = []
			third_test.map(val => {
				state.item.third_test.push(Number(val))
			})
		})
	},
};
