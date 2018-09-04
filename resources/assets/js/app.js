import Vue from 'vue';
import App from './components/App';
import {post} from 'axios';
import swal from 'sweetalert';
import 'bootstrap/dist/css/bootstrap.min.css';

// The application start point
new Vue({
  el: '#app',
  data: {
    ...window.orderFormData,
    isSubmitting: false
  },
  components: {App},
  template: '<app :tariffs="tariffs" :isSubmitting="isSubmitting" @form-submit="handleSubmit"/>',
  methods: {
    // Sends the order data when the form is submitted
    handleSubmit: async function (values) {
      if (this.isSubmitting) {
        return;
      }

      this.isSubmitting = true;

      try {
        const response = await post(this.submitURL, values);
        await swal(
          'Success!',
          `Your order has been submitted. The order number is ${response.data.orderId}.`,
          'success'
        );
      } catch (error) {
        await swal(
          'Error',
          getResponseErrorText(error.response),
          'error'
        );
      } finally {
        this.isSubmitting = false;
      }
    }
  }
});

/**
 * Gets an error message for the user from an Axios error
 *
 * @param {{}} response Axios response
 * @return {string}
 */
function getResponseErrorText(response) {
  const {data, status, statusText} = response;

  // Laravel CSRF protection response
  if (status === 419) {
    return 'The session has expired. Please reload the page.';
  }

  // Laravel validation error
  if (status === 422 && data.errors && typeof data.errors === 'object') {
    return Object.values(data.errors)
      .map(errors => errors.join(' '))
      .join(" \n");
  }

  // Other Laravel errors
  if (data.message && typeof data.message === 'string') {
    return data.message;
  }

  // Other errors
  return `Unknown error: ${status} — ${statusText}`;
}
