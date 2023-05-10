<template>
    <v-card color="#fafafa">
        <v-form>
            <v-card-title class="py-4">
                Управление доступом к полю &laquo;{{ field_name }}&raquo;
            </v-card-title>
            <v-card-text>
                <v-row align="center" v-if="roles">
                    <v-container fluid>
                        <v-col class="d-flex" cols="12" sm="6" v-for="role in roles">
                            <v-select
                                    :items="accessOptions"
                                    :label="role.name"
                            ></v-select>
                        </v-col>
                    </v-container>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="black" small text class="font-weight-medium" @click.stop="$emit('close')">Отмена</v-btn>
                <v-btn color="black" small text class="font-weight-medium" type="submit" @click.prevent="$emit('submit')">Сохранить</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>
    export default {
      props: [ 'model', 'field', 'field_name' ],
      data: () => ({
        roles: null,
        accessOptions: [
          { text: 'Скрыто', value: '' },
          { text: 'Чтение', value: 'read' },
          { text: 'Полный доступ', value: 'full' },
        ]
      }),
      methods: {

      },
      mounted: async function() {
        this.roles = await this.$store.dispatch('GET_ACCESS_ROLES');
      }
    }
</script>
