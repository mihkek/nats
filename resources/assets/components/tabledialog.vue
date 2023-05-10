<template>
    <v-card color="#fafafa" v-if="item.field != undefined">
      <v-toolbar color="transparent" flat>
        <v-toolbar-title class="title" v-html="item.field.text"></v-toolbar-title>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          solo
          flat
          dense
          single-line
          hide-details
          prepend-icon="mdi-magnify"
          placeholder="Поиск"
        ></v-text-field>
        <v-btn color="grey darken-1" @click.stop="$emit('close')" small icon class="my-icon-btn mr-1 ml-4"><v-icon>mdi-close</v-icon></v-btn>
      </v-toolbar>
      <v-divider class="my-0"></v-divider>
      <template v-if="item.field.options != undefined">
        <v-card flat color="#fff" tile  class="pa-2">
          <v-slide-group>
            <span class="ml-2 mr-4 font-weight-bold" style="line-height: 28px;">Дополнительные помещения:</span>
            <v-slide-item v-for="(option, index) in item.field.options" :key="index" v-slot:default="{ active, toggle }">
              <v-btn small class="mx-1 rounded-btn" active-class="primary white--text" depressed @click.stop="selectOption(option)" outlined>
                <v-icon left v-if="active">mdi-check</v-icon> <span class="font-weight-medium">{{ option.title }}</span>
              </v-btn>
            </v-slide-item>
          </v-slide-group>
        </v-card>
      <v-divider class="my-0"></v-divider>
      </template>
      <v-data-table
        :items="item.field.items"
        :headers="item.field.headers"
        :search="search"
        locale="ru"
        class="dialog-datatable"
        height="69vh"
        :mobile-breakpoint="100"
        :sort-by="['full_name']"
        item-key="name"
      >
        <template v-slot:item="{ item, headers }">
          <tr class="table-row font-weight-medium" @click.stop="selectRow(item)">
            <td v-for="(head, index) in headers" :key="index" :class="head.class">{{item[head.value]}}</td>
          </tr>
        </template> 
       <!--  <template v-slot:item.phone="{ item }"><span v-if="item.phone != null">{{ maskedPhone(item.phone) }}</span></template> -->
      </v-data-table>
    </v-card>
</template>

<script> 
export default {
  name: 'tabledialog',
  data () {
    return {
      search: null,
    }
  },
  props: {
    item: Object,
  },
  mounted() {
  },
  methods: {
    selectOption(option)  {
      this.$props.item[this.$props.item.field.val] = option
      this.$props.item[this.$props.item.field.val].option = true
      this.$emit('submit')
    },
    selectRow(row) {
      this.$props.item[this.$props.item.field.val] = row
      this.$props.item[this.$props.item.field.val].option = false
      this.$emit('submit')
    }
  },
  computed: {
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    }
  },
};
</script>
