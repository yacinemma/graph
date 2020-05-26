<template>

    <div class="container">

        <div class="row"><br>
            <div class="col-6">
              <h3>Statistics graph <b style="color:red;">{{graph.name}}</b></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
              <h4>created at <b>{{graph.created_at}}</b></h4>
            </div>
            <div class="col-5">
              <h4>updated at <b>{{graph.updated_at}}</b></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
              <h3>Number of nodes <b>{{nodes.length}}</b></h3>
            </div>
            <div class="col-4">
              <h3>Number of relations <b>{{links.length}}</b></h3>
            </div>
        </div>

        <div class="row">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Node ID</th>
                  <th>Node tooltip</th>
                  <th>Node neighbors</th>
                </tr>
              </thead>
              <tbody>

                <tr v-for="node in nodes">
                  <td>{{node.id}}</td>
                  <td>{{node.name}}</td>
                  <td>{{node.parents.join()}}</td>
                </tr>
              
              </tbody>
            </table>

        </div>
    </div>
</template>

<script>

    export default {
    methods: {
        fetchGraph(id) {
          let vm = this;
          fetch('graphs/'+id+'/statistics')
            .then(res => res.json())
            .then(res => {
            console.log(res.data);
              this.nodes = res.data;
              this.links = res.links;
              this.graph = res.graph;
            })
            .catch(err => console.log(err));
        },
        
        
      },
    mounted() {
        this.fetchGraph(this.$route.params.id);
    },
  data () {
    return {
      nodes: [
        
      ],
      links: [
        
      ],

      graph: {
        id: '',
        name: '',
        description: '',
        created_at: '',
        updated_at: ''
      },
    }
  },
}
</script>