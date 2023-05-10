<template>
    <v-app id="vue_block" style="min-height: 100vh;">
        <v-app-bar app color="primary" dark :elevation="1" height="56" id="header-bar">
            <v-toolbar-items>
                <v-menu transition="slide-y-transition" bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-list-item link v-bind="attrs" v-on="on">
                            <v-list-item-icon class="mr-4"><v-icon>mdi-account</v-icon></v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>OPC - {{auth_user.code_opc}}</v-list-item-title>
                                <v-list-item-subtitle v-if="auth_user.subdivision != undefined">{{auth_user.subdivision.name}}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                    <v-list>
                      <v-list-item v-if="auth_user.promoter != undefined">
                        <v-list-item-avatar>
                            <v-img v-if="auth_user.promoter.directory_firm.profile_photo == null" src='/storage/avatars/150x150.nophoto.png'></v-img>
                            <v-img v-else :src="'/storage/avatars/150x150.'+auth_user.promoter.directory_firm.profile_photo"></v-img>
                        </v-list-item-avatar>

                      </v-list-item>
                      <v-list-item @click.stop="logOut">
                        <v-list-item-icon class="mr-4"><v-icon>mdi-logout</v-icon></v-list-item-icon>
                        <v-list-item-title>Выход</v-list-item-title>
                      </v-list-item>
                    </v-list>
                </v-menu>
                
            </v-toolbar-items>
            <v-divider class="mx-0 my-0" vertical></v-divider>
            <v-spacer></v-spacer>
            <v-btn color="success" small class="rounded-lg mx-4" :elevation="1" @click.stop="dialog = true" :loading="loading">Сохранить</v-btn>
            <v-divider class="mx-0 my-0" vertical></v-divider>
            <v-btn color="white" icon small class="rounded-lg mx-4" @click.stop="cleardialog = true"><v-icon small>mdi-broom</v-icon></v-btn>
        </v-app-bar>
        <v-main>
            <v-container fluid v-if="auth_user.promoter_id > 0">
                <v-layout row wrap>
                	<v-flex xs12>
						<v-alert
						  :value="snackbar.show"
						  :color="snackbar.status == 1 ? 'green' : 'red'"
						  dark
						  border="bottom"
						  :icon="snackbar.status == 1 ? 'mdi-check' : 'mdi-cancel'"
						  transition="scale-transition"
						  class="mb-0"
						>
						  {{snackbar.text}}
						  <v-btn color="white" icon text small @click.stop="snackbar.show = false" absolute style="top: 12px; right: 12px;"><v-icon size="18">mdi-close</v-icon></v-btn>
						</v-alert>
                	</v-flex>
                	<v-flex xs12>
                		<v-tabs background-color="#fafafa" grow v-model="tab" small dense>
    						<v-tab class="text-capitalize font-weight-bold"><v-icon left size="18">mdi-format-list-bulleted</v-icon>Форма</v-tab>
    						<v-tab class="text-capitalize font-weight-bold"><v-icon left size="18">mdi-history</v-icon>История</v-tab>
  						</v-tabs>
                		<v-divider class="my-0"></v-divider>
                	</v-flex>
                    <v-flex xs12 v-show="tab == 0">
                        <v-stepper v-model="step" vertical style="min-height: calc(100vh-56px);" id="stepper">
                        	<v-card flat color="orange" dark v-if="new_item.id > 0">
                        		<v-card-actions>
                        		 	Редактирование заявки от - {{new_item.created_at}}
                        		 	<v-spacer></v-spacer>
                        		 	<v-btn color="white" text small icon @click.stop="clear"><v-icon size="18">mdi-close</v-icon></v-btn>
                        		</v-card-actions>
                        	</v-card>
                            <!-- ШАГ 1 -->
                            <v-stepper-step editable :complete="step > 1" step="1">
                                <span class="font-weight-bold">Данные о родителе</span>
                                <small v-if="parent_valid" class="green white--text px-1 mt-1">Заполнены все обязательные поля</small>
                                <small v-if="!parent_valid && step > 1" class="red white--text px-1 mt-1">Заполнены не все обязательные поля</small>
                            </v-stepper-step>
                            <v-stepper-content step="1">
                                <v-form v-model="parent_valid" ref="parent_valid" @submit.prevent="goStep(2)">
                                    <v-card color="grey lighten-5" class="rounded-lg pa-4 ma-1 mb-6" :elevation="1">
                                        <span class="mb-1 d-block">Фамилия</span>
                                        <v-text-field name="last_name" solo flat dense backgroundColor="rgb(232, 240, 254)" v-model="new_item.last_name"></v-text-field>
                                        <span class="mb-1 d-block">Имя <span class="red--text ml-1">*</span></span>
                                        <v-text-field name="first_name" solo flat backgroundColor="rgb(232, 240, 254)" v-model="new_item.first_name" required :rules="[rules.required]" dense></v-text-field>
                                        <span class="mb-1 d-block">Отчество <span class="red--text ml-1">*</span></span>
                                        <v-text-field name="middle_name" solo flat backgroundColor="rgb(232, 240, 254)" v-model="new_item.middle_name" required dense :rules="[rules.required]"></v-text-field>
                                        <span class="mb-1 d-block">Номер телефона<span class="red--text ml-1">*</span></span>
                                        <v-text-field name="phone" solo flat backgroundColor="rgb(232, 240, 254)" v-model="new_item.phone" dense required :rules="[rules.required, rules.phone]" v-mask="phonemask"></v-text-field>
                                    </v-card>
                                    <v-btn color="primary" type="submit" class="rounded-lg mx-1 my-1">
                                        Далее
                                    </v-btn>
                                </v-form>
                            </v-stepper-content>
                            <!-- ШАГ 2 -->
                            <v-stepper-step editable :complete="step > 2" step="2">
                                <span class="font-weight-bold">Данные о ребенке</span>
                                <small v-if="child_valid" class="green white--text px-1 mt-1">Заполнены все обязательные поля</small>
                                <small v-if="!child_valid && step > 2" class="red white--text px-1 mt-1">Заполнены не все обязательные поля</small>
                            </v-stepper-step>
                            <v-stepper-content step="2">
                                <v-form v-model="child_valid" ref="child_valid" @submit.prevent="goStep(3)">
                                    <v-card color="grey lighten-5" class="rounded-lg pa-4 ma-1 mb-6" :elevation="1">
                                        <span class="mb-1 d-block">Фамилия ребенка </span>
                                        <v-text-field name="child_last_name" solo flat dense backgroundColor="rgb(232, 240, 254)" v-model="new_item.child_last_name"></v-text-field>
                                        <span class="mb-1 d-block">Имя ребенка<span class="red--text ml-1">*</span></span>
                                        <v-text-field name="child_fisrt_name" solo flat backgroundColor="rgb(232, 240, 254)" v-model="new_item.child_first_name" dense required :rules="[rules.required]"></v-text-field>
                                        <span class="mb-1 d-block">Возраст ребенка<span class="red--text ml-1">*</span></span>
                                        <v-text-field name="age" solo flat backgroundColor="rgb(232, 240, 254)" v-model="new_item.age" required dense type="number" :rules="[rules.required]"></v-text-field>
                                        <span class="mb-1 d-block">Увлечения ребенка </span>
                                        <v-text-field name="child_hobbies" solo flat dense backgroundColor="rgb(232, 240, 254)" v-model="new_item.child_hobbies"></v-text-field>
                                    </v-card>
                                    <v-btn color="primary" type="submit" class="rounded-lg mx-1 my-1">
                                        Далее
                                    </v-btn>
                                    <v-btn text @click="goStep(1)" class="rounded-lg mx-1 my-1">
                                        Назад
                                    </v-btn>
                                </v-form>
                            </v-stepper-content>
                            <!-- ШАГ 3 -->
                            <v-stepper-step editable :complete="step > 3" step="3">
                                <span class="font-weight-bold">Тестирование</span>
                            </v-stepper-step>
                            <v-stepper-content step="3">
                                <v-card color="grey lighten-5" class="rounded-lg pa-4 ma-1 mb-6"  :elevation="1">
                            		<!-- ТЕСТ 1 -->
                                    <v-card class="rounded-lg">
                                      	<v-subheader>Тест #1</v-subheader>
                                      	<v-card-text class="pt-0" v-if="new_item.first_test > 0">
                                      		<v-avatar size="200">
                                      		  	<v-img :src="first_test_items.find(el => el.value == new_item.first_test).img"></v-img>
                                      		</v-avatar>
                                      	</v-card-text>
                                      	<v-card-text class="pt-0" v-else>
                                      		<span class="grey--text text--lighten-2 font-weight-light">Тест не пройден</span>
                                      	</v-card-text>
                                      	<v-card-actions>
	                                      	<v-btn color="success" small outlined class="rounded-lg" @click.stop="show_test(1)">Открыть тест 1</v-btn>
	                                      	<v-spacer></v-spacer>
	                                      	<v-btn v-if="new_item.first_test > 0" color="red darken-1" small icon @click.stop="new_item.first_test = 0"><v-icon size="18">mdi-close</v-icon></v-btn>
                                      	</v-card-actions>
                                    </v-card>

                            		<!-- ТЕСТ 2 -->
                                    <v-card class="rounded-lg my-4">
                                      	<v-subheader>Тест #2</v-subheader>

                                      	<v-card-text class="pt-0" v-if="new_item.second_test > 0">
                                      	  	<v-avatar size="200">
                                      		  	<v-img :src="second_test_items.find(el => el.value == new_item.second_test).img"></v-img>
                                      		</v-avatar>
                                      	</v-card-text>
                                      	<v-card-text class="pt-0" v-else>
                                      		<span class="grey--text text--lighten-2 font-weight-light">Тест не пройден</span>
                                      	</v-card-text>
                                      	<v-card-actions>
	                                      	<v-btn color="success" small outlined class="rounded-lg" @click.stop="show_test(2)">Открыть тест 2</v-btn>
	                                      	<v-spacer></v-spacer>
	                                      	<v-btn v-if="new_item.second_test > 0" color="red darken-1" small icon @click.stop="new_item.second_test = 0"><v-icon size="18">mdi-close</v-icon></v-btn>
                                      	</v-card-actions>
                                    </v-card>

                                    <!-- ТЕСТ 3 -->
                                    <v-card class="rounded-lg my-3">
                                      	<v-subheader>Тест #3</v-subheader>

                                      	<v-card-text class="pt-0" v-if="new_item.third_test.length > 0">
                                      	  	<v-chip v-for="item in new_item.third_test" :key="item" color="green" class="white--text mr-2 rounded-lg">
                                      	  		<v-icon left size="18">mdi-account</v-icon> {{third_test_items[item]}}
                                      	  	</v-chip>
                                      	</v-card-text>
                                      	<v-card-text class="pt-0" v-else>
                                      		<span class="grey--text text--lighten-2 font-weight-light">Тест не пройден</span>
                                      	</v-card-text>
                                      	<v-card-actions>
	                                      	<v-btn color="success" small outlined class="rounded-lg" @click.stop="show_test(3)">Открыть тест 3</v-btn>
	                                      	<v-spacer></v-spacer>
	                                      	<v-btn v-if="new_item.third_test.length > 0" color="red darken-1" small icon @click.stop="new_item.third_test = []"><v-icon size="18">mdi-close</v-icon></v-btn>
                                      	</v-card-actions>
                                    </v-card>
                                </v-card>
                                <v-btn color="primary" @click="goStep(4)" class="rounded-lg mx-1 my-1">Далее</v-btn>
                                <v-btn text @click="goStep(2)" class="rounded-lg mx-1 my-1">Назад</v-btn>
                            </v-stepper-content>
                            <!-- ШАГ 4 -->
                            <v-stepper-step step="4" :complete="step > 4" editable>
                                <span class="font-weight-bold">Фотографии</span>
                            </v-stepper-step>
                            <v-stepper-content step="4">
                                <v-card color="grey lighten-5" class="rounded-lg pa-4 ma-1 mb-6"  :elevation="1">
                                	<v-card flat class="mb-6"  v-if="new_item.id > 0">
                                		<v-card-text>
                                		  Что бы оставить имеющиеся фотографии, оставьте поля пустыми.
                                		</v-card-text>
                                	</v-card>
                                <v-form ref="photo_valid">
                                	<div>
            							<div class="file-upload-form">
            							    <p class="mt-0 mb-1 font-weight-medium">Фотография ребенка 1</p>
            							    <input type="file" @change="previewImage(1, $event)" ref="file_one" accept="image/*">
            							</div>
            							<div class="image-preview my-3" v-if="file_one.length > 0">
            							    <v-img class="preview" :src="file_one" height="200" width="200"></v-img>
            							</div>
        							</div>
        							<v-divider class="my-4"></v-divider>
                                	<div>
            							<div class="file-upload-form">
            							    <p class="mt-0 mb-1 font-weight-medium">Фотография ребенка 2</p>
            							    <input type="file" @change="previewImage(2, $event)" ref="file_one" accept="image/*">
            							</div>
            							<div class="image-preview my-3" v-if="file_two.length > 0">
            							    <v-img class="preview" :src="file_two" height="200" width="200"></v-img>
            							</div>
        							</div>
        							<v-divider class="my-4"></v-divider>
        							<div>
            							<div class="file-upload-form">
            							    <p class="mt-0 mb-1 font-weight-medium">Фотография ребенка 3</p>
            							    <input type="file" @change="previewImage(3, $event)" ref="file_one" accept="image/*">
            							</div>
            							<div class="image-preview my-3" v-if="file_three.length > 0">
            							    <v-img class="preview" :src="file_three" height="200" width="200"></v-img>
            							</div>
        							</div>
        						</v-form>
                                </v-card>
                                <v-btn color="primary" @click="goStep(5)" class="rounded-lg mx-1 my-1">Далее</v-btn>
                                <v-btn text @click="goStep(3)" class="rounded-lg mx-1 my-1">Назад</v-btn>
                            </v-stepper-content>
                            <!-- ШАГ 5 -->
                            <v-stepper-step step="5" :complete="step > 5" editable>
                                <span class="font-weight-bold">Комментарий</span>
                            </v-stepper-step>
                            <v-stepper-content step="5">
                                <v-card color="grey lighten-5" class="rounded-lg pa-4 ma-1 mb-6"  :elevation="1">
                                	<span class="mb-1 d-block">Комментарий</span>
                  					<v-textarea
                    					solo
                    					flat
                    					backgroundColor="rgb(232, 240, 254)"
                    					v-model="new_item.main_comment"
                  					></v-textarea>     
                                </v-card>
                                <v-btn color="success" class="rounded-lg mx-1 my-1" @click.stop="dialog = true" :loading="loading">Сохранить</v-btn>
                                <v-btn text @click="goStep(4)" class="rounded-lg mx-1 my-1">Назад</v-btn>
                            </v-stepper-content>
                        </v-stepper>
                    </v-flex>
                    <v-flex xs12 v-show="tab == 1" style="min-height: calc(100vh-56px);">
                    	<promoter_history :user_id="user_id" :tab="tab" @edit="editItem"/>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    	<v-bottom-sheet v-model="test_dialog" scrollable inset max-width="480px;">
      	<v-card style="border-top-left-radius: 16px !important; border-top-right-radius: 16px !important;" v-if="test_dialog">
      	<v-card-title style="border-top-left-radius: 16px !important; border-top-right-radius: 16px !important; background: #fcfcfc;">
      	  Тест №{{test}}
      	  <v-spacer></v-spacer>
      	  <v-btn color="grey darken-3" icon  @click.stop="test_dialog = false"><v-icon>mdi-chevron-down</v-icon></v-btn>
      	</v-card-title>
      	<v-divider class="my-0"></v-divider>
      	<v-card-text style="max-height: 85vh;">
      		<v-item-group v-if="test == 1">
      			<v-layout row wrap>
      	  			<v-flex md6 xs12 v-for="item in first_test_items" :key="item.value">
      	  				<v-card
      	  					:color="new_item.first_test == item.value ? 'green' : ''"
      	  					:elevation="new_item.first_test == item.value ? 4 : 0"
      	  					outlined
      	  					class="ma-4 rounded-lg"
      	  				>
      	  					<v-img
      	  						:src="item.img"
      	  						@click="firstTest(item)"
      	  						class="rounded-lg"
      	  					>
      	  					</v-img>
      	  				</v-card>
      	  			</v-flex>
      			</v-layout>
      	  	</v-item-group>
      		<v-item-group v-else-if="test == 2">
      			<v-layout row wrap>
      				<v-flex md6 xs12 v-for="item in second_test_items" :key="item.value">
      	  				<v-card
      	  					:color="new_item.second_test == item.value ? 'green' : ''"
      	  					:elevation="active ? 4 : 0"
      	  					outlined
      	  					class="ma-4 rounded-lg"
      	  				>
      	  					<v-img
      	  						:src="item.img"
      	  						@click="secondTest(item)"
      	  						class="rounded-lg"
      	  					>
      	  					</v-img>
      	  				</v-card>
      	  			</v-flex>
      			</v-layout>
      	  	</v-item-group>
      	  	<v-item-group v-else-if="test == 3">
      			<v-layout row wrap>
      				<v-flex xs12>
      	  				<v-img
      	  					src="/images/tests/third/1.jpg"
      	  					class="rounded-lg"
      	  				>
      	  				</v-img>
      	  			</v-flex>
      			</v-layout>
      	  	</v-item-group>
      	</v-card-text>
      	<v-divider class="my-0"></v-divider>
      	<v-card-actions style="background: #fcfcfc;">
      	 	<v-btn v-if="test == 1" color="success" block :disabled="!(new_item.first_test > 0)" large class="rounded-lg" @click.stop="test_dialog = false">Ответ {{new_item.first_test || ''}}</v-btn>
      	 	<v-btn v-else-if="test == 2" color="success" block :disabled="!(new_item.second_test > 0)" large class="rounded-lg" @click.stop="test_dialog = false">Ответ {{new_item.second_test || ''}}</v-btn>
      	 	<v-chip-group column active-class="green white--text" v-else-if="test == 3" multiple v-model="new_item.third_test">
          		<v-chip
          		  v-for="tag in third_test_items"
          		  :key="tag"
          		  filter
          		  class="rounded-lg"
          		  @input="checkThirdTest"
          		>
          		  {{ tag }}
          		</v-chip>
        	</v-chip-group>
        	<v-btn color="success" @click.stop="test_dialog = false" class="rounded-lg">Выбрать</v-btn>
      	</v-card-actions>
      </v-card>
    </v-bottom-sheet>
    <v-dialog v-model="cleardialog" max-width="380px">
		<v-card>
			<v-card-title>Очистить заявку</v-card-title>
			<v-card-text>Подтвердить очистку полей заявки</v-card-text>
			<v-card-actions>
				<v-spacer></v-spacer>
				<v-btn color="primary" text small @click.stop="cleardialog = false">Отмена</v-btn>
				<v-btn color="primary" text small @click.stop="clear">Подтвердить</v-btn>
			</v-card-actions>
		</v-card>      
    </v-dialog>
    <v-dialog v-model="dialog" max-width="380px">
		<v-card>
			<v-card-title>Сохранить заявку</v-card-title>
			<v-card-text>Подтвердить сохранение заявки</v-card-text>
			<v-card-actions>
				<v-spacer></v-spacer>
				<v-btn color="primary" text small @click.stop="dialog = false">Отмена</v-btn>
				<v-btn color="primary" text small @click.stop="submit" :loading="loading">Подтвердить</v-btn>
			</v-card-actions>
		</v-card>      
    </v-dialog>
    </v-app>
