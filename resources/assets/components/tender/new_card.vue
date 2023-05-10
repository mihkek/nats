<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0">


      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" class="mb-3" :loading="loading"/>
      </FieldAccess>
      <v-layout row wrap>

        <v-flex md6 xs12>
          <v-card flat outlined class="mb-4">
            <v-card-title>
              <span v-if="auction.id > 0">Тендер №{{ auction.id }}</span>
              <span v-else>Новый тендер</span>
            </v-card-title>

            <v-list subheader>



<template v-for="(item_title, item_index) in item.titles">

              <FieldAccess :model="prefix+'tender'" field="title"
                           field_name="Наименование препарата" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Наименование препарата *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Начните вводить название препарата и выберете необходимый из предложенного</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                    <p class="my-0">{{ item_title.title || '-' }}</p>
                  </v-list-item-content>

                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Наименование средства', index: item_index, val: 'title', type: 'v-titles-select', options: v_select_title_options })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <!--
                                  <template v-slot:activator="{ on }">
                                              <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Наименование средства', val: 'title', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                                            </template>
                      -->
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
                <v-list-item>
                  <v-list-item-content style="padding-top:0;">
                    <v-list-item-subtitle>Действующее веществo

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>В этом окне вы увидите действующее вещество в составе выбранного препарата</span>
    </v-tooltip>
                    </v-list-item-subtitle>
                    <p class="my-0">{{ item_title.active_material || '-' }}</p>
                  </v-list-item-content>
                </v-list-item>
              </FieldAccess>





              <FieldAccess :model="prefix+'tender'" field="is_analog"
                           field_name="Можно предлагать аналоги по ДВ" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Можно предлагать аналоги по ДВ *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Укажите, можно ли вам предлагать аналоги по действующему веществу препарата</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                    <p class="my-0" v-if="item_title.is_analog == 1">Да</p>
                    <p class="my-0" v-else-if="item_title.is_analog == 0">Нет</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Можно аналоги', index: item_index, val: 'is_analog', type: 'titles-select', options: [ { id: 1, title: 'Да' }, { id: 0, title: 'Нет' } ] })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'" field="title"
                           field_name="Исключить аналоги" v-slot="{ accessData }" v-if="item_title.is_analog">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Исключить аналоги

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Вы можете исключить аналоги по действующему веществу выбранного вами препарата</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                    <p class="my-0">
                      <template v-if="item_title.exclude_analogs" v-for="anlg in item_title.exclude_analogs">
                        {{ anlg + " " }}
                      </template>
                      <template v-else="">
                        -
                      </template>
                    </p>
                  </v-list-item-content>

                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Наименование средства', val: 'exclude_analogs', type: 'multiselect2', options: analog_options })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>


              <FieldAccess :model="prefix+'tender'" field="size"
                           field_name="Объем" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Объем *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Укажите необходимый объем поставки</span>
    </v-tooltip>


                    </v-list-item-subtitle>
                    <p class="my-0">{{ item_title.size || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Объем', index: item_index, val: 'size', type: 'titles-number' })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'" field="unit"
                           field_name="Единица измерения" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Единица измерения *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Выберите необходимую единицу измерения (килограммы или литры)</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                    <p class="my-0">{{ item_title.unit || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Единица измерения', index: item_index, val: 'unit', type: 'titles-select', options: units })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <div class="titles-divider"></div>

</template>




            <template>
                <FieldAccess :model="auction.type == 'rise' ? 'auction' : 'tender' " field="titleadd" field_name=" Добавить препарат"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item>
                    <v-list-item-content class="text-center">
                      <v-list-item-subtitle class="text-center">
                        <v-btn
                            depressed
                            color="success"
                            @click.stop="titleAdd"
                            text
                            class="rounded-btn"
                            
                        >
                          <v-icon left size="20">mdi-plus</v-icon>
                          Добавить препарат
                        </v-btn>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </template>








              <div class="titles-divider"></div>










              <FieldAccess :model="prefix+'tender'" field="over_date"
                           field_name="Дата окончания тендера" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Дата окончания тендера *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Указав дату окончания тендера, вы будете понимать, когда будет заключен договор на поставку</span>
    </v-tooltip>
                    </v-list-item-subtitle>
                    <p class="my-0">{{ formatDate(item.over_date) || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Дата окончания', val: 'over_date', type: 'date' })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'" field="delivery_date"
                           field_name="Дата поставки" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Дата поставки *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Указав дату поставки, вы будете знать, когда вы получите свой товар</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                    <p class="my-0">{{ formatDate(item.delivery_date) || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn :disabled="item.over_date == undefined" color="red darken-1" icon x-small v-on="on"
                               class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Дата поставки', val: 'delivery_date', type: 'date', min_date: addDateInterval(item.over_date) })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'"
                           field="delivery_condition" field_name="Условия поставки" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Условия поставки *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Выберите один из трех удобных способов поставки приобретенного товара</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                    <p class="my-0"
                       v-if="delivery_conditions.find(el => el.id == auction.delivery_condition) != undefined">
                      {{ delivery_conditions.find(el => el.id == auction.delivery_condition).title }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Условия поставки', val: 'delivery_condition', type: 'select', options: delivery_conditions })">
                               
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'" field="delivery_region"
                           field_name="Регион поставки" v-slot="{ accessData }"
                           :style="auction.delivery_condition == 2 || auction.delivery_condition == 3? 'display:block;':'display:none;'">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Регион поставки *</v-list-item-subtitle>
                    <p class="my-0" v-if="delivery_regions.find(el => el.id == auction.delivery_region) != undefined">
                      {{ delivery_regions.find(el => el.id == auction.delivery_region).title }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Регион поставки', val: 'delivery_region', type: 'r-select', options: delivery_regions })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>
              <!-- -->
              <!--
                      <template v-if="auction.id > 0 && auction.delivery_condition == 2 && auction.user.company_warehouse_address">
                              <v-divider class="my-0"></v-divider>
                              <v-list-item>
                                <v-list-item-content>
                                  <v-list-item-subtitle>Адрес склада</v-list-item-subtitle>
                                  <p class="my-0">{{auction.user.company_warehouse_address}}</p>
                                </v-list-item-content>
                              </v-list-item>
                            </template>
               -->
              <FieldAccess :model="prefix+'tender'"
                           field="customer_warehouse_address" field_name="Адрес склада" v-slot="{ accessData }"
                           :style="auction.delivery_condition == 2? 'display:block;':'display:none;'">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Адрес склада *</v-list-item-subtitle>
                    <p class="my-0">{{ item.customer_warehouse_address || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Адрес склада', val: 'customer_warehouse_address', type: 'text' })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'"
                           field="supplier_warehouse_address" field_name="Адрес склада" v-slot="{ accessData }"
                           :style="auction.delivery_condition == 1 && (item.supplier_warehouse_address || item.status == 2) ? 'display:block;':'display:none;'">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Адрес склада поставщика *</v-list-item-subtitle>
                    <p class="my-0" v-if="item.supplier_warehouse_address">{{ item.supplier_warehouse_address }}</p>
                    <p class="my-0" style="color:#ccc; font-weight:400;" v-else>Будет заполнено победившим
                      поставщиком</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Адрес склада', val: 'supplier_warehouse_address', type: 'text' })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'"
                           field="payment_condition" field_name="Условия оплаты" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Условия оплаты *

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Вы можете выбрать предоплатный или постоплатный способ расчета за приобретаемый товар</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                     <!--<p class="my-0"
                       v-if="payment_conditions.find(el => el.id == auction.payment_condition) != undefined">
                      {{ payment_conditions.find(el => el.id == auction.payment_condition).title }}</p>-->
                    <p class="my-0" v-if="auction.payment_condition">
                      {{ auction.payment_condition }}</p>                   
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Условия оплаты', val: 'payment_condition', type: 'u-select', options: payment_conditions })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'tender'" field="special_terms"
                           field_name="Особые условия" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Особые условия

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Укажите дополнительные пожелания к вашему тендеру</span>
    </v-tooltip>

                    </v-list-item-subtitle>
                    <p class="my-0">{{ item.special_terms || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="editItem({ text: 'Особые условия', val: 'special_terms', type: 'textarea' })">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>


              <FieldAccess :model="prefix+'tender'" field="docs"
                           field_name="Вложенные документы" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Вложенные документы

      <v-tooltip right>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
        small
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          mdi-help-circle-outline
        </v-icon>
      </template>
      <span>Укажите дополнительные документы</span>
    </v-tooltip>

                    </v-list-item-subtitle>


              
                     <p class="my-0" v-if="auctionFiles.length > 0">Загружено {{ auctionFiles.length }} файлов</p>
                     <p class="my-0" v-else @click.stop="openUploadDialog" >Загрузить файлы</p>
                    
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"
                               @click.stop="openUploadDialog">
                          <v-icon>mdi-sync</v-icon>
                        </v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData"/>
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>








              <template v-if="!(auction.id > 0) && !tender_created">
                <FieldAccess :model="auction.type == 'rise' ? 'auction' : 'tender' " field="create" field_name="Создать"
                             v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item>
                    <v-list-item-content class="text-center">
                      <v-list-item-subtitle class="text-center">
                        <v-btn
                            depressed
                            color="success"
                            @click.stop="submitTenders"
                            text
                            class="rounded-btn"
                            :loading="loading"
                        >
                          <v-icon left size="20">mdi-plus</v-icon>
                          Добавить тендеры
                        </v-btn> 
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </template>

              <template
                  v-if="item.id > 0 && item.status == 1 && (auth_user.role_id == 1000 || auth_user.id == item.user_id)">



                <FieldAccess :model="auction.type == 'rise' ? 'auction' : 'tender' " field="cancel"
                             field_name="Отменить" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item>
                    <v-list-item-content class="text-center">
                      <v-list-item-subtitle class="text-center">
                        <v-btn
                            depressed
                            color="red"
                            @click.stop="cancel_dialog = !cancel_dialog"
                            text
                            class="rounded-btn"
                        >
                          <v-icon left size="20">mdi-cancel</v-icon>
                          Отменить тендер
                        </v-btn>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                      <FieldAccessButton :accessData="accessData"/>
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </template>
            </v-list>
          </v-card>
        </v-flex>
        <v-flex md6 xs12>


          <div class="admin-rek">
            <!--<div class="admin-rek-title"><span class="rek-title">Ваша реклама</span></div>-->
            <div class="admin-rek-items">
              <div>
                <a href="http://www.proagro.su/" target="_blank"><img src="/img/banners/proagro-3.jpg" title="www.proagro.su" alt="www.proagro.su" class="admin-rek-banner"></a> 
                 <!--<a href="https://b2bservice.su/" target="_blank"><img src="/img/banners/betobe-3.jpg" title="b2bservice.su" alt="b2bservice.su" class="admin-rek-banner"></a>-->
                 <a href="http://www.proagro.su/" target="_blank"><img src="/img/banners/proagro-2.jpg" title="www.proagro.su" alt="www.proagro.su" class="admin-rek-banner"></a> 
               <a href="https://b2bservice.su/" target="_blank"><img src="/img/banners/betobe-3.jpg" title="b2bservice.su" alt="b2bservice.su" class="admin-rek-banner"></a> 
                 <a href="http://www.proagro.su/" target="_blank"><img src="/img/banners/proagro-1.jpg" title="www.proagro.su" alt="www.proagro.su" class="admin-rek-banner"></a>
                <!--<a href="https://b2bservice.su/" target="_blank"><img src="/img/banners/betobe-2.jpg" title="b2bservice.su" alt="b2bservice.su" class="admin-rek-banner"></a>                 
                <a href="http://www.flora-center.ru/" target="_blank"><img src="/img/banners/101.jpg" title="flora center" alt="flora center" class="admin-rek-banner"></a> <br><br>--> 
                <!--<div class="banner-form-box">
                  <div class="banner-form-box-title"><span>тут может быть ваша реклама</span></div>
                  <div class="banner-form-box-button"><a data-toggle="modal" data-target="#CallMe" class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--large success btn-success"><span>Заказать</span></a></div>
                </div>-->
              </div>
            </div>
          </div>







          <!-- ЕСЛИ ОТМЕНЕН -->
          <v-alert type="error" v-if="item.status == 0" class="mb-3">
            Тендер отменен организатором
          </v-alert>


          <!-- ЕСЛИ ЗАВЕРШЕН -->
          <v-alert
              text
              color="success"
              outlined
              v-if="item.status == 2"
          >
            <v-card flat color="transparent">
              <v-card-title class="title px-0 pt-0 success--text">
                Тендер завершен
              </v-card-title>
              <v-card-subtitle class="px-0 success--text">
                Окончен {{ formatDate(item.over_date) }}г.
              </v-card-subtitle>
              <v-card-text class="px-0 pb-0 success--text">
                <template v-if="item.customer_confirm == 0 || item.supplier_confirm == 0 || auth_user.role_id == 1000">
                  <p class="mt-0" v-if="item.customer_confirm == 0 && item.supplier_confirm == 0"> Ожидает подписания
                    договора между поставщиком и покупателем.</p>
                  <p class="mt-0" v-if="item.customer_confirm == 1 && item.supplier_confirm == 0"> Договор подписан
                    покупателем, ожидает подписания со стороны поставщика.</p>
                  <p class="mt-0" v-if="item.customer_confirm == 0 && item.supplier_confirm == 1"> Договор подписан
                    поставщиком, ожидает подписания со стороны покупателя.</p>
                  <p class="mt-0" v-if="item.customer_confirm == 1 && item.supplier_confirm == 1"> Обе стороны подписали
                    договор</p>
                  <template
                      v-if="item.customer_confirm < 1 && (item.user_id == auth_user.id || auth_user.role_id == 1000)">
                    <v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('customer',1)">
                      Подписать{{ item.user_id != auth_user.id || auth_user.role_id == 1000 ? ' как клиент' : '' }}
                    </v-btn>
                  </template>
                  <template
                      v-if="(item.customer_confirm < 1 && item.user_id == auth_user.id) || auth_user.role_id == 1000">
                    <v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('customer')">
                      {{
                        item.user_id != auth_user.id || auth_user.role_id == 1000 ? ' Реквизиты клиента' : 'Реквизиты'
                      }}
                    </v-btn>
                  </template>
                  <br v-if="auth_user.role_id == 1000 && (item.customer_confirm == 0 || item.supplier_confirm == 0)">
                  <template
                      v-if="item.supplier_confirm < 1 && (item.win_rate.user.id == auth_user.id || auth_user.role_id == 1000)">
                    <v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('supplier',1)">
                      Подписать{{
                        item.win_rate.user.id != auth_user.id || auth_user.role_id == 1000 ? ' как поставщик' : ''
                      }}
                    </v-btn>
                  </template>
                  <template
                      v-if="(item.supplier_confirm < 1 && item.win_rate.user.id == auth_user.id) || auth_user.role_id == 1000">
                    <v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('supplier')">
                      {{
                        item.win_rate.user.id != auth_user.id || auth_user.role_id == 1000 ? ' Реквизиты поставщика' : 'Реквизиты'
                      }}
                    </v-btn>
                  </template>
                </template>
                <template v-else>
                  Обе стороны подписали договор
                </template>
              </v-card-text>
            </v-card>
            <div
                v-if="(item.customer_confirm == 1 && item.supplier_confirm == 1 && auth_user.role_id == 1000) || (item.customer_confirm == 1 && item.user_id == auth_user.id) || (item.supplier_confirm == 1 && auth_user.role_id == 102)">
              <v-divider
                  class="my-4 success"
                  style="opacity: 0.22"
              ></v-divider>
              <v-row
                  align="center"
                  no-gutters
              >
                <v-col class="grow">
                </v-col>
                <v-spacer></v-spacer>
                <v-col class="shrink">
                  <v-btn color="success" @click.stop="confirm('all')">Договор
                    <v-icon right size="20">mdi-file</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </div>
          </v-alert>

          <!-- Организатор аукциона -->
          <v-card class="mb-3" flat outlined
                  v-if="item.user != false && (auth_user.role_id == 1000 || auth_user.role_id == 102 || (item.win_rate != undefined && item.win_rate.user.id == auth_user.id))">
            <v-list subheader>
              <v-subheader>Организатор аукциона
                <v-spacer></v-spacer>
                <v-icon>mdi-city-variant</v-icon>
              </v-subheader>
              <v-list-item three-line>
                <v-list-item-avatar>
                  <v-img
                      :src="item.user.avatar == null ? '/storage/avatars/50x50.nophoto.png' : '/storage/avatars/48x48.'+item.user.avatar">
                  </v-img>
                </v-list-item-avatar>
                <v-list-item-content style="overflow:visible;">
                  <v-list-item-title>{{ item.user.company_name }}</v-list-item-title>
                  <v-list-item-subtitle v-if="auth_user.role_id == 1000">{{ item.user.email }}</v-list-item-subtitle>
                  <v-list-item-subtitle v-if="auth_user.role_id == 1000">{{ item.user.phone }}</v-list-item-subtitle>
                  <v-list-item-subtitle v-if="item.user.company_check_file" style="overflow:visible;">
                    <v-btn elevation="2" x-small class="my-1 success--text"
                           :href="'/storage/proofs/'+item.user.company_check_file" target="_blank">
                      <v-icon size="18" color="success">mdi-check</v-icon>
                      <span class="ml-1">Результат проверки пользователя</span></v-btn>
                  </v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-card>

          <winner :item="item"/>

          <template v-if="item.id > 0">
            <rates :item="item" @refresh="getItem"/>
            <DateLogger :item="item" :auth_user="auth_user"/>
          </template>
        </v-flex>
      </v-layout>
      <v-layout v-if="item.id > 0 && auth_user.role_id == 1000">
        <v-flex xs12>
          <tabs :item="item" :auth_user="auth_user"/>
        </v-flex>
      </v-layout>
    </v-container>
    <v-dialog v-model="close_dialog" max-width="420">
      <v-card>
        <v-card-title>
          Подтвердить досрочное окончание
        </v-card-title>
        <v-card-text>
          Вы действительно хотите досрочно окончить тендер
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="close_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="closeItem" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="cancel_dialog" max-width="420">
      <v-card>
        <v-card-title>
          Подтвердить удаление
        </v-card-title>
        <v-card-text>
          Вы действительно хотите отменить тендер
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="cancel_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="cancelItem" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialog" max-width="420px">
      <editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/>
    </v-dialog>
    <v-dialog scrollable v-model="confirm_dialog" max-width="1185px">
      <confirmdialog v-if="confirm_dialog" :item="item" :type="confirm_type" @refresh="getItem"
                     @close="confirm_dialog = false"/>
    </v-dialog>
    <v-dialog persistent v-model="requisits_dialog" max-width="640px" v-if="!$props.new">
      <v-form v-model="valid" ref="formRequisits" @submit.prevent="submitRequisits" @submit="submitRequisits">
        <v-card>
          <v-card-title v-if="auth_user.role_id == 1000">
            Реквизиты {{ requisits_of != 'supplier' ? 'клиента' : 'поставщика' }}
          </v-card-title>
          <v-card-title v-else>
            Реквизиты для договора
          </v-card-title>
          <v-card-text>
            <v-layout row wrap>
              <v-flex md6 xs12 class="pa-3">
                <b>ИНН *</b>
                <v-text-field
                    label=""
                    filled
                    dense
                    required
                    readonly
                    :rules="rules"
                    v-model="requisits_of != 'supplier' ? item.user.company_inn : item.win_rate.user.company_inn"
                ></v-text-field>
                <b>ОГРН/ОГРНИП *</b>
                <v-text-field
                    label=""
                    filled
                    dense
                    required
                    :rules="ogrn_rules"
                    v-model="item[requisits_of+'_ogrn']"
                ></v-text-field>
                <!-- {{
                      <vue-select
                            :options="company_ogrn_options"
                      :filterable="false"
                      :taggable="true"
                      :create-option="option => option"
                      :ref="`select-company_ogrn`"
                      @search:blur="() => vSelectBlur('company_ogrn')"
                      :clearSearchOnBlur="(option) => {}"
                      selectOnTab
                            v-model="item.customer_ogrn"
                      class="vueSelectTender"
                      ></vue-select>
                }} -->
                <b v-show="requisits_of == 'company' && item.delivery_condition == 2">Адрес склада компании *</b>
                <b v-show="requisits_of == 'supplier' && item.delivery_condition == 1">Адрес склада поставщика *</b>
                <v-textarea
                    label=""
                    filled
                    dense
                    required
                    rows="3"
                    auto-grow
                    v-model="item[requisits_of+'_warehouse_address']"
                    :rules="(requisits_of != 'supplier' && item.delivery_condition == 2) || (this.requisits_of == 'supplier' && item.delivery_condition == 1) ? rules: false"
                    v-show="(requisits_of != 'supplier' && item.delivery_condition == 2) || (this.requisits_of == 'supplier' && item.delivery_condition == 1)"
                ></v-textarea>

              </v-flex>
              <v-flex md6 xs12 class="pa-3">
                <b>Рассчетный счет *</b>
                <v-text-field
                    label=""
                    filled
                    dense
                    required
                    :rules="account_rules"
                    v-model="item[requisits_of+'_bank_account']"
                ></v-text-field>

                <b>Корреспондентский счет *</b>
                <v-text-field
                    label=""
                    filled
                    dense
                    required
                    :rules="account_rules"
                    v-model="item[requisits_of+'_correspondent_account']"
                ></v-text-field>

                <b>БИК Банка *</b>
                <v-text-field
                    label=""
                    filled
                    dense
                    required
                    :rules="bik_rules"
                    v-model="item[requisits_of+'_bank_bik']"
                ></v-text-field>
              </v-flex>
            </v-layout>

          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey darken-3" text
                   @click.stop="() => {requisits_dialog = confirmation = requisits_of = false,getItem()}">Отменить
            </v-btn>
            <v-btn color="primary" large type="submit" :loading="action_loading" class="px-6">
              {{ confirmation ? 'Сохранить и перейти к подписанию' : 'Сохранить' }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>



    <v-dialog persistent v-model="upload_file_dialog" max-width="640px" min-height="480px">
      <v-card color="#f6f6f6">
        <v-card-title>
          Загрузка документов
        </v-card-title>
        <v-card-text>
           Допустимые форматы файлов: PDF, JPG, PNG. Размер одновременно загружаемых файлов не должен превышать 6Мб.
        </v-card-text>
        <v-card-text>
      <v-file-input
        accept=".pdf, .jpg, .jpeg, .png"
            label="Выберите файлы для загрузки"
            prepend-icon="mdi-scanner"
            multiple chips
            v-model="auctionFiles"
            @change="addAuctionFiles"></v-file-input>
      <layout
      class="d-flex flex-wrap align-stretch"
      flat
      color="trasparent"
      >
        <v-card v-for="(file,f) in auctionFiles" :key="f"
          class="pa-2 mr-1 mb-1 d-flex align-center justify-center"
        width="100px"
        min-height="120px"
        >
        <div class="d-flex flex-wrap align-center justify-center mb-4" v-if="!file.name.match(/\.pdf$/)"><img :ref="'file'" width="100%" :title="file.name" /><div class="filesize">{{ formatFilesize(file.size) }}</div></div>
        <div class="d-flex flex-wrap align-center justify-center mb-4" v-else><div :ref="'file'" ><img src="/img/pdf.png" width="64px" style="margin:auto;" :title="file.name" /></div><div class="filesize">{{ formatFilesize(file.size) }}</div></div>
        </v-card>
      </layout>
    </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="cancelAuctionFiles">Отменить</v-btn>
          <v-btn color="primary" large @click.stop="saveAuctionFiles">Сохранить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>



    <snackbar/>
  </v-app>
</template>
<script>
import lang_menu from '../lang_menu'
import snackbar from '../snackbar'
import editdialog from '../editdialog'
import tabledialog from '../tabledialog'
import confirmdialog from '../confirmdialog'
import AdminPanel from '../snippets/AdminPanel'
import DateLogger from '../snippets/DateLogger'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton';

import rates from './rates'
import tabs from '../tabs'
import winner from '../winner'
import delivery_regions_data from '../constants/delivery_regions_data.js'
import payment_conditions_data from '../constants/payment_conditions_data.js'

export default {
  name: 'new_tender_card',
  data() {
    return {
      dialog: false,

      item: {

      titles: [
          {
            title: '',
            active_material: false,
            is_analog: '',
            exclude_analogs: '',
            size: '',
            unit:'',
          },
        ],
               
        title: '',
        active_material: false,
        is_analog: '',
        exclude_analogs: '',
        size: '',
        unit:'',        



        over_date: '',
        delivery_date: '',

        user: false,
        rate_type: 'free',
        customer_inn: '',

        customer_ogrn: '',
        customer_bank_account: '',
        customer_correspondent_account: '',
        customer_bank_bik: '',
        customer_warehouse_address: '',
        supplier_inn: '',
        supplier_ogrn: '',
        supplier_bank_account: '',
        supplier_correspondent_account: '',
        supplier_bank_bik: '',
        supplier_warehouse_address: '',
        
      },
      new_flag: false,
      check_time: false,
      customerDialog: false,
      phone_rules: [
        v => !!v || __('forms.required_field'),
        v => v.length == 18 || __('forms.phone_error'),
      ],
      rules: [
        v => !!v || __('forms.required_field'),
      ],
      email_rules: [
        v => !!v || __('forms.required_field'),
        v => /.+@.+/.test(v) || __('forms.email_error'),
      ],
      ogrn_rules: [
        v => !!v || __('forms.required_field'),
        v => /^[0-9]{13}([0-9]{2})?$/.test(v) || 'ОГРН/ОГРНИП введен неверно',
      ],
      account_rules: [
        v => !!v || __('forms.required_field'),
        v => /^[0-9]{20}$/.test(v) || 'Счет введен неверно',
      ],
      bik_rules: [
        v => !!v || __('forms.required_field'),
        v => /^[0-9]{9}$/.test(v) || 'БИК введен неверно',
      ],
      action_loading: false,
      rate_step_option: null,
      rate_type_options: [
        {id: 'free', title: 'Участники устанавливают цену произвольно'},
        {id: 'step', title: 'Участники устанавливают цену с фиксированным шагом'},
      ],
      cancel_dialog: false,
      close_dialog: false,
      prefix: '',
      file_loading: false,
      file: '',
      units: [
        {id: 'л.', title: 'Литр'},
        {id: 'кг.', title: 'Килограмм'},
      ],
      delivery_conditions: [
        {id: 1, title: 'Со склада поставщика'},
        {id: 2, title: 'Поставка на мой склад'},
        {id: 3, title: 'Транспортной компанией до терминала'},
      ],
      payment_conditions: payment_conditions_data.payment_conditions_data,
      delivery_regions: delivery_regions_data.delivery_regions_data,
      download_loading: false,
      confirm_type: null,
      confirm_dialog: false,
      title: false,
      title_options: this.getTitleOptions(),
      v_select_title_options: [],
      title_options2: this.getTitleOptions2(),
	    v_select_title_options2: [],
      requisits_dialog: false,
      valid: false,
      requisits_of: false,
      confirmation: false,
      analog_options: [],
      upload_file_dialog: false,
     
      
      auctionFiles: [],
      readers: [],  

      tender_created: false,
    }   
  },
  props: {
    user_id: Number,
    new: Boolean,
    type: String,
  },
  components: {
    FieldAccess,
    FieldAccessButton,
    FieldAccessReloginButton,
    editdialog,
    confirmdialog,
    snackbar,
    lang_menu,
    AdminPanel,
    DateLogger,
    tabledialog,
    tabs,
    rates,
    winner
  },
  mounted() {
    if (this.new === false) {
      this.loading = true;
      this.$store.dispatch('GET_AUTH_USER', {id: this.user_id}).then(res => {
      this.getItem();
      });     
    }
    this.getUserInfo();   
    
  },
  methods: {

    //160323
    submitTenders() {
      this.new_flag = false     
      this.item._lang = this.locale
      this.item.auction_user_id = this.user_id
      this.item.type = this.type
      this.submitTendersFor();
    },

    async submitTendersFor() {
      for (const itemTitle of this.item.titles) {
      await this.submitTenderItem(itemTitle);
      }       
    },

    submitTenderItem(itemTitle) {
        this.loading = true
        this.item.title=itemTitle.title
        this.item.active_material=itemTitle.active_material
        this.item.is_analog=itemTitle.is_analog
        this.item.exclude_analogs=itemTitle.exclude_analogs
        this.item.size=itemTitle.size
        this.item.unit=itemTitle.unit
        if (this.checkFields()) {    
        axios.post('/admin/auction/edit', this.item).then(res => {
             if (res.status == 200) {                
                   //130223 загрузка файлов тендера
                  if (this.auctionFiles.length > 0 && res.data.auction.id !== undefined && res.data.auction.id > 0) {
                    this.loadAuctionFiles(res.data.auction.id);
                  }
                  alert("Тендер " + itemTitle.title + " создан успешно");
                  this.tender_created = true;
             }   
        })
        }
        this.loading = false
    },

    //140323
    titleAdd() {
      this.item.titles.push(
      {
      title: '',
      active_material: false,
      is_analog: '',
      exclude_analogs: '',
      size: '',
      unit: '',
      } 
      )
    },

    //090223
    openUploadDialog() {     
      this.upload_file_dialog = true
    },

    //130223
    addAuctionFiles() {     
      this.auctionFiles.forEach((file, f) => {
        this.readers[f] = new FileReader();
        this.readers[f].onloadend = (e) => {
          let fileData = this.readers[f].result
          let imgRef = this.$refs.file[f]
          imgRef.src = fileData
        }
        this.readers[f].readAsDataURL(this.auctionFiles[f]);
      })
    },

    //130223
    cancelAuctionFiles() {
      this.auctionFiles = [],
      this.upload_file_dialog = false 
    },

    //130223
    saveAuctionFiles() {
      this.upload_file_dialog = false
    },

    //130223
    loadAuctionFiles(auction_id) {
      if (this.auctionFiles.length == 0) return;
      this.action_loading = true
      let form = new FormData();
      this.auctionFiles.forEach((file, f) => {
        form.append('filenames[]', file)
      })
       form.append('auction_id', auction_id)
      this.$store.dispatch('ADD_DOC_FILE', form).then(res => {
      this.action_loading = false
      })
        .catch(error => {
      this.$store.commit('SET_SNACKBAR', error)
      this.action_loading = false
      })
    },

    //260822
    getAnalogOptions() {
      let title = this.item.title;
        if (title !== undefined) {
        axios.post('/admin/configer/analog_drugs', { title: title }).then(res => {
        if (res.data.drugs !== undefined) {
          this.analog_options = res.data.drugs
        }
       })
      }
    },

    //170522
    getUserInfo() {
      axios.post('/admin/users/get_info', { id: this.user_id }).then(res => {
        if (res.data.user.company_warehouse_address !== undefined) {
          this.item.customer_warehouse_address = res.data.user.company_warehouse_address
        }
       })
    },

    confirm(val) {
      this.confirm_type = val
      this.confirm_dialog = true
      this.requisits_dialog = false
      this.confirmation = false
    },
    requisits(type, confirmation) {
      if (type != 'customer' && type != 'supplier') return
      this.requisits_of = type
      this.requisits_dialog = true
      if (this.$refs.formRequisits) this.$refs.formRequisits.resetValidation()
      this.confirmation = confirmation || false
    },

    checkRequisits() {
      var flag = true
      if (this.requisits_of != 'supplier') {
        if (!this.item.customer_ogrn || !this.item.customer_ogrn.match(/^[0-9]{13,15}$/)) flag = false
        if (!this.item.customer_bank_account || !this.item.customer_bank_account.match(/^[0-9]{20}$/)) flag = false
        if (!this.item.customer_correspondent_account || !this.item.customer_correspondent_account.match(/^[0-9]{20}$/)) flag = false
        if (!this.item.customer_bank_bik || !this.item.customer_bank_bik.match(/^[0-9]{9}$/)) flag = false
        if (this.item.delivery_condition == 2 && !this.item.customer_warehouse_address) flag = false
      } else {
        if (!this.item.supplier_ogrn || !this.item.supplier_ogrn.match(/^[0-9]{13,15}$/)) flag = false
        if (!this.item.supplier_bank_account || !this.item.supplier_bank_account.match(/^[0-9]{20}$/)) flag = false
        if (!this.item.supplier_correspondent_account || !this.item.supplier_correspondent_account.match(/^[0-9]{20}$/)) flag = false
        if (!this.item.supplier_bank_bik || !this.item.supplier_bank_bik.match(/^[0-9]{9}$/)) flag = false
        if (this.item.delivery_condition == 1 && !this.item.supplier_warehouse_address) flag = false
      }
      return flag
    },
    submitRequisits() {
      if (this.valid) {
        if (!this.checkRequisits()) {
          return
        }
        this.submitEdit()
      } else {
        this.$refs.formRequisits.validate()
      }
    },
    setMissedRequisits() {
//		console.log(this.item)
      if (!this.item.customer_ogrn && this.item.user.company_ogrn) {
        this.item.customer_ogrn = this.item.user.company_ogrn
      }
      if (!this.item.customer_bank_account && this.item.user.company_bank_account) {
        this.item.customer_bank_account = this.item.user.company_bank_account
      }
      if (!this.item.customer_correspondent_account && this.item.user.company_correspondent_account) {
        this.item.customer_correspondent_account = this.item.user.company_correspondent_account
      }
      if (!this.item.customer_bank_bik && this.item.user.company_bank_bik) {
        this.item.customer_bank_bik = this.item.user.company_bank_bik
      }
      if (!this.item.customer_warehouse_address && this.item.user.company_warehouse_address) {
        this.item.customer_warehouse_address = this.item.user.company_warehouse_address
      }
      if (this.item.win_rate_id) {
        if (!this.item.supplier_ogrn && this.item.win_rate.user.company_ogrn) {
          this.item.supplier_ogrn = this.item.win_rate.user.company_ogrn
        }
        if (!this.item.supplier_bank_account && this.item.win_rate.user.company_bank_account) {
          this.item.supplier_bank_account = this.item.win_rate.user.company_bank_account
        }
        if (!this.item.supplier_correspondent_account && this.item.win_rate.user.company_correspondent_account) {
          this.item.supplier_correspondent_account = this.item.win_rate.user.company_correspondent_account
        }
        if (!this.item.supplier_bank_bik && this.item.win_rate.user.company_bank_bik) {
          this.item.supplier_bank_bik = this.item.win_rate.user.company_bank_bik
        }
        if (!this.item.supplier_warehouse_address && this.item.win_rate.user.company_warehouse_address) {
          this.item.supplier_warehouse_address = this.item.win_rate.user.company_warehouse_address
        }
      }
    },

    getTitleOptions() {
      axios
          .get("/admin/auction/get_title_options")
          .then(response => this.title_options = response.data)
    },
    getTitleOptions2() {
      let id = this.item_id2;
      axios
	       .get("/admin/auction/get_title_options2/" + id)
		  .then(response => this.title_options2 = response.data)
	  },
    downloadContract() {
      this.download_loading = true
      let params = {}
      params.auction_id = this.item.id
      params.user_id = this.auth_user.id
      axios.post('/admin/auction/get_pdf', params, {responseType: 'arraybuffer'}).then(res => {
        let blob = new Blob([res.data], {type: 'application/pdf'})
        let link = document.createElement('a')
        link.target = '_blank'
        link.href = window.URL.createObjectURL(blob)
        link.open = 'Договор ' + this.item.id + '.pdf'
        link.click()
      })
          .finally(() => (this.download_loading = false))
    },
    previewImage: function (e) {
      var vm = this
      var input = event.target;
      if (input.files && input.files[0]) {
        this.file_loading = true
        var reader = new FileReader();
        reader.onload = (e) => {
          const img = new Image();
          img.onload = function () {
            var MAX_WIDTH = 1200;
            var MAX_HEIGHT = 900;
            var width = img.width;
            var height = img.height;

            if (width > height) {
              if (width > MAX_WIDTH) {
                height *= MAX_WIDTH / width;
                width = MAX_WIDTH;
              }
            } else {
              if (height > MAX_HEIGHT) {
                width *= MAX_HEIGHT / height;
                height = MAX_HEIGHT;
              }
            }
            var canvas = document.createElement("canvas");
            canvas.width = width;
            canvas.height = height;
            canvas.getContext("2d").drawImage(this, 0, 0, width, height);
            vm.file = canvas.toDataURL('image/jpeg');
          }
          img.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
        this.file_loading = false
      }
    },

    closeItem() {
      this.action_loading = true
      this.$store.dispatch('CLOSE_AUCTION', this.item).then(res => {
        this.getItem()
        this.close_dialog = false
      })
          .finally(() => (this.action_loading = false))
    },
    cancelItem() {
      this.action_loading = true
      this.$store.dispatch('CANCEL_AUCTION', this.item).then(res => {
        this.getItem()
        this.cancel_dialog = false
      })
          .finally(() => (this.action_loading = false))
    },
    editItem(field) {
      if (this.new == true) {
        this.new_flag = true
      }
      this.item.field = field
      this.dialog = true
    },
    submit(val) {
      this.item = val
      this.submitEdit()
    },

    submitEdit(confirmation) {
      var vm = this
      if (this.new == true) {
        this.auction = this.item
        this.dialog = false
        this.tabledialog = false
        
      } else {
        if (this.checkFields()) {
          this.new_flag = false
          this.loading = true
          this.item._lang = this.locale
          this.item.auction_user_id = this.user_id
          this.item.type = this.type
          if (this.item.field == undefined || this.item.field.type != 'file') {
            this.$store.dispatch('EDIT_AUCTION', {form: this.item, _lang: this.locale}).then(res => {
              this.deal_date = ''
              this.deal_time = ''
              this.dialog = false
              if (this.item_id > 0) {
                this.getItem();
                if (this.confirmation) this.confirm(this.requisits_of)
              } else {
                if (res.auction.type == 'rise') {
                  if (vm.file != '') {
                    vm.item.id = res.auction.id
                    let form = new FormData()
                    form.append('file', vm.file)
                    form.append('id', vm.item.id)
                    axios.post('/admin/auction/add_photo', form).then(result => {
                      location.href = '/admin/auction/now/card/' + result.data.auction.id
                    })
                  } else {
                    location.href = '/admin/auction/now/card/' + res.auction.id
                  }
                } else if (res.auction.type == 'drop') {

                  //130223 загрузка файлов тендера
                  if (this.auctionFiles.length > 0 && res.auction.id > 0) {
                    this.loadAuctionFiles(res.auction.id);
                  }

                  if (vm.file != '') {
                    vm.item.id = res.auction.id
                    let form = new FormData()
                    form.append('file', vm.file)
                    form.append('id', vm.item.id)
                    axios.post('/admin/auction/add_photo', form).then(result => {
                      location.href = '/admin/tender/now/card/' + result.data.auction.id
                    })
                  } else {
                    location.href = '/admin/tender/now/card/' + res.auction.id
                  }
                }
              }
            })
                .finally(() => {
                  this.loading = false
                  this.requisits_dialog = false
                  this.requisits_of = false
                  this.confirmation = false
                })
          } else {
            let form = new FormData();
            form.append('file', this.item.file)
            form.append('id', this.item.id)
            this.$store.dispatch('EDIT_AUCTION_AVATAR', form).then(res => {
              this.getItem()
            })
                .catch(error => {
                  this.$store.commit('SET_SNACKBAR', error)
                })
          }
        } else {
          this.auction = this.item
          this.dialog = false
          this.tabledialog = false
          this.requisits_dialog = false
          this.requisits_of = false
        }
      }
      this.getActiveMaterial();
    },






    getItem() {
      this.loading = true
      if (this.item_id > 0) {
        let params = {}
        params.id = this.item_id
        params._lang = this.locale
        params.user_id = this.user_id
        this.$store.dispatch('GET_AUCTION', params).then(res => {
          this.dialog = false
          this.action_dialog = false
          this.customerDialog = false
          this.setMissedRequisits()
          
        })
            .finally(() => (this.loading = false))
      } else {
        this.auction.type = this.type
        this.prefix = 'new_'
        this.dialog = false
        this.loading = false
      }
    },
    formatFilesize(size) {
    if (size/1000000000 > 1) return Math.round(size/1000000000)+"Gb"
    if (size/1000000 > 1) return Math.round(size/1000000)+"Mb"
    if (size/1000 > 1) return Math.round(size/1000)+"Kb"
    return size+"Kb"
    },
    formatDate(dateval, val) {
      if (!dateval) return null
      if (val == 'withTime') {
        const [date, time] = dateval.split(' ')
        const [year, month, day] = date.split('-')
        return `${day}.${month}.${year} ${time}`
      } else {
        const [year, month, day] = dateval.split('-')
        return `${day}.${month}.${year}`
      }
    },
    addDateInterval(dateval) {
      if (!dateval) return null
      var date = new Date(dateval);
      date.setDate(date.getDate() + 2);
      return (date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2))
    },
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.title == null) flag = false
        if (this.item.active_material == undefined) flag = false
        if (this.item.is_analog == undefined) flag = false
        if (this.item.size == undefined) flag = false
        if (this.item.unit == undefined) flag = false
        if (this.item.over_date == undefined) flag = false
        if (this.item.delivery_date == undefined) flag = false
        if (this.item.delivery_condition == undefined) flag = false
        if ((this.item.delivery_condition == 2 || this.item.delivery_condition == 3) && this.item.delivery_region == undefined) flag = false
        if (this.item.payment_condition == undefined) flag = false
        if (this.item.delivery_condition == 2 && this.item.customer_warehouse_address == undefined) flag = false
        if (flag === false) {
          this.$store.commit('SET_SNACKBAR', { status: 1, text: "Заполните все обязательные поля"})
        }
        return flag
      } else {
        return true
      }
    },
    formatPrice(value) {
      if (value != null) {
        let val = (value / 1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      } else {
        return '-'
      }
    },



    //160323
    getActiveMaterial() {
      //console.log("getActiveMaterial")
      for (let i = 0; i < this.item.titles.length; i++) {
        for (var option of this.title_options) {
        if (option.title == this.item.titles[i].title) {
          this.item.titles[i].active_material = option.active_material
          break
        } else {
          //this.item.titles[i].active_material = '';
        }
        }
      }
       /*this.item.active_material = false;
      if (obj.title === undefined) return
      for (var option of this.title_options) {
        if (option.title == obj.title) {
          this.item.active_material = option.active_material
          break
        }
      }*/
    }
  },
  created() {
    var vm = this
    window.onbeforeunload =
        function (ev) {
          if (vm.new_flag == true) {
            var is_asked = true;
            var e = ev || window.event;
            window.focus(is_asked);
            if (is_asked) {
              is_asked = false;
              var showstr = "";
              if (e) { //for ie and firefox
                e.returnValue = showstr;
              }
              return showstr; //for safari and chrome
            }
          }
        };
  },
  watch: {
    dialog: function (val) {
      if (val == false) {
        //this.item = Object.assign({}, this.auction)
      }
    },
    auction: function (val) {
      this.item = Object.assign({}, val)
      if (this.item.rate_step == null) this.rate_step_option = 'free'
      else if (this.item.rate_step == null) this.rate_step_option = 'step'
    },
    locale: function (val) {
      this.loading = true
      this.getItem()
    },
    item: function (obj) {
     
      //this.getActiveMaterial(obj);
      this.getAnalogOptions();

    },
    title_options: function (obj) {
      for (var option of obj) {
        this.v_select_title_options.push(option.title)
      }
    },
    title_options2: function (obj) {
		  for (var option of obj) {
			  this.v_select_title_options2.push(option.title)
		  }
	  },
	auth_user (obj) {
		this.item.customer_warehouse_address = this.auth_user.company_warehouse_address
	}
  },
  computed: {
    loading: {
      get() {
        return this.$store.state.loading
      },
      set(val) {
        this.$store.state.loading = val
      }
    },
    auth_user: {
      get() {
        return this.$store.state.auth_user
      }
    },
    item_id: {
      get() {
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length - 1]
        if (item_id > 0) {
          return item_id
        } else if (item_id[item_id.length - 1] == '#') {
          return item_id.slice(0, -1)
        }
      }
    },
    auction: {
      get() {
        return this.$store.state.auction.item
      },
      set(val) {
        this.$store.state.auction.item = val
      }
    },
    locale: {
      get() {
        return this.$store.state.lang.lang
      },
    },
  },
};
</script>
<style>
.vueSelectTender {
  margin-bottom: 2em;
  background: #f0f0f0;
}

.vueSelectTender .vs__search::placeholder, .vueSelectTender .vs__dropdown-toggle, .vueSelectTender .vs__dropdown-menu {
  padding: .5em;
  border: none;
  border-bottom: 1px solid #999;
}

.vueSelectTender.vs--single.vs--searching:not(.vs--open):not(.vs--loading) .vs__search {
  opacity: 1 !important;
}

.v-sheet .v-list-item {
  min-height: 38px;
}


.admin-rek-items {
  max-width: 200px;
}

.admin-rek-banner {
  width: 200px;
  display: block;
  float: left;
  margin: 0 0 20px 0;
}

.titles-divider {
  width: 100%;
  height: 30px;
  background: #ccc;
}
</style>
