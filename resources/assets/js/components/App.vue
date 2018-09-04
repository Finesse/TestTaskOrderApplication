<template>
  <div class="container-fluid pb-4" style="max-width: 1200px; min-width: 320px;">
    <div class="text-center" style="font-size: 100px;">
      🚚
    </div>
    <order-form
      :tariffs="tariffs"
      :disabled="isSubmitting"
      @submit="values => $emit('form-submit', values)"
    />
  </div>
</template>

<script>
  import OrderForm from './OrderForm';

  export default {
    components: {OrderForm},
    props: {
      tariffs: {
        type: Array,
        default: () => []
      },
      isSubmitting: {
        type: Boolean,
        default: false
      }
    }
  };
</script>