</template>
<script>

import * as easings from 'vuetify/es5/services/goto/easing-patterns'
import { mask } from 'vue-the-mask'
import snackbar from '../snackbar'
import promoter_history from './history'

export default {
    data() {
        return {
            step: 1,
            cleardialog: false,
            imageData: '',
            parent_valid: false,
            child_valid: false,
            valid: false,
            new_item: {
            	created_at: '',
                last_name: '',
                first_name: '',
                middle_name: '',
                phone: '',
                age: '',
                child_last_name: '',
                child_fisrt_name: '',
                child_age: '',
                first_test: '',
                second_test: '',
                third_test: [],
                main_comment: '',
                phone: '',
            },
            file_one: '',
            file_two: '',
            file_three: '',
            file_loading: 0,
            first_test_items: [
                { value: 1, text: 'Дерево 1', img: '/images/tests/first/1.jpg' },
                { value: 2, text: 'Дерево 2', img: '/images/tests/first/2.jpg' },
                { value: 3, text: 'Дерево 3', img: '/images/tests/first/3.jpg' },
                { value: 4, text: 'Дерево 4', img: '/images/tests/first/4.jpg' },
                { value: 5, text: 'Дерево 5', img: '/images/tests/first/5.jpg' },
            ],
            second_test_items: [
                { value: 1, text: 'Картинка 1', img: '/images/tests/second/1.jpg' },
                { value: 2, text: 'Картинка 2', img: '/images/tests/second/2.jpg' },
                { value: 3, text: 'Картинка 3', img: '/images/tests/second/3.jpg' },
                { value: 4, text: 'Картинка 4', img: '/images/tests/second/4.jpg' },
                { value: 5, text: 'Картинка 5', img: '/images/tests/second/5.jpg' },
                { value: 6, text: 'Картинка 6', img: '/images/tests/second/6.jpg' },
            ],
            third_test_items: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
            phonemask: '+7 (###) ###-##-##',
            rules: {
                required: value => !!value || 'Поле обязательно',
                phone: value => value.length == 18 || 'Не правильный номер',
                avatar: value => !value || value.size < 5000000 || 'Размер изображения не должен превышать 5МБ'
            },
            loading: false,
            duration: 300,
            offset: 0,
            easing: 'easeInOutCubic',
            easings: Object.keys(easings),
            test_dialog: false,
            test: 1,
            dialog: false,
            snackbar: {
            	show: false,
            	text: '',
            	status: '',
            },
            tab: 0,
        }
    },
    mounted() {
        this.$store.dispatch("GET_AUTH_USER", { id: this.user_id })
    },
    components: { snackbar, promoter_history },
    directives: { mask },
    methods: {
        logOut() {
            this.$store.dispatch('EXIT_GO').then(res => {
                window.location = '/go'
            })
        },
    	editItem(item) {
    		this.tab = 0
    		this.new_item = {
    			id: item.id,
    			last_name: item.customer_last_name,
                first_name: item.customer_first_name,
                middle_name: item.customer_middle_name,
                child_hobbies: item.customer.child_hobbies,
                created_at: item.created_at,
                phone: item.customer_main_phone,
                age: item.customer_age,
                child_last_name: item.customer_child_last_name,
                child_first_name: item.customer_child_first_name,
                first_test: item.first_test,
                second_test: item.second_test,
                third_test: item.third_test || [],
                main_comment: item.main_comment,
    		}
    	},
    	checkThirdTest() {
    		if (this.new_item.third_test.length <= 2) return
    		else this.new_item.third_test.splice(0, 1)
    	},
    	previewImage: function(val, e) {
    		var vm = this
            var input = event.target;
            if (input.files && input.files[0]) {
            	this.file_loading = val
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
            			if (val == 1) vm.file_one = canvas.toDataURL('image/jpeg');
            			if (val == 2) vm.file_two = canvas.toDataURL('image/jpeg');
            			if (val == 3) vm.file_three = canvas.toDataURL('image/jpeg');
                	}
                	img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        },
        goStep(val) {
            this.step = val
        },
        firstTest(item) {
        	if (this.new_item.first_test == item.value) this.new_item.first_test = 0
        	else this.new_item.first_test = item.value
        },
    	secondTest(item) {
        	if (this.new_item.second_test == item.value) this.new_item.second_test = 0
        	else this.new_item.second_test = item.value
        },
        selectThirdTest(val) {
            if (this.new_item.third_test.indexOf(val) == -1) {
                if (this.new_item.third_test.length > 1) {
                    this.new_item.third_test.splice(0, 1)
                    this.new_item.third_test.push(val)
                } else {
                    this.new_item.third_test.push(val)
                }
            } else {
                this.new_item.third_test.splice(this.new_item.third_test.indexOf(val), 1)
            }
        },
        show_test(val) {
            this.test = val
            this.test_dialog = true
        },
        clear() {
        	this.new_item = {
               	last_name: '',
               	first_name: '',
               	middle_name: '',
               	phone: '',
               	age: '',
               	child_last_name: '',
               	child_fisrt_name: '',
               	child_hobbies: '',
               	first_test: '',
               	second_test: '',
               	third_test: [],
               	main_comment: '',
            }
            this.file_one = ''
            this.file_two = ''
            this.file_three = ''
            this.step = 1
            this.cleardialog = false
            this.$refs.parent_valid.reset()
            this.$refs.child_valid.reset()
            this.$refs.photo_valid.reset()
        },
        setSnackbar(data) {
        	this.snackbar = data
        	this.snackbar.show = true
        },
        submit() {
            if (this.parent_valid && this.child_valid) {
                this.loading = true
                let form = new FormData()
                if (this.new_item.id > 0) form.append('id', this.new_item.id)
                if (this.file_one != '') form.append('file_one', this.file_one)
                if (this.file_two != '') form.append('file_two', this.file_two)
                if (this.file_three != '') form.append('file_three', this.file_three)
                form.append('promoter_id', this.auth_user.promoter_id)
                if (this.new_item.last_name != undefined) form.append('customer_last_name', this.new_item.last_name)
                if (this.new_item.first_name != undefined) form.append('customer_first_name', this.new_item.first_name)
                if (this.new_item.middle_name != undefined) form.append('customer_middle_name', this.new_item.middle_name)
                form.append('customer_main_phone', this.new_item.phone)
                if (this.new_item.child_last_name != undefined) form.append('customer_child_last_name', this.new_item.child_last_name)
                if (this.new_item.child_first_name != undefined) form.append('customer_child_first_name', this.new_item.child_first_name)
                form.append('customer_child_hobbies', this.new_item.child_hobbies)
                form.append('customer_age', this.new_item.age)
                form.append('first_test', this.new_item.first_test)
                form.append('second_test', this.new_item.second_test)
                if (this.new_item.third_test.length > 1) {form.append('third_test', [this.new_item.third_test[0]+1, this.new_item.third_test[1]+1])}
                form.append('main_comment', this.new_item.main_comment)
                form.append('user_id', this.user_id)
                form.append('_lang', this.locale)
                this.$store.dispatch('EDIT_REQUESTER', { form: form, _lang: this.locale }).then(res => {
                	let params = { status: res.status, text: res.text, show: true }
            		this.setSnackbar(params)
                	this.new_item = {
                		last_name: '',
                		first_name: '',
                		middle_name: '',
                		phone: '',
                		age: '',
                		child_last_name: '',
                		child_fisrt_name: '',
                		child_hobbies: '',
                		first_test: '',
                		second_test: '',
                		third_test: [],
                		main_comment: '',
                	}
            		this.file_one = ''
            		this.file_two = ''
            		this.file_three = ''
                	this.step = 1
                	this.dialog = false
                	this.$refs.parent_valid.reset()
                	this.$refs.child_valid.reset()
                	this.$refs.photo_valid.reset()
                })
                .finally(() => (this.loading = false))
            } else {
            	let params = { status: 0, text: '', show: true }
                if (!this.parent_valid) {
                	this.$refs.parent_valid.validate()
                	this.step = 1
                }
                else if (!this.child_valid) {
                	this.$refs.child_valid.validate()
                	this.step = 2
                }
                params.text = 'Не заполнены обязательные поля'
            	this.dialog = false
            	this.setSnackbar(params)
            }
        }
    },
    props: {
        user_id: Number,
    },
    watch: {},
    computed: {
        auth_user: {
            get() { return this.$store.state.auth_user }
        },
        locale: {
            get() {
                return this.$store.state.lang.lang
            },
        },
        options() {
            return {
                duration: this.duration,
                offset: this.offset,
                easing: this.easing,
            }
        },
    },
};
</script>
<style lang="scss">
#stepper {
	min-height: calc(100vh - 105px) !important;
}
.v-input__slot {
    border: 1px solid #ddd !important;
    border-radius: 4px !important;
}

.test-item {
    padding: 2px;
    &.active {
        background: #333;
    }
}
</style>