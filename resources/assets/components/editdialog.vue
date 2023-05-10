<template>
    <v-card color="#f6f6f6">
      <v-form v-model="valid" v-if="$props.item.field != undefined">
        <v-card-title class="py-4" v-html="item.field.text">
        </v-card-title>
        <v-card-text>
          <template v-if="$props.item.field.type == 'text' || $props.item.field.type == 'title'">
            <v-text-field
              solo
              flat
              dense
              v-model="$props.item[$props.item.field.val]"
              :rules="item.field.rules"
              v-mask="$props.item.field.mask"
              v-if="$props.item.field.mask != undefined"
            ></v-text-field>
            <v-text-field
              ref="input"
              solo
              flat
              dense
              v-model="$props.item[$props.item.field.val]"
              :rules="item.field.rules"
              :type="$props.item.field.val == 'date' ? 'date' : 'text'"
              v-else
            ></v-text-field>
          </template>
          <template v-else-if="$props.item.field.type == 'time'">
            <v-text-field
              solo
              flat
              dense
              v-model="$props.item[$props.item.field.val]"
              type="time"
            ></v-text-field>
          </template>
          <template v-else-if="$props.item.field.type == 'number'">
            <v-text-field
              solo
              flat
              dense
              v-model="$props.item[$props.item.field.val]"
              type="number"
            ></v-text-field>
          </template>

          <template v-else-if="$props.item.field.type == 'titles-number'">
            <v-text-field
              solo
              flat
              dense
              v-model="$props.item.titles[$props.item.field.index][$props.item.field.val]"
              type="number"
            ></v-text-field>
          </template>

          <template v-else-if="$props.item.field.type == 'date'">
            <v-menu
              ref="date_menu"
              v-model="date_menu"
              :close-on-content-click="false"
              transition="scale-transition"
              max-width="290px"
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  :value="formatDate($props.item[$props.item.field.val])"
                  placeholder="##.##.####"
                  append-icon="mdi-calendar"
                  @click:append="date_menu = !date_menu"
                  v-bind="attrs"
                  solo
                  flat
                  @blur="$props.item[$props.item.field.val] = parseDate(dateFormatted)"
                  v-on="on"
                  readonly
                  :rules="$props.item.field.rules"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="$props.item[$props.item.field.val]"
                @input="date_menu = false"
                :first-day-of-week="1"
                :allowed-dates="allowedDates"
              ></v-date-picker>
            </v-menu>
          </template>
          <template v-else-if="$props.item.field.type == 'textarea'">
            <v-textarea
              solo
              flat
              dense
              v-model="$props.item[$props.item.field.val]"
              :rules="$props.item.field.rules"
              auto-grow
            ></v-textarea>
          </template>
          <template v-else-if="$props.item.field.type == 'rating'">
            <v-rating
              v-model="$props.item[$props.item.field.val]"
              color="yellow darken-3"
              background-color="grey darken-1"
              empty-icon="$ratingFull"
            ></v-rating>
          </template>


		  <template v-else-if="$props.item.field.type == 'v-select'">
		  	<vue-select
              :options="$props.item.field.options"
			  class="vueSelect"
              v-model="$props.item[$props.item.field.val]"
			>
			</vue-select>
		  </template>


      <template v-else-if="$props.item.field.type == 'v-titles-select'">
        <vue-select
              :options="$props.item.field.options"
              class="vueSelect"
              v-model="$props.item.titles[$props.item.field.index][$props.item.field.val]"
      >
      </vue-select>
      </template>




		  <template v-else-if="$props.item.field.type == 'select'">
            <v-select
              :items="$props.item.field.options"
              v-model="$props.item[$props.item.field.val]"
              item-text="title"
              item-value="id"
			  solo
              flat
              dense
			  menu-props="auto"
			  :rules="$props.item.field.rules"
            >
              <template v-slot:item="{ item }">
                <span v-html="item.title"></span>
              </template>
              <template v-slot:selection="{ item }">
                <span v-html="item.title"></span>
              </template>
            </v-select>
          </template>

        <template v-else-if="$props.item.field.type == 'titles-select'">
            <v-select
              :items="$props.item.field.options"
              v-model="$props.item.titles[$props.item.field.index][$props.item.field.val]"
              item-text="title"
              item-value="id"
        solo
              flat
              dense
        menu-props="auto"
        :rules="$props.item.field.rules"
            >
              <template v-slot:item="{ item }">
                <span v-html="item.title"></span>
              </template>
              <template v-slot:selection="{ item }">
                <span v-html="item.title"></span>
              </template>
            </v-select>
          </template>




          <!--условие оплаты-->
       <template v-else-if="$props.item.field.type == 'u-select'">
            

            <v-select
              :items="$props.item.field.options"
              v-model="$props.item[$props.item.field.val]"
              item-text="title"
              item-value="title"
        solo
              flat
              dense
        menu-props="auto"
        :rules="$props.item.field.rules"
            >
              <template v-slot:item="{ item }">
                <span v-html="item.title"></span>
              </template>
              <template v-slot:selection="{ item }">
                <span v-html="item.title"></span>
              </template>
            </v-select>

            <template v-if="
            $props.item[$props.item.field.val] !== undefined
            &&  
            $props.item[$props.item.field.val] !== 'В течение 5 дней после поставки'
            &&
            $props.item[$props.item.field.val] !== 'Через 30 дней после доставки'
            &&
            $props.item[$props.item.field.val] !== 'Через 60 дней после доставки'
            &&
            $props.item[$props.item.field.val] !== 'Через 90 дней после доставки'
            &&
            $props.item[$props.item.field.val] !== 'Предоплата'            
            ">
              <v-text-field
              solo
              flat
              dense
              v-model="$props.item[$props.item.field.val]"
              type="text"
            ></v-text-field>
            </template>

          </template>  



      <template v-else-if="$props.item.field.type == 'r-select'">
            <v-autocomplete
              :items="$props.item.field.options"
              v-model="$props.item[$props.item.field.val]"
              item-text="title"
              item-value="id"
        solo
              flat
              dense
        menu-props="auto"
        :rules="$props.item.field.rules"
            >
              <template v-slot:item="{ item }">
                <span v-html="item.title"></span>
              </template>
              <template v-slot:selection="{ item }">
                <span v-html="item.title"></span>
              </template>
            </v-autocomplete>
          </template>

          <template v-else-if="$props.item.field.type == 'file'">
            <v-file-input 
              accept="image/png, image/jpeg, image/bmp"
              solo
              flat
              dense
              v-model="$props.item.file"
              :rules="img_rules"
            >
            </v-file-input>
			<span style="margin-left:33px;">Файл размером не более 6 Мб</span>
          </template>
          <template v-else-if="$props.item.field.type == 'pdf'">
            <v-file-input 
              accept="application/pdf"
              solo
              flat
              dense
              v-model="$props.item.file"
              :rules="pdf_rules"
            >
            </v-file-input>
			<span style="margin-left:33px;">Файл размером не более 6 Мб</span>
          </template>
          <template v-else-if="$props.item.field.type == 'multiselect'">
            <v-select
              v-model="$props.item[$props.item.field.val]"
              :items="$props.item.field.options"
              item-text="title"
              item-value="id"
              solo
              flat
              dense
              multiple
              @change="changeMultiselect"
            ></v-select>            
          </template>
          <template v-else-if="$props.item.field.type == 'multiselect2'">
            <v-autocomplete
              v-model="$props.item[$props.item.field.val]"
              :items="$props.item.field.options"
              item-text="title"
              item-value="title"
              solo
              flat
              dense
              multiple
            ></v-autocomplete>
            <br><br><br><br><br><br><br><br><br><br><br><br>
          </template>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" small text class="font-weight-medium" @click.stop="$emit('close')" v-html="__('buttons.cancel')"></v-btn>
          <v-btn color="black" small text class="font-weight-medium" type="submit" @click.prevent="check" :loading="loading" v-html="__('buttons.submit')"></v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
