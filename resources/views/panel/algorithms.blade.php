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
      :items="algorithms"
      sort-by="id"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title>Algorithm List</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="700px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">New Algorithm</v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">Add New Algorithm</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-textarea v-model="editedItem.description" label="Description"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field v-model="editedItem.parameter" label="Parameter"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field v-model="editedItem.reference" label="Reference"></v-text-field>
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
            text: 'Algorithm Name',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          { text: 'Description', value: 'description' },
          { text: 'Parameter', value: 'parameter' },
          { text: 'Reference', value: 'reference' },
          { text: 'Actions', value: 'actions', sortable: false },
        ],
        algorithms: [],
        editedIndex: -1,
        editedItem: {
          name: '',
          description: '',
          parameter: '',
          reference: ''
        },
        defaultItem: {
          name: '',
          description: '',
          parameter: '',
          reference: ''
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
          axios.get("/panel/algorithm-list").then(response =>{
            this.algorithms = response.data
          }).catch(error => console.log(error.response))  
        },

        editItem (item) {
          this.editedIndex = this.algorithms.indexOf(item)
          this.editedItem = Object.assign({}, item)
          this.dialog = true
        },

        deleteItem (item) {
          const index = this.algorithms.indexOf(item)
          if(confirm('Are you sure you want to delete this algorithm?')) {
            axios.post('/panel/delete-algorithm', {
              id: item.id,
            }).then((response)=>{
              this.algorithms.splice(index, 1)     
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
            axios.post('/panel/update-algorithm', {
              id: this.editedItem.id,
              name: this.editedItem.name,
              description: this.editedItem.description,
              parameter: this.editedItem.parameter,
              reference: this.editedItem.reference
            }).then((response)=>{
              Object.assign(this.algorithms[this.editedIndex], this.editedItem)
              this.close()     
            }).catch(error => console.log(error.response)) 
          } else {
            axios.post('/panel/add-algorithm', {
              name: this.editedItem.name,
              description: this.editedItem.description,
              parameter: this.editedItem.parameter,
              reference: this.editedItem.reference
            }).then((response)=>{
              this.algorithms.push(this.editedItem)
              this.close()     
              this.initialize()
            }).catch(error => console.log(error.response))  
          }
        },
      },
    })
  </script>
@endsection
