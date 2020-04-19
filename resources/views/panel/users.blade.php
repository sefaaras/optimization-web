@extends('layouts.panel')

@section('header')

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">

@endsection

@section('content')
<div class="container">
<div id="app">
  <v-app id="inspire">
    <v-data-table
      :headers="headers"
      :items="users"
      sort-by="id"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title>User List</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">New User</v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">Add New User</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="10">
                      <v-text-field v-model="editedItem.name" label="Name Surname"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="10">
                      <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="5">
                      <v-text-field v-model="editedItem.isActive" label="isActive"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="5">
                      <v-text-field v-model="editedItem.isAdmin" label="isAdmin"></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
  
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          small
          @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </v-app>
</div>
</div>
@endsection

@section('script')

  <script src="https://cdn.jsdelivr.net/npm/babel-polyfill/dist/polyfill.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.2.20/dist/vuetify.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
  
  <script>
    new Vue({
      el: '#app',
      vuetify: new Vuetify(),
      data: () => ({
        dialog: false,
        headers: [
          {
            text: 'Name Surname',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          { text: 'Email', value: 'email' },
          { text: 'isActive', value: 'isActive' },
          { text: 'isAdmin', value: 'isAdmin' },
          { text: 'Actions', value: 'actions', sortable: false },
        ],
        users: [],
        editedIndex: -1,
        editedItem: {
          name: '',
          email: '',
          password: '',
          isActive: 0,
          isAdmin: 0
        },
        defaultItem: {
          name: '',
          email: '',
          isActive: 0,
          isAdmin: 0
        },
      }),
      
      computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
        },
      },

      watch: {
        dialog (val) {
          val || this.close()
        },
      },

      created () {
        this.initialize()
      },

      methods: {
        initialize () {
          axios.get("/panel/user-list").then(response =>{
            this.users = response.data
          }).catch(error => console.log(error.response))  
        },

        editItem (item) {
          this.editedIndex = this.users.indexOf(item)
          this.editedItem = Object.assign({}, item)
          this.dialog = true
        },

        deleteItem (item) {
          const index = this.users.indexOf(item)
          if(confirm('Are you sure you want to delete this user?')) {
            axios.post('/panel/delete-user', {
              id: item.id,
            }).then((response)=>{
              this.users.splice(index, 1)     
            }).catch(error => console.log(error.response)) 
          }
        },

        close () {
          this.dialog = false
          setTimeout(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
          }, 300)
        },

        save () {
          if (this.editedIndex > -1) {
            axios.post('/panel/update-user', {
              id: this.editedItem.id,
              name: this.editedItem.name,
              email: this.editedItem.email,
              isActive: this.editedItem.isActive,
              isAdmin: this.editedItem.isAdmin
            }).then((response)=>{
              Object.assign(this.users[this.editedIndex], this.editedItem)
              this.close()     
            }).catch(error => console.log(error.response)) 
          } else {
            axios.post('/panel/add-user', {
              name: this.editedItem.name,
              email: this.editedItem.email,
              isActive: this.editedItem.isActive,
              isAdmin: this.editedItem.isAdmin
            }).then((response)=>{
              this.users.push(this.editedItem)
              this.close()     
            }).catch(error => console.log(error.response))  
          }
        },
      },
    })
  </script>
@endsection
