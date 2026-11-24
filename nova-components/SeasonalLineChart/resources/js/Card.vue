<template>
  <Card class="p-6">
    <h3 class="font-bold text-lg mb-4">{{ card.title }}</h3>
    <div style="height: 320px; position: relative">
      <canvas ref="canvas" role="img" :aria-label="card.title"></canvas>
    </div>
  </Card>
</template>

<script>
import Chart from 'chart.js/auto'

export default {
  props: ['card'],
  mounted() {
    this.drawChart()
  },
  beforeUnmount() {
    this.chart?.destroy()
  },
  watch: {
    card: {
      deep: true,
      handler() {
        this.drawChart()
      },
    },
  },
  methods: {
    drawChart() {
      this.chart?.destroy()
      this.chart = new Chart(this.$refs.canvas, {
        type: 'line',
        data: {
          labels: this.card.options?.xaxis?.categories || [],
          datasets: (this.card.series || []).map(series => ({
            ...series,
            data: [...series.data],
            fill: false,
          })),
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: this.card.animations?.enabled === false ? false : undefined,
          interaction: { mode: 'index', intersect: false },
        },
      })
    },
  },
}
</script>
