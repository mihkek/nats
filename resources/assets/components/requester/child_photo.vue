<template>
    <v-card color="transparent" flat>
      <v-card color="transparent" flat class="mb-2">
        <ul class="list-group pl-0 ml-0">
          <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
          <v-list class="py-0" dense>
            <v-list-item class="cardform-list-item pb-2" min-height="48">
              <v-list-item-content class="inline-block" >
                <h4 class="font-weight-bold my-0" v-if="item.id > 0" v-html="__('requester.customer_child_photo')"></h4>
                <h4 class="font-weight-bold my-0" v-else v-html="__('requester.customer_child_photo')"></h4>
              </v-list-item-content>
            </v-list-item>
            <v-divider class="my-0"></v-divider>
            <v-card-text class="cardform-list-item">
                <v-layout row wrap>
                  <v-flex md4 xs6 >
                    <v-hover v-slot:default="{ hover }">
                      <v-card flat tile class="d-flex" v-if="item.customer_photo_one != null">
                        <v-img
                          :src="'/storage/avatars/children/'+item.customer_photo_one"
                          :lazy-src="'/storage/avatars/children/'+item.customer_photo_one"
                          aspect-ratio="1"
                          class="grey lighten-2"
                        >
                          <v-expand-transition>
                            <div 
                              v-if="hover" 
                              class="d-flex transition-fast-in-fast-out v-card--reveal display-3 white--text text-center" 
                              style="background: rgba(0,0,0,0.5);"
                            >
                              <v-btn color="white" class="mx-auto" icon @click.stop="deletePhoto(1)"><v-icon size="18">mdi-delete</v-icon></v-btn>                              
                            </div>
                          </v-expand-transition>
                          <template v-slot:placeholder>
                            <v-row
                              class="fill-height ma-0"
                              align="center"
                              justify="center"
                            >
                              <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
                      </v-card>
                      <v-card flat tile class="d-flex" v-else>
                        <v-img
                          src="/storage/avatars/600x600.nophoto.png"
                          lazy-src="/storage/avatars/600x600.nophoto.png"
                          aspect-ratio="1"
                          class="grey lighten-2"
                        >
                          <v-expand-transition>
                            <div 
                              v-if="hover" 
                              class="d-flex transition-fast-in-fast-out v-card--reveal display-3 white--text text-center" 
                              style="background: rgba(0,0,0,0.5);"
                            >
                              <v-btn color="white" class="mx-auto" icon @click.stop="addPhoto(1)"><v-icon size="18">mdi-plus</v-icon></v-btn>
                            </div>
                          </v-expand-transition>
                        </v-img>
                      </v-card>
                    </v-hover>
                  </v-flex>
                  <v-flex md4 xs6 >
                    <v-hover v-slot:default="{ hover }">
                    <v-card flat tile class="d-flex" v-if="item.customer_photo_two != null">
                      <v-img
                        :src="'/storage/avatars/children/'+item.customer_photo_two"
                        :lazy-src="'/storage/avatars/children/'+item.customer_photo_two"
                        aspect-ratio="1"
                        class="grey lighten-2"
                      >
                        <v-expand-transition>
                          <div 
                            v-if="hover" 
                            class="d-flex transition-fast-in-fast-out v-card--reveal display-3 white--text text-center" 
                            style="background: rgba(0,0,0,0.5);"
                          >
                            <v-btn color="white" class="mx-auto" icon @click.stop="deletePhoto(2)"><v-icon size="18">mdi-delete</v-icon></v-btn>                              
                          </div>
                        </v-expand-transition>
                        <template v-slot:placeholder>
                          <v-row
                            class="fill-height ma-0"
                            align="center"
                            justify="center"
                          >
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                          </v-row>
                        </template>
                      </v-img>
                    </v-card>
                    <v-card flat tile class="d-flex" v-else>
                        <v-img
                          src="/storage/avatars/600x600.nophoto.png"
                          lazy-src="/storage/avatars/600x600.nophoto.png"
                          aspect-ratio="1"
                          class="grey lighten-2"
                        >
                          <v-expand-transition>
                            <div 
                              v-if="hover" 
                              class="d-flex transition-fast-in-fast-out v-card--reveal display-3 white--text text-center" 
                              style="background: rgba(0,0,0,0.5);"
                            >
                              <v-btn color="white" class="mx-auto" icon @click.stop="addPhoto(2)"><v-icon size="18">mdi-plus</v-icon></v-btn>
                            </div>
                          </v-expand-transition>
                        </v-img>
                      </v-card>
                    </v-hover>
                  </v-flex>
                  <v-flex md4 xs6 >
                    <v-hover v-slot:default="{ hover }">
                    <v-card flat outlined class="d-flex" v-if="item.customer_photo_three != null">
                      <v-img
                        :src="'/storage/avatars/children/'+item.customer_photo_three"
                        :lazy-src="'/storage/avatars/children/'+item.customer_photo_three"
                        aspect-ratio="1"
                        class="grey lighten-2"
                      >
                        <v-expand-transition>
                          <div 
                            v-if="hover" 
                            class="d-flex transition-fast-in-fast-out v-card--reveal display-3 white--text text-center" 
                            style="background: rgba(0,0,0,0.5);"
                          >
                            <v-btn color="white" class="mx-auto" icon @click.stop="deletePhoto(3)"><v-icon size="18">mdi-delete</v-icon></v-btn>                              
                          </div>
                        </v-expand-transition>
                        <template v-slot:placeholder>
                          <v-row
                            class="fill-height ma-0"
                            align="center"
                            justify="center"
                          >
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                          </v-row>
                        </template>
                      </v-img>
                    </v-card>
                    <v-card flat tile class="d-flex" v-else>
                        <v-img
                          src="/storage/avatars/600x600.nophoto.png"
                          lazy-src="/storage/avatars/600x600.nophoto.png"
                          aspect-ratio="1"
                          class="grey lighten-2"
                        >
                          <v-expand-transition>
                            <div 
                              v-if="hover" 
                              class="d-flex transition-fast-in-fast-out v-card--reveal display-3 white--text text-center" 
                              style="background: rgba(0,0,0,0.5);"
                            >
                              <v-btn color="white" class="mx-auto" icon @click.stop="addPhoto(3)"><v-icon size="18">mdi-plus</v-icon></v-btn>
                            </div>
                          </v-expand-transition>
                        </v-img>
                      </v-card>
                    </v-hover>
                  </v-flex>
                </v-layout>
            </v-card-text>
          </v-list>
          <li class="list-group-item py-2" style="border-top: 0px;"></li>
        </ul>
      </v-card>
      <v-dialog v-model="add_dialog" max-width="420">
        <v-card color="rgb(250,250,250)">
          <v-card-title class="py-4">Добавить фотографию</v-card-title>
          <v-card-text>
            <v-file-input
              accept="image/png, image/jpeg, image/bmp"
              label="Выберите изображение"
              prepend-icon="mdi-camera"
              v-model="file"
              solo
              flat
              dense
            ></v-file-input>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text small @click.stop="add_dialog = false">Отмена</v-btn>
            <v-btn color="primary" text small @click.stop="submitAdd" :loading="action_loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>   
      </v-dialog>
      <v-dialog v-model="del_dialog" max-width="420">
        <v-card>
          <v-card-title class="py-4">Удалить фотографию?</v-card-title>
          <v-card-text>
            Вы действительно хотите удалить фотографию ребенка?
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text small @click.stop="del_dialog = false">Отмена</v-btn>
            <v-btn color="primary" text small @click.stop="submitDelete" :loading="action_loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>        
      </v-dialog>
  </v-card>
