import Vue from 'vue';
import App from './components/App';
import 'bootstrap/dist/css/bootstrap.min.css';

new Vue({
  el: '#app',
  data: {...window.orderFormData},
  components: {App},
  template: '<app :tariffs="tariffs"/>'
});
