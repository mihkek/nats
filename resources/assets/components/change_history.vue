<template>
  <v-card flat >
    <v-container fluid class="px-0 py-0">
      <v-layout row wrap>
        <v-flex xs12>
          <v-card flat>
             <v-data-table
               :items="changes"
               :headers="headers"
               locale="ru"
               color="transparent"
               dense
               class="caption"
               :mobile-breakpoint="100"
               :sort-by="['created']"
               :sort-desc="['desc']"
              :expanded.sync="expanded"
             >

              <template v-slot:header.createdVerbal="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.user.id="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.fields[0].name="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.fields[0].old="{ header }"><span v-html="header.text"></span></template>
              <template v-slot:header.fields[0].new="{ header }"><span v-html="header.text"></span></template>

              <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length" class="px-0">
                  <v-list color="#fff" dense two-line subheader>
                    <v-list-item>
                      <v-list-item-icon class="mr-2"><v-icon color="primary" small>mdi-account</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.user.id}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('changehistory.user')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-icon class="mr-2"><v-icon color="primary" small>mdi-circle-outline</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.fields[0].old}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('changehistory.old')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-icon class="mr-2"><v-icon color="primary" small>mdi-circle-slice-8</v-icon></v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>{{item.fields[0].new}}</v-list-item-title>
                        <v-list-item-subtitle v-html="__('changehistory.new')"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="my-0"></v-divider>
                  </v-list>
                </td>
              </template>
              <template v-slot:item="{ item }">
                <tr class="no-hover" v-if="item.fields[0].name != 'password' && item.fields[0].name != 'remember_token'">
                  <td class="d-table-cell d-md-none px-0 py-0 text-center">
                    <v-tooltip top>
                      <template v-slot:activator="{ on }">
                        <v-btn color="black" x-small @click.stop="expand(item)" icon v-on="on"><v-icon>{{expanded.indexOf(item) == -1 ? 'mdi-chevron-down' : 'mdi-chevron-up'}}</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.expand_tooltip')"></span>
                    </v-tooltip>
                  </td>
                  <td class="caption">{{formatDate(item.created, 'withTime')}}</td>
                  <td class="caption d-none d-md-table-cell">{{item.user.id}}</td>
                  <td class="caption">{{item.fields[0].name}}</td>
                  <td class="caption d-none d-md-table-cell">{{item.fields[0].old}}</td>
                  <td class="caption d-none d-md-table-cell">{{item.fields[0].new}}</td>
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
    model: String,
  },
  data: () => ({
    changes: [],
    headers: [
      { id: 0, text: '', value: 'expanded', class: 'd-table-cell d-md-none', sortable: false, width: 40, align: 'center'  },
      { id: 5, text: __('changehistory.date'), title: 'changehistory.date', value: 'createdVerbal' },
      { id: 1, text: __('changehistory.user'), title: 'changehistory.user', value: 'user.id', class: 'd-none d-md-table-cell' },
      { id: 2, text: __('changehistory.field'), title: 'changehistory.field', value: 'fields[0].name' },
      { id: 3, text: __('changehistory.old'), title: 'changehistory.old', value: 'fields[0].old', class: 'd-none d-md-table-cell' },
      { id: 4, text: __('changehistory.new'), title: 'changehistory.new', value: 'fields[0].new', class: 'd-none d-md-table-cell' },
    ],
    expanded: [],
  }),
  mounted() {
    this.getHistory()
    this.checkHeaders()
  },
  methods: {
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    async getHistory() {
      try {
        const data = await axios.get(`/api/log-global/${this.model}/${this.item.id}/changes/`);
        this.changes = data.data;
        this.changes.map((item, index) => {
          item.id = index
        })
      } catch (e) {
        console.log('error requesting');
      }
    },
    formatDate (dateval, val) {
      if (!dateval) return null
      if (val == 'withTime') {
        const [date, time] = dateval.split(' ')
        const [year, month, day] = date.split('-')
        const [hour, min, sec] = time.split(':')
        return `${day}.${month}.${year} ${hour}:${min}`
      }
      else {
        const [year, month, day] = dateval.split('-')
        return `${day}.${month}.${year}`
      }
    },
    checkHeaders() {
      this.headers.map(head => {
        if (head.text == head.title) {
          head.text = '<span class="no_translate">'+head.title+'</span>'
        }
      })
    },
  },
  computed: {
    auth_user: {
      get() { return this.$store.state.auth_user }
    }
  },
  watch: {
    item: function (val) {
      this.getHistory()
    }
  }
};
</script>
<style lang="scss">
  tr.no-hover:hover {
    background: transparent !important;
  }
</style>
