<template>
    <section>
        <h4 class="title is-4">Create Ticket</h4>
        <form action="/api/tickets" method="POST" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" @change="form.errors.clear($event.target.name)">
            <div class="field">
                <label for="title" class="label">Title:</label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" name="title" id="title" class="input" placeholder="Title Input"
                           v-model="form.title">
                    <span class="icon is-left"><i class="mdi mdi-bookmark mdi-24px"></i></span>
                </div>
                <p class="help is-danger" v-if="form.errors.has('title')" v-text="form.errors.get('title')"></p>
            </div>

            <div class="field">
                <label for="description" class="label">Description:</label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" name="description" id="description" class="input" placeholder="Description Input"
                           v-model="form.description">
                    <span class="icon is-left"><i class="mdi mdi-details mdi-24px"></i></span>
                </div>
                <p class="help is-danger" v-if="form.errors.has('description')" v-text="form.errors.get('description')"></p>
            </div>

            <div class="field">
                <label for="assignee" class="label">Assignee:</label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" name="assignee" id="assignee" class="input" placeholder="Assignee Input"
                           v-model="form.assignee">
                    <span class="icon is-left"><i class="mdi mdi-human mdi-24px"></i></span>
                </div>
                <p class="help is-danger" v-if="form.errors.has('assignee')" v-text="form.errors.get('assignee')"></p>
            </div>

            <div class="control">
                <button class="button is-primary" :disabled="form.errors.any()">Create</button>
            </div>
        </form>
        <div>
            <button class="button is-info" @click="getTicket()">Get Ticket</button>
        </div>
    </section>
</template>

<script>
  import Form from '../../core/Form';

  export default {
    name: "createTicket",

    props: {
      // weekdays: {
      //   type: Array,
      //   required: true
      // }
    },

    data() {
      return {
        form: new Form({
          title: '',
          description: '',
          assignee: ''
        })
      }
    },

    methods: {
      getTicket() {
        let id = 'd76281e4-ae09-4446-8772-0a31e024f04d';
        let response = this.getRequest(id);
        console.log(response);
      },
      getRequest(id) {
        let url = '/api/tickets/' + id;
        let etag = '';
        if (localStorage.getItem(id)) {
          try {
            let ticket = JSON.parse(localStorage[id]);
            etag = ticket.header.etag;
          } catch (e) {
            localStorage.removeItem(id);
          }
        }
        return new Promise((resolve, reject) => {
          axios.get(url, {
            'headers' : {
              'If-None-Match': etag
            }
          })
            .then(response => {
              console.log(response.headers);
              console.log(response.data);
              localStorage[id] = JSON.stringify({
                'path': url,
                'header': {
                  'etag': response.headers['etag'],
                  'lastModified': response.headers['last-modified']
                },
                'body': {
                  'id': response.data.id,
                  'title': response.data.title,
                  'description': response.data.description,
                  'assignee': response.data.assignee
                }
              });
              resolve(response.data);
            })
            .catch(error => {
              console.error(error.response.headers);
              if (error.response.status === 304) {
                console.log('return 304');
              } else {
                console.error(error.response.status);
                reject(error.response.data);
              }
            })
        })
      },
      onSubmit() {
        this.form.post('/api/tickets')
          .then(data => {
            alert(data.message);
            location.href = '/ticket-create'
          })
          .catch(errors => console.log(errors));
      }
    }
  }
</script>

<style scoped>

</style>