</template>
<script> 
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import FieldAccessReloginButton from '../fieldaccess/FieldAccessReloginButton'

export default {
  name: 'children_photo',
  data () {
    return {
      dialog: false,
      item: {},
      selected: '',
      del_dialog: false,
      action_loading: false,
      file: null,
      add_dialog: false,
    }
  },
  components: { FieldAccess, FieldAccessButton, FieldAccessReloginButton },
  props: {
    item: Object,
    user_id: Number,
  },
  mounted() {
  
  },
  methods: {
    addPhoto(val) {
      this.file = null
      this.selected = val
      this.add_dialog = true
    },
    submitAdd() {
      this.action_loading = true
      let form = new FormData
      form.append('number', this.selected)
      form.append('file', this.file)
      form.append('id', this.item.id)
      this.$store.dispatch('ADD_REQUESTER_PHOTO', form).then(res => {
        this.file = null
        this.add_dialog = false
        this.$emit('refresh')
      })
      .finally(() => (this.action_loading = false))
    },
    submitDelete() {
      this.action_loading = true
      this.$store.dispatch('DELETE_REQUESTER_PHOTO', { number: this.selected, id: this.item.id }).then(res => {
        this.del_dialog = false
        this.$emit('refresh')
      })
      .finally(() => (this.action_loading = false))
    },
    deletePhoto(val) {
      this.selected = val
      this.del_dialog = true
    }
  },
  watch: {
   
  },
  computed: {
    
  },
};



</script>
