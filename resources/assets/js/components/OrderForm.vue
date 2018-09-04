<template>
  <form @submit.prevent="$emit('submit', values)">
    <div class="row">
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="name">Your name</label>
        <input
          type="text"
          v-model="values.name"
          class="form-control"
          id="name"
          required
          :disabled="disabled"
        />
      </div>
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="phone">Phone number</label>
        <the-mask
          :mask="['+# (###) ###-##-##', '+## (###) ###-##-##', '+### (###) ###-##-##']"
          type="tel"
          v-model="values.phone"
          name="phone"
          class="form-control"
          id="phone"
          required
          :disabled="disabled"
        />
      </div>
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="tariff">Tariff</label>
        <select v-model="values.tariff" class="form-control" id="tariff" :disabled="disabled">
          <option v-for="tariff in tariffs" :value="tariff.id">
            {{ tariff.name }}
          </option>
        </select>
      </div>
      <div class="col-lg-4 col-sm-6 form-group">
        <label for="start_day">Start day</label>
        <select v-model="values.start_day" class="form-control" id="start_day" :disabled="disabled">
          <option v-for="day in (tariff || {}).days" :value="day">
            {{ day | nameWeekDay }}
          </option>
        </select>
      </div>
      <div class="col-lg-8 form-group">
        <label for="client_address">Delivery address</label>
        <textarea
          v-model="values.address"
          class="form-control"
          id="client_address"
          rows="2"
          required
          :disabled="disabled"
        ></textarea>
      </div>
    </div>
    <div>
      <button type="submit" class="btn btn-primary mr-2" :disabled="disabled">
        Submit the order
      </button>
      <span v-if="tariff" class="align-middle">
        {{ tariff.price }}₽
      </span>
    </div>
  </form>
</template>

<script>
  import {TheMask} from 'vue-the-mask'

  export default {
    components: {TheMask},
    props: {
      tariffs: {
        type: Array,
        default: () => []
      },
      disabled: {
        type: Boolean,
        default: false
      }
    },
    data: function () {
      const tariff = this.tariffs[0] || null;

      return {
        values: {
          name: '',
          phone: '',
          tariff: tariff && tariff.id,
          start_day: tariff && tariff.days[0] || null,
          address: ''
        }
      };
    },
    computed: {
      tariff: function () {
        return this.tariffs.find(tariff => tariff.id === this.values.tariff) || null;
      }
    },
    watch: {
      // Makes the selected start day always be one of the tariff days
      'values.tariff': function () {
        const tariff = this.tariff;
        const days = tariff && tariff.days || [];

        if (!days.includes(this.values.start_day)) {
          this.values.start_day = days[0] || null;
        }
      }
    },
    filters: {
      nameWeekDay: day => [undefined, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][day]
    }
  }
</script>
