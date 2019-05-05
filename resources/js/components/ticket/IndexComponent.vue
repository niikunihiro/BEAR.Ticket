<template>
    <section>
        <b-notification :type="notificationType" :auto-close="true" :active.sync="isActiveNotification">
            {{ notification }}
        </b-notification>

        <button class="button field is-danger" @click="checkedRows = []"
                :disabled="!checkedRows.length">
            <b-icon icon="close"></b-icon>
            <span>Clear checked</span>
        </button>

        <a href="/task/create" class="button is-info">
            <span class="icon">
                <i class="mdi mdi-plus-circle"></i>
            </span>
            <span>Add</span>
        </a>


        <b-table
                :data="data"
                :bordered="true"
                :striped="true"
                :paginated="isPaginated"
                :per-page="perPage"
                :current-page.sync="currentPage"
                :pagination-simple="isPaginationSimple"
                :default-sort-direction="defaultSortDirection"
                default-sort="id"
                :checked-rows.sync="checkedRows"
                checkable>

            <template slot-scope="props">
                <b-table-column field="id" label="ID" sortable numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="name" label="Frame Name" sortable>
                    <a :href='`/tasks/${props.row.id}/edit`'>
                        {{ props.row.name }}
                        <i class="mdi mdi-square-edit-outline"></i>
                    </a>
                </b-table-column>

                <b-table-column field="weekday" label="Weekday">
                    {{ props.row.weekday }}
                </b-table-column>

                <b-table-column field="start" label="Start">
                    {{ props.row.start }}
                </b-table-column>

                <b-table-column field="end" label="End">
                    {{ props.row.end }}
                </b-table-column>

                <b-table-column field="delete" label="Delete" centered>
                    <a class="button is-danger is-small" @click="onDelete(props.row.id)">
                        <span>Delete</span>
                        <span class="icon">
                            <i class="mdi mdi-delete-circle"></i>
                        </span>
                    </a>
                </b-table-column>
            </template>

            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon
                                    icon="emoticon-sad"
                                    size="is-large">
                            </b-icon>
                        </p>
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>
        </b-table>
    </section>
</template>

<script>
  import Form from "../../core/Form";

  export default {
    name: 'indexTicket',
    props: {
      frames: {
        type: Array,
        required: true
      }
    },
    data() {
      const data = this.frames;

      return {
        data,
        isActiveNotification: false,
        notification: '',
        notificationType: 'is-white',
        checkedRows: [],
        isPaginated: true,
        isPaginationSimple: false,
        defaultSortDirection: 'asc',
        currentPage: 1,
        perPage: 30
      }
    },

    methods: {
      onDelete(id) {
        if (!window.confirm('Are you sure? #' + id + ' resource.')) {
          return;
        }

        const form = new Form({});
        form.delete('/task/' + id)
          .then(data => {
            console.log(data);
            // notification
            this.notificationType = 'is-success';
            this.notification = 'Frame deleted successfully.';
            this.isActiveNotification = true;

            // remove row
            let target = _.findIndex(this.frames, frame => { return frame.id === id });
            this.frames.splice(target, 1);
          })
          .catch(errors => {
            console.log(errors);
            // notification
            this.notificationType = 'is-danger';
            this.notification = 'Fail to delete Frame.';
            this.isActiveNotification = true;
          });
      }
    },

    mounted() {
      console.log('Component mounted.')
    }
  }
</script>
