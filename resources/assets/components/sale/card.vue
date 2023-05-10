<template>
  <v-app id="vue_block">
    <v-container fluid grid-list-xl class="px-0 py-0" v-if="auction !== undefined">
      <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
        <AdminPanel v-if="accessData.canAdmin" class="mb-3" :loading="loading"/>
      </FieldAccess>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card flat outlined class="mb-4">
            <v-card-title>
              <span v-if="auction.id > 0">Распродажа №{{auction.id}}</span>
              <span v-else>Новая распродажа</span>
            </v-card-title>

            <v-list subheader>


			  <FieldAccess :model="prefix+'auction'" field="title" field_name="Наименование препарата" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Наименование препарата</v-list-item-subtitle>
                    <p class="my-0">{{ item.title || '-' }}</p>
                  </v-list-item-content>

                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Наименование средства', val: 'title', type: 'v-select', options: v_select_title_options })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
                <v-list-item>
                  <v-list-item-content style="padding-top:0;">
                    <v-list-item-subtitle>Действующее вещество</v-list-item-subtitle>
                    <p class="my-0">{{ item.active_material || '-' }}</p>
                  </v-list-item-content>
                </v-list-item>
              </FieldAccess>

        <FieldAccess :model="prefix+'auction'" field="start_price" field_name="Стартовая цена" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Стартовая цена (₽)</v-list-item-subtitle>
                    <p class="my-0">{{ item.start_price || '0' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Стартовая цена', val: 'start_price', type: 'number' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>



              <FieldAccess :model="prefix+'auction'" field="size" field_name="Объем" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Объем</v-list-item-subtitle>
                    <p class="my-0">{{ item.size || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Объем', val: 'size', type: 'number' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="unit" field_name="Единица измерения" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Единица измерения</v-list-item-subtitle>
                    <p class="my-0">{{ item.unit || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Единица измерения', val: 'unit', type: 'select', options: units })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>


              <FieldAccess :model="prefix+'auction'" field="over_date" field_name="Дата окончания распродажи" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Дата окончания распродажи</v-list-item-subtitle>
                    <p class="my-0">{{ formatDate(item.over_date) || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Дата окончания', val: 'over_date', type: 'date' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="delivery_date" field_name="Дата поставки" v-slot="{ accessData }" >
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Дата поставки</v-list-item-subtitle>
                    <p class="my-0">{{ formatDate(item.delivery_date) || '-' }}
					  <v-tooltip top v-if="auction.id > 0 && item.deliv_interval < 4">
					    <template v-slot:activator="{ on }">
						  <v-icon size="18" color="orange" v-on="on">mdi-truck-fast</v-icon>
					    </template>
					    <span class="caption">Менее 3-х дней на доставку</span>
					  </v-tooltip>
					</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn :disabled="item.over_date == undefined" color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Дата поставки', val: 'delivery_date', type: 'date', min_date: addDateInterval(item.over_date) })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="delivery_condition" field_name="Условия поставки" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Условия поставки</v-list-item-subtitle>
                    <p class="my-0" v-if="delivery_conditions.find(el => el.id == auction.delivery_condition) != undefined">{{ delivery_conditions.find(el => el.id == auction.delivery_condition).title }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Условия поставки', val: 'delivery_condition', type: 'select', options: delivery_conditions })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

			  <FieldAccess :model="prefix+'auction'" field="delivery_region" field_name="Регион отгрузки" v-slot="{ accessData }" :style="auction.delivery_condition == 1 || auction.delivery_condition == 3? 'display:block;':'display:none;'">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Регион отгрузки</v-list-item-subtitle>
                    <p class="my-0" v-if="delivery_regions.find(el => el.id == auction.delivery_region) != undefined">{{ delivery_regions.find(el => el.id == auction.delivery_region).title }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Регион отгрузки', val: 'delivery_region', type: 'r-select', options: delivery_regions })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>



              <FieldAccess :model="prefix+'auction'" field="customer_warehouse_address" field_name="Адрес склада" v-slot="{ accessData }" :style="auction.delivery_condition == 1? 'display:block;':'display:none;'">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Адрес склада</v-list-item-subtitle>
                    <p class="my-0">{{ item.customer_warehouse_address || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Адрес склада', val: 'customer_warehouse_address', type: 'text' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="payment_condition" field_name="Условия оплаты" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Условия оплаты</v-list-item-subtitle>
                    <!--<p class="my-0" v-if="payment_conditions.find(el => el.id == auction.payment_condition) != undefined">{{ payment_conditions.find(el => el.id == auction.payment_condition).title }}</p>-->
                    <p class="my-0" v-if="auction.payment_condition">
                      {{ auction.payment_condition }}</p>
                    <p class="my-0" v-else>-</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Условия оплаты', val: 'payment_condition', type: 'u-select', options: payment_conditions })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <FieldAccess :model="prefix+'auction'" field="special_terms" field_name="Особые условия" v-slot="{ accessData }">
                <v-divider class="my-0"></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-subtitle>Особые условия</v-list-item-subtitle>
                    <p class="my-0">{{ item.special_terms || '-' }}</p>
                  </v-list-item-content>
                  <v-list-item-icon v-if="accessData.canEdit">
                    <v-tooltip top v-if="!(auction.id > 0) || auth_user.role_id == 1000">
                      <template v-slot:activator="{ on }">
                        <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem({ text: 'Особые условия', val: 'special_terms', type: 'textarea' })"><v-icon>mdi-sync</v-icon></v-btn>
                      </template>
                      <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                    </v-tooltip>
                    <FieldAccessButton :accessData="accessData" />
                  </v-list-item-icon>
                </v-list-item>
              </FieldAccess>

              <template v-if="!(auction.id > 0)">
                <FieldAccess :model="'auction'"  field="create" field_name="Создать" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item>
                    <v-list-item-content class="text-center">
                      <v-list-item-subtitle class="text-center">
                        <v-btn
                          depressed
                          color="success"
                          @click.stop="submitNew"
                          text
                          class="rounded-btn"
                          :loading="loading"
                        >
                          <v-icon left size="20">mdi-plus</v-icon>Добавить распродажу
                        </v-btn>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </template>

              <template v-if="item.id > 0 && item.status == 1 && (auth_user.role_id == 1000 || auth_user.id == item.user_id)">
                <FieldAccess :model="'auction'"  field="cancel" field_name="Отменить" v-slot="{ accessData }">
                  <v-divider class="my-0"></v-divider>
                  <v-list-item>
                    <v-list-item-content class="text-center">
                      <v-list-item-subtitle class="text-center">
                        <v-btn
                          depressed
                          color="red"
                          @click.stop="() => { cancel_dialog = !cancel_dialog, cancel_reason = false }"
                          text
                          class="rounded-btn"
                        >
                          <v-icon left size="20">mdi-cancel</v-icon>Отменить распродажу
                        </v-btn>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                      <FieldAccessButton :accessData="accessData" />
                    </v-list-item-icon>
                  </v-list-item>
                </FieldAccess>
              </template>
            </v-list>
          </v-card>
        </v-flex>
        <v-flex md6 xs12>


          <!-- ЕСЛИ ОТМЕНЕН -->
          <v-alert type="error" v-if="item.status == 0" class="mb-3">
            Распродажа отменена организатором
			<div style="font-size:85%;" v_if="auth_user.role_id == 1000">({{auction.cancel_reason}})</div>
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
                Распродажа завершена
              </v-card-title>
              <v-card-subtitle class="px-0 success--text">
                Окончен {{formatDate(item.over_date)}}г.
              </v-card-subtitle>
              <v-card-text class="px-0 pb-0 success--text" v-if="auth_user.role_id == 1000 || item.win_rate.user.id == auth_user.id || item.user_id == auth_user.id">
                <template v-if="item.customer_confirm == 0 || item.supplier_confirm == 0 || auth_user.role_id == 1000">
                  <p class="mt-0" v-if="item.customer_confirm == 0 && item.supplier_confirm == 0"> Ожидает подтверждения поставщиком и покупателем своих реквизитов.</p>
                  <p class="mt-0" v-if="item.customer_confirm == 1 && item.supplier_confirm == 0"> Реквизиты подтверждены покупателем, ожидает подтверждения поставщиком.</p>
                  <p class="mt-0" v-if="item.customer_confirm == 0 && item.supplier_confirm == 1"> Реквизиты подтверждены поставщиком, ожидает подтверждения покупателем.</p>

				  <p class="mt-0" v-if="item.customer_confirm == 0 || item.supplier_confirm == 0"> Договор станет доступным для распечатки и подписания как только реквизиты будут подтверждены обеими сторонами.</p>

				  <p class="mt-0" v-if="item.customer_confirm == 1 && item.supplier_confirm == 1"> Обе стороны подтвердили свои реквизиты</p>
                  <p class="mt-0" v-if="item.customer_confirm == 1 && item.supplier_confirm == 1"> Пожалуйста, скачайте и распечатайте договор, подпишите его и загрузите подписанные отсканированные страницы договора.</p>

                  <template v-if="item.customer_confirm < 1 && (item.user_id == auth_user.id || auth_user.role_id == 1000)">
				    <v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('customer',1)">Подтвердить реквизиты {{item.user_id != auth_user.id || auth_user.role_id == 1000?' покупателя':''}}</v-btn>
                  </template>
                  <template v-if="item.supplier_confirm < 1 && (item.win_rate.user.id == auth_user.id || auth_user.role_id == 1000)">
                    <v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('supplier',1)">Подтвердить реквизиты {{item.win_rate.user.id != auth_user.id || auth_user.role_id == 1000?' поставщика':''}}</v-btn>
                  </template>
                </template>
                <template v-else-if="item.win_rate.user.id == auth_user.id || item.user_id == auth_user.id">
                  <p class="mt-0">Обе стороны подтвердили свои реквизиты.</p>
                  <p class="mt-0">Пожалуйста, скачайте и распечатайте договор, подпишите его и загрузите подписанные отсканированные страницы договора в карточку тендера используя кнопку «Загрузить подписанный договор».</p>
                </template>
              </v-card-text>
            </v-card>
            <div v-if="item.customer_confirm == 1 && item.supplier_confirm == 1 && (auth_user.role_id == 1000 || item.win_rate.user.id == auth_user.id || item.user_id == auth_user.id)">
              <v-row
                align="center"
              >
                <v-col class="grow">
                  <v-btn color="success" class="my-1 mr-2" @click.stop="downloadContract()" :loading="download_loading">Скачать договор<v-icon right size="20">mdi-download</v-icon></v-btn>
                </v-col>
                <v-spacer></v-spacer>
              </v-row>
				  <v-row
					align="center"
					v-if="auth_user.role_id == 1000"
					>
					<v-col cols="12" md="6">
						<v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('customer')">{{item.user_id != auth_user.id || auth_user.role_id == 1000?' Реквизиты клиента':'Реквизиты'}}</v-btn>
					</v-col>
					<v-spacer></v-spacer>
					<v-col cols="12" md="6">
						<v-btn color="success" class="my-1 mr-2" small @click.stop="requisits('supplier')">{{item.win_rate.user.id != auth_user.id || auth_user.role_id == 1000?' Реквизиты поставщика':'Реквизиты'}}</v-btn>
					</v-col>
				  </v-row>
              <v-divider
                class="my-4 success"
                style="opacity: 0.22"
              ></v-divider>
              <v-row
                align="top"

              >
                <v-col cols="12" md="6">
                  <v-card-subtitle class="px-0 py-1 success--text" v-if="item.customer_contract_files">
                    Подписанный договор покупателя
                  </v-card-subtitle>
                  <v-card-subtitle class="px-0 py-1 success--text" v-else>
				  	<span v-if="item.user_id == auth_user.id">Загрузите свой подписанный договор здесь</span>
				  	<span v-else>Покупатель пока не загрузил договор</span>
                  </v-card-subtitle>
				  <v-layout class="d-flex flex-wrap align-stretch pl-3 pr-3 pb-2">
					  <v-card
					    class="d-flex flex-wrap align-center justify-center mr-2 mb-2 pa-1 contractFileCard"
					    height="90" width="70"
						v-for="(ccfile, i) in item.customer_contract_files"
						v-bind:key="ccfile"
						:style="ccfile.substr(-3) == 'pdf' ? 'background-image: url(\'/img/pdf.png\');' : 'background-image: url(\'/storage/contracts/'+ccfile.slice(0,-4)+'.tumb.jpg\');'"
					  	  @click="downloadUserFile(ccfile)"
					  	  :title="ccfile.substr(5)"
						>
						<v-tooltip top v-if="auth_user.role_id == 1000">
						  <template v-slot:activator="{ on, attrs }">
					        <v-btn
						      x-small
						      color="red"
						      width="100%"
						      class="contractFileCardBtn"
							  v-bind="attrs"
							  v-on="on"
						      @click.stop="confirmDeleteContract(ccfile)">
						      <v-icon size="18" color="white">mdi-delete</v-icon>
						    </v-btn>
						  </template>
						  <span>Удалить документ</span>
						</v-tooltip>
					  </v-card>
				    <v-tooltip top v-if="auth_user.role_id == 1000 || item.user_id == auth_user.id">
				    <template v-slot:activator="{ on, attrs }">
					  <v-card
					    class="d-flex flex-wrap align-center justify-center mr-2 mb-2 pa-2"
						style="background-color:rgba(255,255,255,.25);"
					    height="90" width="70"
						@click.stop="uploadContract('customer')"
          				v-bind="attrs"
						v-on="on"
						>
						  <v-icon large color="success">mdi-plus-circle-outline</v-icon>
					    </v-card>
					  </template>
					  <span>{{ item.customer_contract_files? 'Загрузить дополнительные страницы': 'Загрузить подписанный договор' }}</span>
					</v-tooltip>
				  </v-layout>

                </v-col>
                <v-spacer></v-spacer>
                <v-col cols="12" md="6">
                  <v-card-subtitle class="px-0 py-1 success--text" v-if="item.supplier_contract_files">
                    Подписанный договор поставщика
                  </v-card-subtitle>
                  <v-card-subtitle class="px-0 py-1 success--text" v-else>
				  	<span v-if="item.win_rate.user.id == auth_user.id">Загрузите свой подписанный договор здесь</span>
				  	<span v-else>Поставщик пока не загрузил договор</span>
                  </v-card-subtitle>
				  <v-layout class="d-flex flex-wrap align-stretch pl-3 pr-3 pb-2">
					  <v-card
					    class="d-flex flex-wrap align-center justify-center mr-2 mb-2 pa-1 contractFileCard"
					    height="90" width="70"
						v-for="(scfile, i) in item.supplier_contract_files"
						v-bind:key="scfile"
						:style="scfile.substr(-3) == 'pdf' ? 'background-image: url(\'/img/pdf.png\');' : 'background-image: url(\'/storage/contracts/'+scfile+'\');'"
					  	  @click="downloadUserFile(scfile)"
					  	  :title="scfile.substr(5)"
						>
						<v-tooltip top v-if="auth_user.role_id == 1000">
						  <template v-slot:activator="{ on, attrs }">
					        <v-btn
						      x-small
						      color="red"
						      width="100%"
						      class="contractFileCardBtn"
							  v-bind="attrs"
							  v-on="on"
						      @click.stop="confirmDeleteContract(scfile)">
						      <v-icon size="18" color="white">mdi-delete</v-icon>
						    </v-btn>
						  </template>
						  <span>Удалить документ</span>
						</v-tooltip>
					  </v-card>
				    <v-tooltip top v-if="auth_user.role_id == 1000 || item.win_rate.user.id == auth_user.id">
				    <template v-slot:activator="{ on, attrs }">
					  <v-card
					    class="d-flex flex-wrap align-center justify-center mr-2 mb-2 pa-2"
						style="background-color:rgba(255,255,255,.25);"
					    height="90" width="70"
						@click.stop="uploadContract('supplier')"
          				v-bind="attrs"
						v-on="on"
						>
						  <v-icon large color="success">mdi-plus-circle-outline</v-icon>
					    </v-card>
					  </template>
					  <span>{{ item.supplier_contract_files? 'Загрузить дополнительные страницы': 'Загрузить подписанный договор' }}</span>
					</v-tooltip>
				  </v-layout>
				</v-col>
              </v-row>
            </div>
          </v-alert>

          <!-- Организатор распродажи -->
          <v-card class="mb-3" flat outlined v-if="item.user != false && (auth_user.role_id == 1000 || auth_user.role_id == 102 || (item.win_rate != undefined && item.win_rate.user.id == auth_user.id))">
            <v-list subheader>
            <v-subheader>Организатор распродажи <v-spacer></v-spacer><v-icon>mdi-city-variant</v-icon></v-subheader>
              <v-list-item three-line>
                <v-list-item-avatar>
                  <v-img
                    :src="item.user.avatar == null ? '/storage/avatars/50x50.nophoto.png' : '/storage/avatars/48x48.'+item.user.avatar">
                  </v-img>
                </v-list-item-avatar>
                <v-list-item-content style="overflow:visible;">
                  <v-list-item-title>{{item.user.company_name}}</v-list-item-title>
                  <v-list-item-subtitle v-if="auth_user.role_id == 1000">{{item.user.email}}</v-list-item-subtitle>
                  <v-list-item-subtitle v-if="auth_user.role_id == 1000">{{item.user.phone}}</v-list-item-subtitle>
                  <v-list-item-subtitle v-if="item.user.company_check_file" style="overflow:visible;">
				    <v-btn elevation="2" x-small class="my-1 success--text" :href="'/storage/proofs/'+item.user.company_check_file" target="_blank"><v-icon size="18" color="success">mdi-check</v-icon><span class="ml-1">Результат проверки пользователя</span></v-btn>
				  </v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-card>

          <winner :item="item" />

          <template v-if="item.id > 0">
            <rates :item="item" @refresh="getItem"  :vselect_titles2="v_select_title_options2" />
            <DateLogger :item="item" :auth_user="auth_user" />
            <messages :auth_user="auth_user" :auction_id="item.id" :user_auction="item.user.id"/>
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
          Вы действительно хотите досрочно окончить распродажу
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="close_dialog = false">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="closeItem" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>






    <v-dialog v-model="cancel_dialog" max-width="420">
      <v-card color="#f6f6f6">
        <v-card-title>
          Подтвердить удаление
        </v-card-title>
        <v-card-text>
          Вы действительно хотите отменить распродажу
        </v-card-text>
        <v-card-text>
            <v-select
			  placeholder="Причина отмены"
              :items="cancel_options"
              v-model="cancel_reason"
			  solo
              flat
              dense
			  menu-props="auto"
              :rules="rules"
            >
            </v-select>
            <v-textarea
			  v-if="this.cancel_reason == 'Другое'"
			  placeholder="Уточните причину"
              solo
              flat
              dense
              v-model="cancel_reason_other"
              auto-grow
              :rules="rules"
            ></v-textarea>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="() => { cancel_dialog = false, action_loading = false }">Отменить</v-btn>
          <v-btn color="grey darken-3" text @click.stop="cancelItem" :loading="action_loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>






    <v-dialog v-model="dialog" max-width="420px">
      <editdialog v-if="dialog" @submit="submitEdit" @close="dialog = !dialog" :item="item"/>
    </v-dialog>





    <v-dialog scrollable v-model="confirm_dialog" max-width="1185px">
      <confirmdialog v-if="confirm_dialog" :item="item" :type="confirm_type" @refresh="getItem" @close="confirm_dialog = false" />
    </v-dialog>








    <v-dialog persistent v-model="requisits_dialog" max-width="640px" v-if="!$props.new">
      <v-form v-model="valid" ref="formRequisits" @submit.prevent="submitRequisits">
      <v-card>
        <v-card-title v-if="auth_user.role_id == 1000">
          Реквизиты {{requisits_of != 'supplier' ? 'покупателя':'поставщика'}}
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
		  <b v-show="requisits_of != 'supplier' && item.delivery_condition == 2">Адрес склада покупателя *</b>
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

		  <v-alert
		  	outlined
		  	type="info"
		  	color="#999"
		  	elevation="0"
		  	v-if="auth_user.role_id != 1000 || confirmation"
		  >
		  	<b>После подтверждения реквизитов вы не сможете внести в них изменения.</b> Для исправления неточностей необходимо будет обращаться к&nbsp;администрации портала.
		  </v-alert>

		  <v-alert
		  	outlined
		  	type="info"
		  	color="#999"
		  	elevation="0"
		  	v-if="auth_user.role_id == 1000 && !confirmation"
		  >
		  	Эта форма, в которой можно внести изменения в реквизиты после их подтверждения {{requisits_of != 'supplier' ? 'покупателем':'поставщиком'}}, доступна только администраторам.
		  </v-alert>

        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="() => {requisits_dialog = confirmation = requisits_of = false,getItem()}">Отменить</v-btn>
		  <v-btn color="primary" large type="submit" :loading="action_loading" class="px-6">{{confirmation?'Подтвердить':'Сохранить'}}</v-btn>
        </v-card-actions>
      </v-card>
	  </v-form>
    </v-dialog>



    <v-dialog persistent v-model="upload_dialog" max-width="640px" min-height="480px">
      <v-card color="#f6f6f6">
        <v-card-title>
          Загрузка договора, подписанного {{ contractType == 'supplier'? 'поставщиком' : 'покупателем' }}
        </v-card-title>
        <v-card-text>
          Пожалуста, отсканируйте и зарузите все страницы договора. Допустимые форматы файлов: PDF, JPG, PNG. Размер одновременно загружаемых файлов не должен превышать 6Мб.
        </v-card-text>
        <v-card-text>
		  <v-file-input
		  	accept=".pdf, .jpg, .jpeg, .png"
            label="Выберите файлы для загрузки"
            prepend-icon="mdi-scanner"
            multiple chips
            v-model="contractFiles"
            @change="addContractFiles"></v-file-input>
		  <layout
			class="d-flex flex-wrap align-stretch"
			flat
			color="trasparent"
		  >
		    <v-card v-for="(file,f) in contractFiles" :key="f"
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
          <v-btn color="grey darken-3" text @click.stop="() => { contractFiles = [], contractType = upload_dialog = action_loading = false }">Отменить</v-btn>
          <v-btn color="primary" large @click.stop="saveContractFiles(contractType)" :loading="action_loading">Сохранить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="delete_contract_dialog" max-width="460">
      <v-card>
        <v-card-title>
          Подтвердите удаление
        </v-card-title>
        <v-card-text>
          Вы действительно хотите удалить загруженный документ <b>«{{delete_contract_file.substr(5)}}»</b>?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-3" text @click.stop="delete_contract_dialog = false">Отменить</v-btn>
          <v-btn color="red darken-2" class="white--text" @click.stop="deleteContractFile" :loading="action_loading">Удалить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
	<snackbar />
  </v-app>
</template>
<style>
.contractFileCard { background: url('/img/pdf.png') center no-repeat; background-size: cover; }
.contractFileCardBtn { opacity:0; position:relative; top:31px; }
.contractFileCard:hover .contractFileCardBtn { opacity:1; }
.filesize { font-size: 80%; position:absolute; bottom:1px; left:8px; color:#999; }
</style>
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
import messages from '../messages/messages'

export default {
  name: 'sale_card',
  data () {
    return {
      dialog: false,
      item: {
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
        cancel_reason: '',
        is_analog: 0,
        start_price: 0,
        user: {
          avatar: null,
        }
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
        { id: 'free', title: 'Участники устанавливают цену произвольно' },
        { id: 'step', title: 'Участники устанавливают цену с фиксированным шагом' },
      ],
      cancel_dialog: false,
	  cancel_options: [
	  /*	'Нашел дешевле',
		'Не нравится / не удобно пользоваться ресурсом',
		'Нашел другой продукт',
		'Отпала потребность в препарате',*/
		'Другое'
	  ],
	  cancel_reason: false,
	  cancel_reason_other: '',
      close_dialog: false,
      prefix: '',
      file_loading: false,
      file: '',
      units: [
        { id: 'л.', title: 'Литр' },
        { id: 'кг.', title: 'Килограмм' },
      ],
      delivery_conditions: [
        { id: 1, title: 'Со склада поставщика' },
       /* { id: 2, title: 'Поставка на мой склад' },*/
        { id: 3, title: 'Транспортной компанией до терминала' },
      ],
      payment_conditions: payment_conditions_data.payment_conditions_data,

	  delivery_regions: delivery_regions_data.delivery_regions_data,

      download_loading: false,
      confirm_type: null,
      confirm_dialog: false,
	  title: false,
	  title_options: [], // this.getTitleOptions()
	  v_select_title_options: [],
    title_options2: [], // this.getTitleOptions2()
	  v_select_title_options2: [],
	  requisits_dialog: false,
	  valid: false,
	  requisits_of: false,
	  confirmation: false,
	  upload_dialog: false,
	  delete_contract_dialog: false,
	  delete_contract_file: '',
	  contractType: false,
      contractFiles: [],
      readers: [],
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
    winner,
    messages,
  },
  mounted() {    
      this.getTitleOptions();
      this.getTitleOptions2();

     if (this.new === false) {
      this.loading = true;
       this.$store.dispatch('GET_AUTH_USER', { id: this.user_id }).then(res => {
        this.getItem() 
      });
    }
  },
  methods: {
    addContractFiles(){
//      console.log('contractFiles', this.contractFiles)
      this.contractFiles.forEach((file, f) => {
        this.readers[f] = new FileReader();
        this.readers[f].onloadend = (e) => {
          let fileData = this.readers[f].result
          let imgRef = this.$refs.file[f]
          imgRef.src = fileData
//          console.log('fileData'+f,fileData)
          // send to server here...
        }

        this.readers[f].readAsDataURL(this.contractFiles[f]);
      })
    },
	formatFilesize(size) {
		if (size/1000000000 > 1) return Math.round(size/1000000000)+"Gb"
		if (size/1000000 > 1) return Math.round(size/1000000)+"Mb"
		if (size/1000 > 1) return Math.round(size/1000)+"Kb"
		return size+"Kb"
	},
	uploadContract(type) {
	  if (type != 'customer' && type != 'supplier') return;
	  this.contractType = type
	  this.upload_dialog = true
	},
	saveContractFiles(type) {
	  if (type != 'customer' && type != 'supplier') return;
	  if (this.contractFiles.length == 0) return;
	  this.action_loading = true
      console.log('files',this.contractFiles)
	  let form = new FormData();
	  this.contractFiles.forEach((file, f) => {
	  	form.append('filenames[]', file)
	  })
      form.append('id', this.item.id)
      form.append('type', type)
      this.$store.dispatch('ADD_CONTRACT_FILE', form).then(res => {
		this.contractFiles = []
		this.contractType = this.upload_dialog = this.action_loading = false
		this.getItem()
	  })
      .catch(error => {
		this.$store.commit('SET_SNACKBAR', error)
		this.action_loading = false
	  })
	},
	confirmDeleteContract(deletefile) {
		this.delete_contract_file = deletefile
		this.delete_contract_dialog = true
	},
	deleteContractFile(deletefile) {
		this.action_loading = true
		let form = new FormData();
        form.append('deletefile', this.delete_contract_file)
        form.append('id', this.item.id)
        this.$store.dispatch('DELETE_CONTRACT_FILE', form).then(res => {
		  this.delete_contract_file = ''
		  this.delete_contract_dialog = false
		  this.action_loading = false
		  this.getItem()
		})
        .catch(error => { this.$store.commit('SET_SNACKBAR', error) })

	},
	confirm(val) {
      this.confirm_type = val
      this.confirm_dialog = true
	  this.requisits_dialog = false
	  this.confirmation = false
    },
    requisits(type,confirmation) {
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
		}
		else {
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
	  }
      else {
        this.$refs.formRequisits.validate()
      }
    },
	setMissedRequisits() {
//		console.log(this.item)
        if (!this.item.customer_ogrn && this.item.user.company_ogrn) { this.item.customer_ogrn = this.item.user.company_ogrn }
        if (!this.item.customer_bank_account && this.item.user.company_bank_account) { this.item.customer_bank_account = this.item.user.company_bank_account }
        if (!this.item.customer_correspondent_account && this.item.user.company_correspondent_account) { this.item.customer_correspondent_account = this.item.user.company_correspondent_account }
        if (!this.item.customer_bank_bik && this.item.user.company_bank_bik) { this.item.customer_bank_bik = this.item.user.company_bank_bik }
        if (!this.item.customer_warehouse_address && this.item.user.company_warehouse_address) { this.item.customer_warehouse_address = this.item.user.company_warehouse_address }
        if (this.item.win_rate_id) {
			if (!this.item.supplier_ogrn && this.item.win_rate.user.company_ogrn) { this.item.supplier_ogrn = this.item.win_rate.user.company_ogrn }
			if (!this.item.supplier_bank_account && this.item.win_rate.user.company_bank_account) { this.item.supplier_bank_account = this.item.win_rate.user.company_bank_account }
			if (!this.item.supplier_correspondent_account && this.item.win_rate.user.company_correspondent_account) { this.item.supplier_correspondent_account = this.item.win_rate.user.company_correspondent_account }
			if (!this.item.supplier_bank_bik && this.item.win_rate.user.company_bank_bik) { this.item.supplier_bank_bik = this.item.win_rate.user.company_bank_bik }
			if (!this.item.supplier_warehouse_address && this.item.win_rate.user.company_warehouse_address) { this.item.supplier_warehouse_address = this.item.win_rate.user.company_warehouse_address }
		}
	},

	getTitleOptions() {
	  axios
	    .get("/admin/auction/get_title_options")
		.then(response => this.title_options = response.data)
    //console.log(this.title_options);
	},
  getTitleOptions2() {
    let url = window.location.href;
    let id = url.split("/");
    id = id.pop();
    axios
	    .get("/admin/auction/get_title_options2/" + id)
		.then(response => this.title_options2 = response.data)
	},
    downloadUserFile(filelink) {
      let link = document.createElement('a')
      link.target = '_blank'
      link.href = '/storage/contracts/'+filelink
        link.open = filelink.substring(5)
      link.click()
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
		link.download = 'Договор поставки №ЭТП-'+this.item.id+'.pdf'
        link.open = 'Договор поставки №ЭТП-'+this.item.id+'.pdf'
        link.click()
      })
      .finally(() => (this.download_loading = false))
    },
    previewImage: function(e) {
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
    submitNew() {
      if (this.checkFields()) {
        this.new = false
        this.submitEdit()
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
	  if (this.cancel_reason == false) return;
	  if (this.cancel_reason == 'Другое' && this.cancel_reason_other.trim() == '') return;
	  this.item.cancel_reason = this.cancel_reason+(this.cancel_reason == 'Другое'? ': '+this.cancel_reason_other.trim() : '' )
      this.action_loading = true
	  this.$store.dispatch('CANCEL_AUCTION', this.item).then(res => {
        this.getItem()
        this.cancel_dialog = false
      })
      .finally(() => (this.action_loading = false))
    },
	editItem(field) {
      if (this.new == true) { this.new_flag = true }
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
      }
      else {
        if (this.checkFields()) {
          this.new_flag = false
          this.loading = true
          this.item._lang = this.locale
          this.item.auction_user_id = this.user_id
          this.item.type = this.type
          if (this.item.field == undefined || this.item.field.type != 'file') {
            this.$store.dispatch('EDIT_AUCTION', { form: this.item, _lang: this.locale }).then(res => {
              this.deal_date = ''
              this.deal_time = ''
              this.dialog = false
              if (this.item_id > 0) {
				if (this.confirmation) {
            	  this.loading = true
            	  let params = {}
            	  params.id = this.item.id
            	  params.type = this.requisits_of
            	  params.user_id = this.auth_user.id
            	  this.$store.dispatch('CONFIRM_AUCTION_CONTRACT', params).then(res => {
            		this.$emit('refresh')
            		this.$emit('close')
            	  })
				  .finally(() => {
				  	this.loading = false
					this.requisits_dialog = false
					this.requisits_of = false
					this.confirmation = false
					this.getItem()
				  })
				}
				else { this.getItem() }
			  }
              else {

                if (res.auction.type == 'rise') {
                  if (vm.file != '') {
                    vm.item.id = res.auction.id
                    let form = new FormData()
                    form.append('file', vm.file)
                    form.append('id', vm.item.id)
                    axios.post('/admin/auction/add_photo', form).then(result => {
                      location.href = '/admin/auction/now/card/'+result.data.auction.id
                    })
                  }
                  else {
                    location.href = '/admin/auction/now/card/'+res.auction.id
                  }
                }

                else if (res.auction.type == 'drop') {
                  if (vm.file != '') {
                    vm.item.id = res.auction.id
                    let form = new FormData()
                    form.append('file', vm.file)
                    form.append('id', vm.item.id)
                    axios.post('/admin/auction/add_photo', form).then(result => {
                      location.href = '/admin/tender/now/card/'+result.data.auction.id
                    })
                  }
                  else {
                    location.href = '/admin/tender/now/card/'+res.auction.id
                  }
                }

                // распродажи
                else if (res.auction.type == 'sale') {
                  if (vm.file != '') {
                    vm.item.id = res.auction.id
                    let form = new FormData()
                    form.append('file', vm.file)
                    form.append('id', vm.item.id)
                    axios.post('/admin/auction/add_photo', form).then(result => {
                      location.href = '/admin/sale/now/card/'+result.data.auction.id
                    })
                  }
                  else {
                    location.href = '/admin/sale/now/card/'+res.auction.id
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
          }
          else {
            let form = new FormData();
            form.append('file', this.item.file)
            form.append('id', this.item.id)
            this.$store.dispatch('EDIT_AUCTION_AVATAR', form).then(res => { this.getItem() })
            .catch(error => { this.$store.commit('SET_SNACKBAR', error) })
          }
        }
        else {
          this.auction = this.item
          this.dialog = false
          this.tabledialog = false
		  this.requisits_dialog = false
		  this.requisits_of = false
        }
      }
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
      }
      else {
        this.auction.type = this.type
        this.prefix = 'new_'
        this.dialog = false
        this.loading = false
      }
    },
    formatDate (dateval, val) {
      if (!dateval) return null
      if (val == 'withTime') {
        const [date, time] = dateval.split(' ')
        const [year, month, day] = date.split('-')
        return `${day}.${month}.${year} ${time}`
      }
      else {
        const [year, month, day] = dateval.split('-')
        return `${day}.${month}.${year}`
      }
    },
	addDateInterval (dateval) {
      if (!dateval) return null
	  var date = new Date(dateval);
      date.setDate(date.getDate());
	  return (date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2))
	},
    checkFields() {
      if (this.new) {
        let flag = true
        if (this.item.title == null) flag = false
        if (this.item.active_material == undefined) flag = false
        if (this.item.is_analog == undefined) flag = false
        if (this.item.start_price == 0) flag = false
        if (this.item.size == undefined) flag = false
        if (this.item.unit == undefined) flag = false
        if (this.item.over_date == undefined) flag = false
        if (this.item.delivery_date == undefined) flag = false
        if (this.item.delivery_condition == undefined) flag = false
        if ((this.item.delivery_condition == 2 || this.item.delivery_condition == 3) && this.item.delivery_region == undefined) flag = false
        if (this.item.payment_condition == undefined) flag = false
        if (this.item.delivery_condition == 2 && this.item.customer_warehouse_address == undefined) flag = false
        return flag
      }
      else {
        return true
      }
    },
    formatPrice(value) {
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '-' }
    },
  },
  created() {
    //console.log(this);
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
      if (val == false) { this.item = Object.assign({}, this.auction) }
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
	/*item: function (obj) {
	    this.item.active_material = false;
		if (obj.title === undefined) return
		for (var option of this.title_options) {
			if (option.title == obj.title) {
				this.item.active_material = option.active_material
				break
			}
		}
	},*/
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
  },
  computed: {
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
    },
    item_id: {
      get() {
        let uri = window.location.href.split('/');
        let item_id = uri[uri.length-1]
        if (item_id > 0) { return item_id }
        else if (item_id[item_id.length-1] == '#') { return item_id.slice(0, -1) }
      }
    },
    auction: {
      get() {         
        if (this.$store.state.auction.item.type === 'sale') return this.$store.state.auction.item
         },
      set(val) { this.$store.state.auction.item = val }
    },
    locale: {
      get() { return this.$store.state.lang.lang },
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
.v-sheet .v-list-item { min-height: 38px; }
</style>
