<script setup>
      import axios from "axios";
      import { onMounted, ref } from "vue";
      import { useRouter } from "vue-router";

      const router = useRouter();

      let invoices = ref ([])
      let searchInvoice = ref([])

      onMounted(async () => {
            getInvoices()
      })

      const getInvoices = async () => {
            let response = await axios.get("/api/get_all_invoices");
            invoices.value = response.data.invoices
      }

      const searchInvoices = async () => {
            let response = await axios.get('/api/search_invoice?s='+searchInvoice.value)
            // console.log('response', response.data.invoices)
            invoices.value = response.data.invoices
      }

      const newInvoice = async () => {
        let form = await axios.get('/api/create_invoice')
        // console.log('form', form.data)
        router.push('/invoice/new')
      }
</script>
<template>
      <!--==================== INVOICE LIST ====================-->
    <div class="invoices container">
        
        <div class="card__header">
            <div>
                <h2 class="invoice__title">Invoices</h2>
            </div>
            <div>
                <a class="btn btn-secondary" @click="newInvoice">
                    <i class="fa fa-plus"></i>
                    Add Invoice
                </a>
            </div>
        </div>

        <div class="table card__content">
            <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                <div class="table--filter--listWrapper">
                    <ul class="table--filter--list">
                        <li>
                            <p class="table--filter--link table--filter--link--active">
                                <i class="fa fa-tags" style="margin-right: 5px;"></i>All Invoices
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table--search" style="width: 100%;">
                <!-- <div class="table--search--wrapper">
                    <select class="table--search--select" name="" id="">
                        <option value="">Filter</option>
                    </select>
                </div> -->
                <div class="search" style="width: 100%;">
                    <i class="fa fa-search"></i>
                    <input class="table--search--input" type="text" placeholder="Search invoice by : ID or Number" v-model="searchInvoice" @keyup="searchInvoices()">
                </div>
            </div>

            <div class="table--heading">
                <p>ID</p>
                <p>Date</p>
                <p>Number</p>
                <p>Customer</p>
                <p>Due Date</p>
                <p>Total</p>
            </div>

            <!-- item 1 -->
            <div class="table--items" v-for="invoice in invoices" :key="invoice.id" v-if="invoices.length > 0">
                <a href="#" class="table--items--transactionId">#{{ invoice.id  }}</a>
                <p>{{ invoice.date }}</p>
                <p>#{{ invoice.number  }}</p>
                <p v-if="invoice.customer">{{ invoice.customer.firstname }}</p>
                <p v-else>-</p>
                <p>{{ invoice.due_date }}</p>
                <p> ${{ invoice.total }}</p>
            </div>
            <div v-else>
                  <p>Invoices not Found!</p>
            </div>
        </div>

    </div>
</template>