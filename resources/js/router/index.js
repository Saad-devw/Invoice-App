import { createRouter, createWebHashHistory } from "vue-router";
import invoiceIndex from '../components/invoices/index.vue'
import invoiceNew from '../components/invoices/new.vue'
import notFound from '../components/NotFound.vue'

const routes = [
      {
            path: '/',
            component: invoiceIndex
      },
      {
            path: '/invoice/new',
            component: invoiceNew
      },
      {
            path: '/:pathMatch(.*)*',
            component: notFound
      }
]
const router = createRouter({
      history: createWebHashHistory(),
      routes
})

export default router