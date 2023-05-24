<template>
  <div class="row">
    <div class="col-6">
      <div class="task_container">
        <div class="d-flex justify-content-between  task_container--header">
          <p class="title">Task list</p>
          <button @click="openFormAdd" class="btn btn-primary btn-sm btn-add"><i style="width: 20px" class="bi bi-plus-circle"></i></button>
        </div>
        <div v-if="!loadingTaskList" class="task_list">
          <div v-for="(item, index) in inCompleteData" :key="index" class="task_item">
            <div class="row">
              <div class="col-10" @click="openFormEdit(item.id)">
                <h3>{{ item.name }}</h3>
                <div>Description: {{ item.description }}</div>
                <div style="font-size: 15px">
                  Date: {{ dateTimeFormat(item.startDate) }} ~ {{ dateTimeFormat(item.endDate) }}
                </div>
                <div class="task_item--child">
                  Sub task: <i class="bi bi-list-task" title="Subtask list" v-b-popover.hover.viewport.html="subTaskPopover(item.subTask)"></i>
                </div>
              </div>
              <div class="col-2" style="align-self: center">
                <i class="bi bi-check2-circle text-success iconCustom" @click="complete(item.id)"></i>
                <i class="bi bi-x-circle text-danger iconCustom" @click="deleteTask(item.id)"></i>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <b-skeleton-table
            :rows="20"
            :columns="4"
            :table-props="{ bordered: true, striped: true }"
          ></b-skeleton-table>
        </div>
      </div>
    </div>

    <div class="col-6">
      <div class="task_container">
        <div class="d-flex justify-content-between task_container--header">
          <p class="title">Complete list</p>
        </div>
        <div v-if="!loadingTaskList" class="task_list">
          <div v-for="(item, index) in completeData" :key="index" class="task_item">
            <div class="row">
              <div class="col-10" @click="openFormEdit(item.id)">
                <h3>{{ item.name }}</h3>
                <div>Description: {{ item.description }}</div>
                <div style="font-size: 15px">
                  Date: {{ dateTimeFormat(item.startDate) }} ~ {{ dateTimeFormat(item.endDate) }}
                </div>
                <div class="task_item--child">
                  Sub task: <i class="bi bi-list-task" title="Subtask list" v-b-popover.hover.viewport.html="subTaskPopover(item.subTask)"></i>
                </div>
              </div>
              <div class="col-2" style="align-self: center">
                <i class="bi bi-check2-circle text-success iconCustom" @click="complete(item.id)"></i>
                <i class="bi bi-x-circle text-danger iconCustom" @click="deleteTask(item.id)"></i>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <b-skeleton-table
            :rows="20"
            :columns="4"
            :table-props="{ bordered: true, striped: true }"
          ></b-skeleton-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TaskForm from "./TaskForm";
import Base from "../../mixins/Base";
import {EventBus} from "../app/EventBus";
export default {
  name: "TaskList",
  mixins: [Base],
  data () {
    return {
      formAdd: TaskForm,
      formEdit: TaskForm,
      items: [],
      loadingTaskList: false
    }
  },
  computed: {
    completeData () {
      return this.items.filter(item => item.status == 1)
    },
    inCompleteData () {
      return this.items.filter(item => item.status == 0)
    }
  },
  created() {
    EventBus.$on('reloadStatus', this.loadTask)
    EventBus.$on('reloadData', this.loadTask)
  },
  destroyed() {
    EventBus.$off('reloadData')
    EventBus.$off('reloadStatus')
  },
  mounted() {
    this.loadTask()
  },
  methods: {
    complete (id) {
      this.$api.post('/tasks/done/' + id)
        .then(response => {
         this.loadTask()
        })
        .catch(rej => {
          this.errors = rej.errors
        })
    },
    deleteTask (id) {
      this.$api.delete('/tasks/' + id)
        .then(response => {
          this.loadTask()
        })
        .catch(rej => {
          this.errors = rej.errors
        })
    },
    subTaskPopover (subTask) {
      if (subTask && subTask.length > 0) {
        let html = '<div class="subTaskPopover"><ul>'
        subTask.forEach(item => {
          console.log(item.status)
          html += '<li>'+item.name+`<i class="bi bi-check2-circle m-1 ${item.status == 1 ? 'text-success' : ''}"></i></li>`
        })
        html += '</ul></div>'
        return html
      } else {
        return '<p>You dont have any sub task</p>'
      }

    },
    loadTask () {
      this.loadingTaskList = true
      this.$api.get('/tasks')
        .then(response => {
          this.items = response.data.items;
          this.loading = false
          this.loadingTaskList = false
        })
        .catch(error => {
          this.loadingTaskList = false
          console.log(error);
        });
    }
  }
}
</script>

<style scoped>
.task_container {
  background-color: rgb(192, 192, 192, 0.3);
  border-radius: 20px;
  border: 1px solid #333;
}

.task_container--header {
  padding: 30px 30px 0px 30px;
}

.task_container .btn-add {
  width: 70px;
}

.task_list {
  height: 700px;
  overflow-y: scroll;
  overflow-x: hidden;
  margin: 15px;
}

.task_list::-webkit-scrollbar-track
{
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  background-color: #ffffff;
}

.task_list::-webkit-scrollbar
{
  width: 2px;
  background-color: #ffffff;
}

.task_list::-webkit-scrollbar-thumb
{
  background-color: #cccccc;
  border: 2px solid #ffffff;
}

.task_item {
  margin: 10px;
  padding: 10px;
  border-radius: 10px;
}
.task_item:hover {
  background-color: cadetblue;
  color: #ffffff;
  cursor: pointer;
}

.iconCustom {
  font-size: 30px;
  cursor: pointer;
}
</style>
<style>
.subTaskPopover ul li{
  list-style: auto !important;
}
</style>
