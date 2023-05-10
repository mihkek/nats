<template>
  <v-card flat color="#fff" tile>
    <v-container fluid grid-list-xl>
<!--       <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0 mb-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <FieldAccess model="customer_treatment" field="add_new_note" field_name="Добавить строчку" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0">Опыт обучения ранее</h4></v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"><v-icon>mdi-plus</v-icon></v-btn>
                        </template>
                        <span class="caption">Добавить строчку</span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>  
                  <v-divider class="my-0"></v-divider>
                </FieldAccess>
                <FieldAccess model="customer_treatment" field="note" field_name="Изменить строчку" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">Занимались ранее</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">Да</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption">Изменить строчку</span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
        </v-flex>
        <v-flex md6 xs12>
          <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0 mb-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
              <v-list class="py-0" dense>
                <FieldAccess model="customer_treatment" field="add_new_note" field_name="Добавить строчку" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0">Карта обучения</h4></v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"><v-icon>mdi-plus</v-icon></v-btn>
                        </template>
                        <span class="caption">Добавить строчку</span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>  
                  <v-divider class="my-0"></v-divider>
                </FieldAccess>
                <FieldAccess model="customer_treatment" field="note" field_name="Изменить строчку" v-slot="{ accessData }">
                  <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                    <v-list-item-content class="body-2 inline-block">Дата проведения диагностики</v-list-item-content>
                    <v-list-item-content class="body-2 inline-block text-right">22.09.2019</v-list-item-content>
                    <v-list-item-icon class="ml-2 text-right">
                      <v-tooltip top v-if="accessData.canEdit">
                        <template v-slot:activator="{ on }">
                          <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"><v-icon>mdi-sync</v-icon></v-btn>
                        </template>
                        <span class="caption">Изменить строчку</span>
                      </v-tooltip>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card>
        </v-flex>
      </v-layout> -->
    </v-container>
  </v-card>
</template>

<script>
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  props: {
    item: Object,
  },
  data: () => ({

  }),
  components: { FieldAccess, FieldAccessButton },
  methods: {

  },
  computed: {

  }
};
</script>
