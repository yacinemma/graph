<template>
  <div>
    <h2>Graphs</h2>
    <form @submit.prevent="addGraph" class="mb-3">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Name" v-model="graph.name">
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="Description" v-model="graph.description"></textarea>
      </div>
      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
    <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>
    <br>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchGraphs(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchGraphs(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    <div class="card card-body mb-2 row" style="flex-direction: row;" v-for="graph in graphs" v-bind:key="graph.id">
      <div class="col-9">
        <h3>{{ graph.name }}</h3>
        <p>{{ graph.description }}</p>
      </div>
      <div class="col-3">
        <button @click="editGraph(graph)" style="width: 100px;" class="btn btn-warning"><font-awesome-icon icon="edit" /> Edit</button>
        <button @click="viewGraph(graph)" style="width: 100px;" class="btn btn-warning"><font-awesome-icon icon="eye" /> View</button>
        <button @click="deleteGraph(graph.id)" style="width: 100px;" class="btn btn-danger"><font-awesome-icon icon="trash-alt" /> Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      graphs: [],
      graph: {
        id: '',
        name: '',
        description: ''
      },
      graph_id: '',
      pagination: {},
      edit: false
    };
  },

  created() {
    this.fetchGraphs();
  },

  methods: {
    fetchGraphs(page_url) {
      let vm = this;
      page_url = page_url || '/index';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.graphs = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };

      this.pagination = pagination;
    },
    deleteGraph(id) {
      if (confirm('Are You Sure?')) {
        fetch(`graphs/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('Graph Removed');
            this.fetchGraphs();
          })
          .catch(err => console.log(err));
      }
    },
    addGraph() {
      if (this.edit === false) {
        // Add
        fetch('graphs/store', {
          method: 'post',
          body: JSON.stringify(this.graph),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Graph Added');
            this.fetchGraphs();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('graphs/' + graph.id + '/edit', {
          method: 'put',
          body: JSON.stringify(this.graph),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Graph Updated');
            this.fetchGraphs();
          })
          .catch(err => console.log(err));
      }
    },
    editGraph(graph) {
      this.edit = true;
      this.graph.id = graph.id;
      this.graph.graph_id = graph.id;
      this.graph.name = graph.name;
      this.graph.description = graph.description;
    },
    clearForm() {
      this.edit = false;
      this.graph.id = null;
      this.graph.graph_id = null;
      this.graph.name = '';
      this.graph.description = '';
    }
  }
};
</script>