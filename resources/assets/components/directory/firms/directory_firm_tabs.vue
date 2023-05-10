<template>
  <div>
    <v-card color="#fafafa" flat>
    <v-tabs show-arrows>
      <v-tab v-for="tab in tabs" :class="{ active: tab.id === activeTab }" v-if="tab.admin != true" @click.prevent="selectTab(tab.id)" :key="tab.id"><v-icon left small color="primary">{{tab.icon}}</v-icon><b v-html="tab.name">{{tab.name}}</b></v-tab>
      <v-tab :class="{ active: activeTab === 'change_history' }" @click.prevent="selectTab('change_history')" v-if="auth_user.role_id == 1000"><v-icon left small color="primary">mdi-history</v-icon><b v-html="__('changehistory.title')"></b></v-tab>
    </v-tabs>
    </v-card>
    <keep-alive>
      <component v-bind:is="tabComponent" :item="item" :model="'directory_firm'"/>
    </keep-alive>
  </div>
</template>

<script>
    import directory_firm_calendar from './directory_firm_calendar';
    import directory_firm_freetime from './directory_firm_freetime';
    import directory_firm_orderers from './directory_firm_orderers';
    import directory_firm_rent from './directory_firm_rent';
    import change_history from './../../change_history';

    export default {
      props: {
        item: Object,
        auth_user: Object,
      },
      data: () => ({
        activeTab: 'calendar',
        options: [
          { id: 'calendar', name: __('calendars.title'), text: 'calendars.title', component: directory_firm_calendar, icon: 'mdi-calendar' },
          { id: 'freetime', name: __('freetime.title'), text: 'freetime.title', component: directory_firm_freetime, icon: 'mdi-calendar-clock' },
          { id: 'rent', name: __('directory_firm.rent'), text: 'directory_firm.rent', component: directory_firm_rent, icon: 'mdi-wallet' },
          { id: 'orderers', name: __('orderer.title'), text: 'orderer.title', component: directory_firm_orderers, icon: 'mdi-notebook-multiple' },
          { id: 'change_history', name: __('changehistory.title'), text: 'changehistory.title', component: change_history, icon: 'mdi-history', admin: true },
        ]
      }),
      methods: {
        selectTab: function(id) {
          this.activeTab = id;
        }
      },
      components: { change_history, directory_firm_orderers, directory_firm_freetime, directory_firm_calendar, directory_firm_rent },
      computed: {
        tabComponent: function() {
          return this.tabs.reduce((acc, item) => item.id === this.activeTab ? item.component : acc, null);
        },
        tabs: {
          get() {
            this.options.map(option => {
              if (option.name == option.text) {
                option.name = '<span class="no_translate">'+option.text+'</span>'
              }
            })
            return this.options
          }
        }
      }
    };
</script>

<style scoped lang="scss">
    .tabbable-custom {
        margin-bottom: 0;
        ul {
            padding-left: 0;
        }
    }
</style>