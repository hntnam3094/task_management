<template>
  <div class="store">
    <div class="row">
      <div class="col-12 d-flex justify-content-between align-items-center mb-5">
        <div>
          <h1>Store management</h1>
          <b-breadcrumb :items="breadcrumb"></b-breadcrumb>
        </div>
        <b-button class="btn-sm" variant="primary" style="width: 60px; height: 30px" @click="openFormAdd"><i class="bi bi-plus-lg"></i></b-button>
      </div>
      <div v-for="(item, key) in items" :key="key" class="col-3 mb-2">
        <b-card
          :title="item.name"
          img-src="https://picsum.photos/600/300/?image=25"
          img-alt="Image"
          img-top
          tag="article"
          style="max-width: 20rem;"
          class="mb-2"
        >
          <b-card-text>
            Some quick example text to build on the card title and make up the bulk of the card's content.
          </b-card-text>

          <div class="group-button">
            <b-button class="btn-sm" variant="success" @click="openFormDetail"><i class="bi bi-search"></i></b-button>
            <b-button class="btn-sm" variant="warning" @click="openFormEdit(item.id)"><i class="bi bi-pencil-square"></i></b-button>
            <b-button class="btn-sm" variant="danger"><i class="bi bi-trash-fill"></i></b-button>
          </div>
        </b-card>
      </div>
    </div>
  </div>
</template>

<script>
import StoreFrom from "./StoreFrom";
import StoreDetail from "./StoreDetail";
import Base from '../../mixins/Base'
export default {
  name: "StoreList",
  mixins: [Base],
  data () {
    return {
      items: [],
      formAdd: StoreFrom,
      formEdit: StoreFrom,
      formDetail: StoreDetail,
      breadcrumb: [
        {
          text: 'Home',
          href: '/'
        },
        {
          text: 'Store management'
        }
      ]
    }
  },
  mounted() {
    this.items = [
      {
        id: 1,
        name: 'Store 1',
        description: 'This is store 2',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxXnC3fwMwkbIt3ejGRIw3NmbDyUtgS5g2jA&usqp=CAU',
        address: '117-119 Ly chinh thang, phuong vo thi sau, quan 3',
        phoneNumber: '0378918649'
      },
      {
        id: 1,
        name: 'Store 1',
        description: 'This is store 2',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxXnC3fwMwkbIt3ejGRIw3NmbDyUtgS5g2jA&usqp=CAU',
        address: '117-119 Ly chinh thang, phuong vo thi sau, quan 3',
        phoneNumber: '0378918649'
      },
      {
        id: 1,
        name: 'Store 1',
        description: 'This is store 2',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxXnC3fwMwkbIt3ejGRIw3NmbDyUtgS5g2jA&usqp=CAU',
        address: '117-119 Ly chinh thang, phuong vo thi sau, quan 3',
        phoneNumber: '0378918649'
      },
      {
        id: 1,
        name: 'Store 1',
        description: 'This is store 2',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxXnC3fwMwkbIt3ejGRIw3NmbDyUtgS5g2jA&usqp=CAU',
        address: '117-119 Ly chinh thang, phuong vo thi sau, quan 3',
        phoneNumber: '0378918649'
      },
      {
        id: 1,
        name: 'Store 1',
        description: 'This is store 2',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxXnC3fwMwkbIt3ejGRIw3NmbDyUtgS5g2jA&usqp=CAU',
        address: '117-119 Ly chinh thang, phuong vo thi sau, quan 3',
        phoneNumber: '0378918649'
      },
      {
        id: 1,
        name: 'Store 1',
        description: 'This is store 2',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxXnC3fwMwkbIt3ejGRIw3NmbDyUtgS5g2jA&usqp=CAU',
        address: '117-119 Ly chinh thang, phuong vo thi sau, quan 3',
        phoneNumber: '0378918649'
      },
      {
        id: 1,
        name: 'Store 1',
        description: 'This is store 2',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxXnC3fwMwkbIt3ejGRIw3NmbDyUtgS5g2jA&usqp=CAU',
        address: '117-119 Ly chinh thang, phuong vo thi sau, quan 3',
        phoneNumber: '0378918649'
      },
    ];
  },
  methods: {
  }
}
</script>

<style scoped>
.group-button {
  float: right;
}
</style>
