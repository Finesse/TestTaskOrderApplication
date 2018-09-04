import Vue from 'vue';
import App from './components/App';
import {post} from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';

new Vue({
  el: '#app',
  data: {
    ...window.orderFormData,
    isSubmitting: false
  },
  components: {App},
  template: '<app :tariffs="tariffs" :disabled="isSubmitting" @submit="handleSubmit"/>',
  methods: {
    // Sends the order data when the form is submitted
    handleSubmit: async function (values) {
      if (this.isSubmitting) {
        return;
      }

      this.isSubmitting = true;

      try {
        await post(this.submitURL, values);
      } finally {
        this.isSubmitting = false;
      }
    }
  }
});
