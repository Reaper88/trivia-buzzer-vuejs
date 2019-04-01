<template>
  <div class="animated fadeIn">
    <b-row>
        <b-col sm="12" md="6">
            <Results />
        </b-col>
        <b-col sm="12" md="6">
            Test
        </b-col>
    </b-row>
  </div>
</template>

<script>
import Results from '../components/Results'

export default {
  name: 'dashboard',
  components: {
      Results: Results
  }
}
</script>

