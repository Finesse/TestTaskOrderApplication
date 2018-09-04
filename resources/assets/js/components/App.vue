<template>
  <div class="container-fluid pb-4" style="max-width: 1200px; min-width: 320px;">
    <div class="text-center" style="font-size: 100px;">
      🚚
    </div>
    <div class="row">
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="name">Your name</label>
        <input type="text" name="name" class="form-control" id="name">
      </div>
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="phone">Phone number</label>
        <input type="tel" name="phone" class="form-control" id="phone">
      </div>
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="tariff">Tariff</label>
        <select name="tariff" class="form-control" id="tariff">
          <option v-for="tariff in tariffs" v-bind:value="tariff.id">
            {{ tariff.name }} – {{ tariff.price }}₽
          </option>
        </select>
      </div>
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="start_day">Start day</label>
        <select name="start_day" class="form-control" id="start_day"></select>
      </div>
      <div class="col-lg-8 form-group">
        <label for="client_address">Delivery address</label>
        <textarea name="address" class="form-control" id="client_address" rows="2"></textarea>
      </div>
    </div>
    <div>
      <button type="submit" class="btn btn-primary">Submit the order</button>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      tariffs: {
        type: Array,
        default: () => []
      }
    }
  }
</script>
