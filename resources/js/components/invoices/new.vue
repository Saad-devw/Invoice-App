<script setup>
      // import axios from "axios";
      import axios from "axios";
      import { onMounted, ref } from "vue";
      import { useRouter } from "vue-router";

      let router = useRouter()

      let form = ref([])
      let allCustomers = ref([])
      let customerId = ref([])
      let item = ref([])
      let listCart = ref([])
      let allProducts = ref([])

      const showModel = ref(false)
      const hideModel = ref(true)

      onMounted(async () => {
            indexForm()
            getAllCustomers()
            getAllProducts()
      })

      const indexForm = async () => {
            let response = await axios.get('/api/create_invoice')
            form.value = response.data
      }

      const getAllCustomers = async () => {
            let response = await axios.get("/api/customers")
            allCustomers.value = response.data.customers
      }

      const getAllProducts = async () => {
            let response = await axios.get('/api/products')
            allProducts.value = response.data.products
      }

      const addCart = (item) => {
            const itemCart = {
                  id: item.id,
                  item_code: item.item_code,
                  description: item.description,
                  unit_price: item.unit_price,
                  quantity: item.quantity,
            }

            listCart.value.push(itemCart)
            closeModel()
      }

      const subTotal = () => {
            let total = 0;
            listCart.value.map(data => {
                  total += (data.quantity*data.unit_price);
            });
            return total;
      }

      const grandTotal = () => {
            return subTotal() - ((subTotal() * form.value.discount) / 100);
      }

      const onSave = () => {
            if(listCart.value.length >= 1){
                  let sub_total = 0
                  sub_total = subTotal()
                  let total = 0
                  total = grandTotal()

                  const formData = new FormData()
                  formData.append('invoice_item',JSON.stringify(listCart.value))
                  formData.append('customer_id',customerId.value)
                  formData.append('date',form.value.date)
                  formData.append('due_date',form.value.due_date)
                  formData.append('number',form.value.number)
                  formData.append('reference',form.value.reference)
                  formData.append('discount',form.value.discount)
                  formData.append('sub_total',sub_total)
                  formData.append('total',total)
                  formData.append('terms_and_conditions',form.value.terms_and_conditions)

                  axios.post('/api/add_invoice', formData)
                  listCart.value = []
                  router.push('/')

            }
      }

      const openModel = () => {
            showModel.value = !showModel.value;
      }

      const closeModel = () => {
            showModel.value = !showModel.value;
      }

      const removeItem = (i) => {
            listCart.value.splice(i,1);
      }
</script>
<template>
      <div class="invoices container">

            <div class="card__header">
                  <div>
                        <h2 class="invoice__title">New Invoice</h2>
                  </div>
                  <div>

                  </div>
            </div>

            <div class="card__content">
                  <div class="card__content--header">
                        <div>
                              <p class="my-1">Customer</p>
                              <select name="" id="" class="input" v-model="customerId">
                                    <option disabled selected>Select Customer</option>
                                    <option v-for="customer in allCustomers" :key="customer.id" :value="customer.id">{{
                                          customer.firstname }}</option>
                              </select>
                        </div>
                        <div>
                              <p class="my-1">Date</p>
                              <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="form.date">
                              <p class="my-1">Due Date</p>
                              <input id="due_date" type="date" class="input" v-model="form.due_date">
                        </div>
                        <div>
                              <p class="my-1">Number</p>
                              <input type="text" class="input" v-model="form.number">
                              <p class="my-1">Reference(Optional)</p>
                              <input type="text" class="input" v-model="form.reference">
                        </div>
                  </div>
                  <br><br>
                  <div class="table">

                        <div class="table--heading2">
                              <p>Item Description</p>
                              <p>Unit Price</p>
                              <p>Qty</p>
                              <p>Total</p>
                              <p></p>
                        </div>

                        <!-- item 1 -->
                        <div class="table--items2" v-for="itemCart in listCart" :key="itemCart.id">
                              <p>{{ itemCart.item_code }} {{ itemCart.description }} </p>
                              <p>
                                    <input type="text" class="input" v-model="itemCart.unit_price">
                              </p>
                              <p>
                                    <input type="text" class="input" v-model="itemCart.quantity">
                              </p>
                              <p v-if="itemCart.quantity">
                                    $ {{ itemCart.quantity * itemCart.unit_price }}
                              </p>
                              <p v-else>-</p>
                              <p style="color: red; font-size: 24px;cursor: pointer;" @click="removeItem()">
                                    &times;
                              </p>
                        </div>
                        <div style="padding: 10px 30px !important;">
                              <button class="btn btn-sm btn__open--modal" @click="openModel()">
                                    Add Product
                              </button>
                        </div>
                  </div>

                  <div class="table__footer">
                        <div class="document-footer">
                              <p>Terms and Conditions</p>
                              <textarea cols="50" rows="7" class="textarea" v-model="form.terms_and_conditions"></textarea>
                        </div>
                        <div>
                              <div class="table__footer--subtotal">
                                    <p>Sub Total</p>
                                    <span v-if="subTotal()">$ {{ subTotal() }}</span>
                                    <span v-else>$ 0</span>
                              </div>
                              <div class="table__footer--discount">
                                    <p>Discount(%)</p>
                                    <input type="text" class="input" v-model="form.discount">
                              </div>
                              <div class="table__footer--total">
                                    <p>Grand Total</p>
                                    <span v-if="grandTotal()">$ {{ grandTotal() }}</span>
                                    <span v-else>$ 0</span>
                              </div>
                        </div>
                  </div>


            </div>
            <div class="card__header" style="margin: 40px 0px;">
                  <div>

                  </div>
                  <div>
                        <a class="btn btn-secondary" @click="onSave()">
                              <i class="fa fa-save"></i>
                              Save
                        </a>
                  </div>
            </div>

            <!--==================== add modal items ====================-->
            <div class="modal main__modal" :class="{ show: showModel }">
                  <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="closeModel()">×</span>
                        <h3 class="modal__title">Add Item</h3>
                        <hr><br>
                        <div class="modal__items">
                              <ul style="list-style: none; width: 100%;">
                                    <li v-for="(item, index) in allProducts" 
                                          :key="item.id" 
                                          :value="item.id"
                                          style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin: 10px 0px;"
                                          >
                                          <span>{{ index + 1 }}</span>
                                          <span class="item--name">{{ item.item_code }} {{ item.description }}</span>
                                          <button @click="addCart(item)" style="padding: 5px 15px; border: none; background: #ccc; cursor: pointer;">
                                                +
                                          </button>
                                    </li>
                              </ul>
                        </div>
                        <br>
                        <hr>
                        <div class="model__footer" style="display: flex; align-items: center; justify-content: center;">
                              <button class="btn btn-light mr-2 btn__close--modal" @click="closeModel()">
                                    Cancel
                              </button>
                        </div>
                  </div>
            </div>

      </div>
</template>