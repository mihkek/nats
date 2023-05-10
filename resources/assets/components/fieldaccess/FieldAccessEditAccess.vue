<template>
    <v-card color="#fafafa">
        <v-form>
            <v-card-title class="py-4">
                Управление доступом к {{ model === 'access' ? 'странице' : 'полю' }} &laquo;{{ field_name }}&raquo;
            </v-card-title>
            <v-card-text>
            <v-card flat>
            <v-container fluid grid-list-lg>
                
              <template v-for="(role, index) in roles">
              <v-layout row wrap :key="role.id">
                <v-flex md4 class="subtitle-2 font-weight-bold" style="line-height: 28px;">{{role.name}}</v-flex>
                <v-flex md8>
                  <v-radio-group small v-model="selected[role.id]" row dense hide-details class="my-0">
                    <v-radio small v-for="option in accessOptions" :key="option.value" :label="option.text" :value="option.value"></v-radio>
                  </v-radio-group>
                </v-flex>
              </v-layout>
              <v-divider class="my-0" v-if="index != roles.length - 1"></v-divider>
            </template>
            </v-container>
            </v-card>
            </v-card-text>
            <!-- <v-list color="transparent" v-if="roles">
              <template v-for="(role, index) in roles">
                <v-list-item :key="role.id">
                  <v-list-item-content class="font-weight-bold" style="max-width: 30%;">{{role.name}}</v-list-item-content>
                  <v-list-item-content>
                    <v-radio-group v-model="selected[role.id]" row dense hide-details class="my-0">
                      <v-radio  v-for="option in accessOptions" :key="option.value" :label="option.text" :value="option.value"></v-radio>
                    </v-radio-group>
                   <v-select
                    v-model="selected[role.id]"
                    :items="accessOptions"
                    :label="role.name"
                  ></v-select> 
                  </v-list-item-content>
                </v-list-item>           
                <v-divider v-if="index != roles.length-1" class="my-0"></v-divider>             
              </template>
            </v-list> -->
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="black" small text class="font-weight-medium" @click.stop="$emit('close')">Отмена</v-btn>
                <v-btn color="black" small text class="font-weight-medium" type="submit" @click.prevent="handleSubmit">Сохранить</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>


    export default {
      props: [ 'model', 'field', 'field_name' ],
      data: () => ({
        selected: {
        },
      }),
      methods: {
        async handleSubmit() {
          await this.$store.dispatch('SET_ACCESS_MODEL_FIELDS', {
            model: this.model,
            field: this.field,
            access: this.selected
          });
          this.$emit('submit', this.selected);
        }
      },
      mounted: async function() {
        if (this.roles === null) {
          await this.$store.dispatch('GET_ACCESS_DATA');
        }
        const currentSelected = this.fieldAccess === null ?
          await this.$store.dispatch('GET_ACCESS_MODEL_FIELDS', { model: this.model })
          : this.fieldAccess;

        this.selected = currentSelected[this.field]
          || this.roles.reduce((acc, role) => { acc[role.id] = 'write'; return acc; }, {});
      },
      computed: {
        roles: {
          get() {
            return this.$store.state.fieldaccess.roles;
          }
        },
        fieldAccess: {
          get() {
            return this.$store.state.fieldaccess.modelFields[this.model] || null;
          }
        },
        accessOptions: {
          get () {
            if (this.model === 'access') return [
              {text: 'Скрыто', value: 'disabled'},
              {text: 'Доступно', value: 'write'},
            ];

            return [
              {text: 'Скрыто', value: 'disabled'},
              {text: 'Чтение', value: 'read'},
              {text: 'Редактирование', value: 'write'},
            ];
          }
        }
      }
    }
</script>
