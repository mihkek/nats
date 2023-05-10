<template>
    <div>
        <div class="tabbable-custom">
            <ul class="nav nav-tabs">
                <li v-for="tab in tabs" :class="{ active: tab.id === activeTab }">
                    <a href="#" aria-expanded="true" @click.prevent="selectTab(tab.id)">
                        <b>{{tab.name}}</b>
                    </a>
                </li>
            </ul>
        </div>
        <keep-alive>
            <component v-bind:is="tabComponent" :model="model" :model_id="model_id" />
        </keep-alive>

    </div>
</template>
<script>
    import Calendar from './Calendar';
    import FreeTime from './FreeTime';
    import History from './History';

    export default {
      props: [ 'model', 'model_id' ],
      data: () => ({
        activeTab: 'calendar',
        tabs: [
          { id: 'calendar', name: 'Календарь', component: Calendar },
          { id: 'freetime', name: 'Свободное время', component: FreeTime },
          { id: 'history', name: 'История', component: History },
        ]
      }),
      methods: {
        selectTab: function(id) {
          this.activeTab = id;
        }
      },
      components: { Calendar, FreeTime, History },
      computed: {
        tabComponent: function() {
          return this.tabs.reduce((acc, item) => item.id === this.activeTab ? item.component : acc, null);
        }
      }
    }
</script>
<style scoped lang="scss">
    .tabbable-custom {
        margin-bottom: 0;
        ul {
            padding-left: 0;
        }
    }
</style>