</template>

<script> 
import { mask } from 'vue-the-mask'

export default {
  name: 'editdialog',
  data: vm => ({
      valid: false,
      now: new Date().toISOString().substr(0, 10),
      phone_rules: [
        v => !!v || __('forms.required_field'),
        v => v.length == 18 || __('forms.phone_error'),
      ],
      date_menu: false,
      dateFormatted: vm.formatDate(vm.item.date),
      today: new Date().toISOString().substr(0, 10),
  }),
  props: {
    item: Object,
  },
  methods: {
    allowedDates(val) {
      if (this.item.field.min_date != undefined) {
        if (val <= this.item.field.min_date) return false
        else return true
      }
      else if (val <= this.today) return false
      else return true
    },
    changeMultiselect() {
      if (this.item[this.item.field.val].length > 2) {
        this.item[this.item.field.val].splice(0, 1)
      }
    },
    check() {
      if (this.item.type == 'date' || this.item.field.val == 'date') {
        if (this.now > this.item[this.item.field.val]) {
          let send = {
            status: 0,
            text: __('forms.date_error')
          }
          this.$store.commit('SET_SNACKBAR', send)
          this.$emit('close')
        }
        else {
          if (this.valid == true) { this.$emit('submit') }
        }
      }
      else {
        if (this.valid == true) { this.$emit('submit') }
      }
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
    parseDate (date) {
      if (!date) return null
      const [day, month, year] = date.split('.')
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
    },
  },
  computed: {
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    }
  },
  directives: {  mask },
  mounted() {
    const input = this.$refs.input;
    if (input) {
      setTimeout(() => input.focus());
    }
  }
};

</script>

<style>
.vueSelect .vs__search::placeholder,
.vueSelect .vs__dropdown-toggle,
.vueSelect .vs__dropdown-menu {
  background: #fff;
  border: none;
  padding:.5em;
  margin-bottom:10em;
}
.vueSelect .vs__dropdown-menu {
  max-height: 11em;
}

</style>
