<template>
    <section>
        <h4 class="title is-4">Edit Frame</h4>
        <form action="/tasks" method="POST" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)"
              @change="form.errors.clear($event.target.name)">
            <input name="_method" type="hidden" value="PUT">
            <div class="field">
                <label for="name" class="label">Name:</label>
                <div class="control">
                    <input type="text" name="name" id="name" class="input" placeholder="Frame Name Input"
                           v-model="form.name">
                </div>
                <p class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></p>
            </div>

            <div class="field">
                <label for="weekday" class="label">Weekday:</label>
                <div class="control">
                    <div class="select" v-model="form.weekday">
                        <select id="weekday" v-model="form.weekday">
                            <option v-for="(label, id) in weekdays" :value="id">{{ label }}</option>
                        </select>
                    </div>
                </div>
                <p class="help is-danger" v-if="form.errors.has('weekday')" v-text="form.errors.get('weekday')"></p>
            </div>

            <div class="field">
                <label for="start" class="label">Start time:</label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" name="start" id="start" class="input" placeholder="HH:mm"
                           v-model="form.start">
                    <span class="icon is-left"><i class="mdi mdi-clock mdi-24px"></i></span>
                </div>
                <p class="help is-danger" v-if="form.errors.has('start')" v-text="form.errors.get('start')"></p>
            </div>

            <div class="field">
                <label for="end" class="label">End time:</label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" name="end" id="end" class="input" placeholder="HH:mm"
                           v-model="form.end">
                    <span class="icon is-left"><i class="mdi mdi-clock mdi-24px"></i></span>
                </div>
                <p class="help is-danger" v-if="form.errors.has('end')" v-text="form.errors.get('end')"></p>
            </div>

            <div class="control">
                <button class="button is-primary" :disabled="form.errors.any()">Edit</button>
            </div>
        </form>
    </section>
</template>

<script>
  import Form from '../../core/Form';

  export default {
    name: "editFrame",

    props: {
      frame: {
        type: Object,
        required: true
      },
      weekdays: {
        type: Array,
        required: true
      }
    },

    data() {
      const data = this.weekdays;
      const frameId = this.frame.id;


      return {
        data,
        frameId,
        form: new Form({
          name: this.frame.name,
          weekday: this.frame.weekday,
          start: this.frame.start,
          end: this.frame.end
        })
      }
    },

    methods: {
      onSubmit() {
        this.form.put('/tasks/' + this.frameId)
          .then(data => {
            alert(data.message);
            location.href = '/task'
          })
          .catch(errors => console.log(errors));
      }
    }
  }
</script>

<style scoped>

</style>