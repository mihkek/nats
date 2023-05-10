<template>
    <v-card flat color="transparent">
        <v-system-bar
          color="#999"
          :height="height"
          :lights-out="lightsOut"
          :window="window"
          :elevation="2"
          style="border-radius: 8px !important;"
          dark
        >
          <v-toolbar-title dense class="subtitle-2" v-html="__('admin_panel.title')">
          </v-toolbar-title>
          <v-spacer></v-spacer>

          
          <template v-if="!loading">
<!--
            <p class="my-0 mx-2" v-html="__('admin_panel.lang_placeholder')"></p>
            <v-divider vertical class="my-0 mx-0"></v-divider>
            <v-toolbar-items>
              <v-card width="180px" flat color="transparent" id="admin-panel">
                <v-select
                  :items="items"
                  v-model="locale"
                  item-value="code"
                  item-text="placeholder"
                  dense
                  hide-details
                  class="mt-0 caption"
                  solo
                  flat
                  backgroundColor="rgba(255,255,255,0.2)"
                  small
                  height="38px"
                  prepend-inner-icon=""
                  append-icon=""
                  single-line
                  attach="#admin-panel"
                  right
                  dark
                >
                  <template v-slot:append>
                    <v-icon>mdi-menu-down</v-icon>
                  </template>
                </v-select>
              </v-card>
-->
            </v-toolbar-items>
            <FieldAccess model="access" :field="pageCode" :field_name="pageTitle" v-slot="{ accessData }">
              <v-btn color="white" class="mx-2" text small @click="accessData.settings()">
                <v-icon class="mr-0">mdi-settings</v-icon>
              </v-btn>
            </FieldAccess>
          </template>
          <v-progress-linear absolute bottom color="primary" :height="4" indeterminate v-show="loading"></v-progress-linear>
        </v-system-bar>
      </v-card>
</template>
<script>
  import FieldAccess from '../fieldaccess/FieldAccess';
  import FieldAccessButton from '../fieldaccess/FieldAccessButton';

  export default {
    data: () => ({
      height: 38,
      lightsOut: true,
      window: true,
      selectedItem: {},
    }),
    components: { FieldAccess, FieldAccessButton },
    props: {
      loading: Boolean,
    },
    mounted() {
      this.loading = true
      this.$store.dispatch('GET_LANG_ITEMS').then(res => { this.loading = false })
    },
    watch: {
      items: function (val) {
        if (val != undefined) {
          val.map(country => { if (country.code == this.locale) { this.selectedItem = country } })
        }
      },
      locale: function (val) {
        this.items.map(country => { if (country.code == val) { this.selectedItem = country } })
      },
    },
    computed: {
      locale: {
        get() {
          return this.$store.state.lang.lang
        },
        set(lang) {
          this.$store.dispatch('SET_LANG', { lang });
        }
      },
      items: {
        get() { return this.$store.state.lang.items }
      },
      pageTitle: {
        get: () => document.title,
      },
      pageCode: {
        get: () => document.querySelector('meta[name="route_name"]').getAttribute('content'),
      }
    }
  };
</script>

<style>
  .v-select.v-input--dense .v-select__selection--comma {
    margin: 5px 4px 5px 0px !important;
  }
</style>