/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



import VueAxios from 'vue-axios'
import VueCookies from 'vue-cookies';
import vSelect from 'vue-select'

Vue.use(VueAxios, axios)
Vue.use(VueCookies);
Vue.mixin({
    methods: {
        __: function (key) {
            if (Lang.get(key) != key) {
                return Lang.get(key)
            } else {
                //return 'Нет перевода'
                return `<span class="no_translate" data-expression="${key}" onclick="if (window.instantTranslate) { window.event.stopPropagation(); return window.instantTranslate(this); }">${key}</span>`;
            }
        }
    }
})


import store from './store'


//import '@mdi/font/css/materialdesignicons.css'
import './assets/app.scss'
import 'vue-select/dist/vue-select.css';

/*window.Vue = require('vue')*/

//const Vuetify = require("vuetify")
import vuetify from './plugins/vuetify'

import axios from 'axios'
window.axios = axios;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
((tokenTag) => {
    if (tokenTag) {
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${tokenTag.getAttribute('content')}`;
    }
})(document.querySelector('meta[name="api_token"]'));










/*import indexPage from './components/index/indexPage'*/
import index_tenders from './components/index/tenders'
import index_auctions from './components/index/auctions'
import index_sales from './components/index/sales'

/*
import page_tender from './components/page/tender'
import page_auction from './components/page/auction'
import page_sale from './components/page/sale'
*/

/*import index_about_service from './components/index/about_service'
import index_services from './components/index/services'*/

import registration from './components/auth/registration'

import block_supliers from './components/subliers/index'
import block_supliers_detail from './components/subliers/detail'

import tenders_block from './components/index/components/tenders_block'
import sales_block from './components/index/components/sales_block'

import reviews_block from './components/index/components/reviews_block'
import slider_block from './components/index/components/slider_block'
import counters_block from './components/index/components/counters_block'


import tender_list from './components/tender/list' // components/auction/list
import tender_card from './components/tender/card' // components/auction/card
import new_tender_card from './components/tender/new_card' // components/auction/new_card
import history_tender_list from './components/tender/history' // components/auction/history
import user_tender_list from './components/tender/userlist' // components/auction/history

//040423
import tenderdv_list from './components/tenderdv/list'
import tenderdv_card from './components/tenderdv/card'
import new_tenderdv_card from './components/tenderdv/new_card' 





import auction_list from './components/auction/list'
import auction_card from './components/auction/card'
import new_auction_card from './components/auction/new_card'

import sale_list from './components/sale/list'
import sale_card from './components/sale/card'
import new_sale_card from './components/sale/new_card'

import directory_firms_list from './components/directory/firms/directory_firms_list'
import directory_firm_card from './components/directory/firms/directory_firm_card'
import directory_people_list from './components/directory/people/directory_people_list'
import directory_person_card from './components/directory/people/directory_person_card'
import customers_list from './components/customers/customers_list'
import customers_groups from './components/customers/customers_groups'
import customers_group from './components/customers/customers_group'
import customer_card from './components/customers/customer_card'
import orderer_list from './components/orderers/orderer_list'
import orderer_card from './components/orderers/orderer_card'
import orderer_calendar from './components/orderers/orderer_calendar'
import billing_pay from './components/billing/billing_pay'
import billing_history from './components/billing/billing_history'
import subscriptions from './components/billing/subscriptions'
import billing_create from './components/billing/billing_create'
import billing_create_payout from './components/billing/billing_create_payout'


import requester_list from './components/requester/requester_list'
import requester_card from './components/requester/requester_card'
import requester_report from './components/requester/requester_report'

import ChangeLogger from './components/snippets/ChangeLogger';
import lessonscalendar from './components/orderers/Calendar';
import activities from './components/orderers/Activities';

import dashboard from './components/dashboard/dashboard';
import customer_dashboard from './components/dashboard/customer_dashboard';
import directory_person_dashboard from './components/dashboard/directory_person_dashboard';
import directory_firm_dashboard from './components/dashboard/directory_firm_dashboard';
import admin_dashboard from './components/dashboard/admin_dashboard';

import personal_settings from './components/settings/personal_settings';
import personal_review from './components/reviews/personal_review';

import roles_list from './components/configer/roles_list';
import drugs_list from './components/configer/drugs_list';
import users_list from './components/configer/users_list';
import user_card from './components/configer/user_card';
import subdivisions_list from './components/configer/subdivisions_list';
import subdivision_card from './components/configer/subdivision_card';

import configer_sms from './components/configer/sms';

import afillater from './components/afillater/afillater';

import faq from './components/support/faq';
import news from './components/news/news_list';
import news_list_index from './components/index/news_list';
import news_detail_index from './components/index/news_detail';
import support_service from './components/support/service';
import support_learning from './components/support/learning';
import MirronixFieldAccess from './vendor/mirronix/fieldaccess';

import no_access from './components/no_access'

import promoter_go from './components/promoter/go'
import promoter_form from './components/promoter/form'
import promoter_list from './components/promoter/list'
import promoter_card from './components/promoter/card'

import promoters_report from './components/reports/promoters'
import operators_report from './components/reports/operators'
import managers_report from './components/reports/managers'
import lids_report from './components/reports/lids'
import global_report from './components/reports/global'

import messages_list from './components/messages/list'
import messages from './components/messages/messages'

import api_test from './components/test/api_test'




// Vue.component('field-access-random', FieldAccessRandom);

const ignoreWarnMessage = 'The .native modifier for v-on is only valid on components but it was used on <div>.';
Vue.config.warnHandler = function (msg, vm, trace) {
    // `trace` is the component hierarchy trace
    if (msg === ignoreWarnMessage) {
        msg = null;
        vm = null;
        trace = null;
    }
}

Vue.component('vue-select', vSelect)

new Vue({
    vuetify,
    store,
    components: {

        /*indexPage,*/

        index_tenders,
        index_auctions,
        index_sales,

        /*page_tender,
        page_auction,
        page_sale,*/
        
        /*index_about_service,
        index_services,*/
        registration,
        tender_list,
        tender_card,
        new_tender_card,
        history_tender_list,
        user_tender_list,

        //040423
        tenderdv_list,
        tenderdv_card,
        new_tenderdv_card,

        
        auction_list,
        auction_card,
        new_auction_card,

        sale_list,
        sale_card,
        new_sale_card,

        tenders_block,
        sales_block,

        reviews_block,
        slider_block,
        counters_block,

        directory_firms_list,
        directory_firm_card,
        directory_people_list,
        directory_person_card,
        customers_list,
        customers_groups,
        customers_group,
        customer_card,
        orderer_list,
        orderer_card,
        orderer_calendar,
        requester_list,
        requester_card,
        requester_report,
        billing_history,
        billing_create,
        billing_pay,
        billing_create_payout,
        subscriptions,
        ChangeLogger,
        lessonscalendar,
        activities,
        subdivisions_list,
        subdivision_card,
        customer_dashboard,
        directory_person_dashboard,
        directory_firm_dashboard,
        admin_dashboard,
        dashboard,
        personal_settings,
        personal_review,
        block_supliers,
        block_supliers_detail,
        roles_list,
        drugs_list,
        users_list,
        user_card,

        afillater,

        no_access,

        faq,
        news,
        news_list_index,
        news_detail_index,
        support_learning,
        support_service,

        promoter_go,
        promoter_form,
        promoter_list,
        promoter_card,

        promoters_report,
        operators_report,
        managers_report,
        lids_report,
        global_report,

        configer_sms,


        messages_list,
        messages,
        
        api_test,


    }
}).$mount('#app')
