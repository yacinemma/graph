<template>

    <div class="container">

        <div class="row">
            <div class="col-6">
            </div>
            <div class="col-4">
            </div>
            <button type="submit" class="col-2 btn btn-light">Statistics</button>
        </div>

        <div class="row">
            <div class="col-6">
                <d3-network ref='net' :net-nodes="nodes" :net-links="links" :options="options" @node-click="nodeClick"/>
            </div>
            <div class="col-1"></div>
            <div class="col-5">
                <h2 v-if="!this.edit">Add Node</h2>
                <h2 v-else>Edit Node</h2>
                <form @submit.prevent="addNode" class="mb-3">
                  <div class="form-group row">
                    <div class="col-12">
                        <label>Tooltip</label>
                        <input type="text" class="form-control" placeholder="Tooltip" v-model="node.tooltip">
                    </div><br>
                    <div class="col-12">
                        <label>Parents</label>
                        <v-select multiple v-model="node.parents" :options="nodes" :reduce="node => node.id" label="name" />

                    </div>
                    
                  </div>
                  
                  <button type="submit" class="btn btn-light btn-block" v-if="!this.edit">Save</button>
                  <div class="row" v-else>
                    <button type="submit" class="col-5 btn btn-light">Update</button>
                    <div class="col-2"></div>
                    <button type="button" @click="deleteNode()" class="col-5 btn btn-danger">Delete</button>
                  </div>
                </form>
                <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>
                <br>
            </div>

        </div>
    </div>
</template>

<script>
import D3Network from 'vue-d3-network'

    export default {
    methods: {
        deleteNode() {
          if (confirm('Are You Sure?')) {
            fetch(`nodes/${this.node_id}`, {
              method: 'delete'
            })
              .then(res => res.json())
              .then(data => {
                alert('Node Removed');
                this.fetchGraph(this.$route.params.id);
              })
              .catch(err => console.log(err));
          }
        },
        addNode() {
          if (this.edit === false) {
            // Add
            fetch('nodes/store', {
              method: 'post',
              body: JSON.stringify(this.node),
              headers: {
                'content-type': 'application/json'
              }
            })
              .then(res => res.json())
              .then(data => {
                this.clearForm();
                alert('Node Added');
                this.fetchGraph(this.node.graph_id);
              })
              .catch(err => console.log(err));
          } else {
            // Update
            fetch('nodes/' + this.node_id + '/edit', {
              method: 'put',
              body: JSON.stringify(this.node),
              headers: {
                'content-type': 'application/json'
              }
            })
              .then(res => res.json())
              .then(data => {
                this.clearForm();
                alert('Node Updated');
                this.fetchGraph(this.$route.params.id);
              })
              .catch(err => console.log(err));
          }
        },
        editNode(id,tooltip,parents) {
          this.edit = true;
          this.node_id = id;
          this.node.id = id;
          this.node.tooltip = tooltip;
          this.node.parents = parents;
        },
        clearForm() {
          this.edit = false;
          this.node_id = '';
          this.node.id = null;
          this.node.tooltip = '';
          this.node.parents = [];
        },
        nodeClick(event, node) {
            console.log(event, node);  
            alert(node.name);
            alert(node.id);
            console.log(node.parents)
            this.editNode(node.id,node.name,node.parents)

        },
        fetchGraph(id) {
          let vm = this;
          fetch('graphs/'+id)
            .then(res => res.json())
            .then(res => {
            console.log(res.data);
              this.nodes = res.data;
              this.links = res.links;
            })
            .catch(err => console.log(err));
        },
        
        
      },
    mounted() {
        this.fetchGraph(this.$route.params.id);
    },
        components: {
        D3Network
      },
  data () {
    return {
      nodes: [
        
      ],
      links: [
        
      ],
      nodeSize:20,
      canvas:false,
      node: {
        id: '',
        graph_id: this.$route.params.id,
        tooltip: '',
        parent_id: ''
      },
      node_id: '',
      edit: false

    }
  },
  computed:{
    options(){
      return{
        force: 2000,
        size:{ w:600, h:600},
        nodeSize: this.nodeSize,
        nodeLabels: true,
        linkLabels:false,
        canvas: this.canvas
      }
    }
  }
    }
</script>


<style src="vue-d3-network/dist/vue-d3-network.css"></style>
<style src="vue-select/dist/vue-select.css"></style>
