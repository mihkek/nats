<template>
  <v-card flat color="#fff" tile>
    <v-container fluid grid-list-xl>
      <v-layout row wrap>
        <v-flex xs12>
          <v-toolbar color="transparent" flat dense height="38px">
            <v-toolbar-items>
              <v-text-field
                hide-details
                solo
                flat
                prepend-icon="mdi-magnify"
                dense
                v-model="search"
              >
                <template v-slot:label>
                  <span v-html="__('forms.search_label')"></span>
                </template>
              </v-text-field>
            </v-toolbar-items>
          </v-toolbar>
          <v-card outlined class="rounded-card mt-1">
            <v-data-table
              :items="item.orderers"
              :headers="headers"
              :search="search"
              color="transparent"
              :items-per-page="10"
              :locale="$vuetify.lang.current"
              class="rounded-card"
              :sort-by="['date_time']"
              :sort-desc="['DESC']"
              :mobile-breakpoint="100"
              :expanded.sync="expanded"
            >
             <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length" class="px-0">
                  <v-list color="#fafafa">
                    <v-list-item v-if="item.customer != null">
                      <v-list-item-avatar >
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.customer.avatar != null" :src="'/storage/avatars/50x50.'+item.customer.avatar" alt=""></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-subtitle v-html="__('orderer.customer')"></v-list-item-subtitle>
                        <v-list-item-title>
                          <v-tooltip top>
                            <template v-slot:activator="{on}">
                              <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/customer/list/card/'+item.customer_id">{{item.customer.full_name || ''}}</a>
                            </template>
                            <span class="caption" v-html="__('buttons.customer_tooltip')"></span>
                          </v-tooltip>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="my-0"></v-divider>
                    <v-list-item v-if="item.directory_firm != null">
                      <v-list-item-avatar >
                        <v-avatar size="40" color="transparent" class="avatar">
                          <v-img v-if="item.directory_firm.avatar != null" :src="'/storage/avatars/50x50.'+item.directory_firm.avatar" alt="" ></v-img>
                          <v-img v-else src="/storage/avatars/50x50.nophoto.png" alt=""></v-img>
                        </v-avatar>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-subtitle v-html="__('orderer.directory_person')"></v-list-item-subtitle>
                        <v-list-item-title>
                          <v-tooltip top>
                            <template v-slot:activator="{on}">
                              <a class="font-weight-medium primary--text" v-on="on" :href="'/admin/directory/people/'+item.directory_person.id">{{item.directory_person.full_name || ''}}</a>
                            </template>
                            <span class="caption" v-html="__('buttons.directory_person_tooltip')"></span>
                          </v-tooltip>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="my-0"></v-divider>
                    <v-list-item>
                        <v-list-item-subtitle v-html="__('orderer.customer_review_rate')"></v-list-item-subtitle>
                      <v-rating  dense size="14" readonly :value="Number(item.customer_review_rate)"></v-rating>
                    </v-list-item>
                  </v-list>
                </td>
            </template>
            <template v-slot:item="{ item }">
              <tr class="table-row" @click.stop="goTo('/admin/orderer/now/card/'+item.id)">
                 <td class="d-table-cell d-md-none px-0 py-0 text-center">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
                    </v-tooltip>
                  </td>
                <td>
                  <v-list-item-title class="caption">
                    {{formatDate(item.date)}} {{item.time}}
                  </v-list-item-title>
                </td>
                <td class="white--text" >
                    <v-chip :color="item.order_status.color_calendar" style="border-radius: 16px !important;"><span class="white--text" v-html="item.order_status.title"></span></v-chip>
                  </td>
                <td class="ava d-none d-md-table-cell">
                  <v-list-item dense class="px-0" v-if="item.customer != null">
                    <v-list-item-avatar>
                      <v-avatar size="50" color="transparent">
                        <img v-if="item.customer.avatar != null" :src="'/storage/avatars/50x50.'+item.customer.avatar" alt="">
                        <img v-else src="/storage/avatars/50x50.nophoto.png" alt="">
                      </v-avatar>
                    </v-list-item-avatar>
                    <v-list-item-content><a class="font-weight-medium" :href="'/admin/customer/list/card/'+item.customer.id">{{item.customer.full_name || ''}}</a></v-list-item-content>
                  </v-list-item>
                </td>
                <td class="ava d-none d-md-table-cell">
                  <v-list-item dense class="px-0" v-if="item.directory_person != null">
                    <v-list-item-avatar>
                      <v-avatar size="50" color="transparent">
                        <img  v-if="item.directory_person.avatar != null" :src="'/storage/avatars/50x50.'+item.directory_person.avatar" alt="">
                        <img v-else src="/storage/avatars/50x50.nophoto.png" alt="">
                      </v-avatar>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <a class="font-weight-medium" :href="'/admin/directory/people/'+item.directory_person.id">{{item.directory_person.full_name || ''}}</a>
                    </v-list-item-content>
                  </v-list-item>
                </td>
                <td class="d-none d-md-table-cell"><v-rating dense size="14" readonly :value="Number(item.customer_review_rate)" color="white"></v-rating></td>
              </tr>
            </template>
            </v-data-table>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-card>
</template>

<script>
export default {
  props: {
    item: Object,
  },
  data: () => ({
    headers: [
      { text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, widh: 30, align: 'center' },
      { text: __('orderer.date'), value: 'date_time' },
      { text: __('orderer.status'), value: 'status' },
      { text: __('orderer.customer'), value: 'customer.full_name', class: 'd-none d-md-table-cell' },
      { text: __('orderer.directory_person'), value: 'directory_person.full_name', class: 'd-none d-md-table-cell' },
      { text: __('orderer.customer_review_rate'), value: 'customer_review_rate', class: 'd-none d-md-table-cell'  },
    ],
    search: null,
    expanded: [],
  }),
  methods: {
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    goTo(val) {
      location.href = val;
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
    formatPrice(value) { 
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '0.00' }
    },
  },
  computed: {

  }
};
</script>
