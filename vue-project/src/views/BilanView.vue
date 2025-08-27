<template>
    <div class="row">
        <div class="col-12 col-md-7 mb-3">
            <div class="bilan">
                <div class="canva">
                    <canvas ref="chartCanvas" aria-label="chart" role="img" width="100" heigth="90"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <h1 class="text text-center" style="color: white;">Bilan de notre Loyer</h1>
            <div class="dataBilan">
                <div class="row g-3">
                    <div class="col-12 col-lg-6 col-xxl-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">Loyer Moyenne</h6>
                                <h5 class="text-primary mb-1">${{ loyerMoyenne }},00</h5>
                                <small class="text-success">↑ 12% increase</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 col-xxl-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">Loyer Total</h6>
                                <h5 class="text-dark mb-1">${{ totalLoyer }},00</h5>
                                <small class="text-danger">↑ 8% increase</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 col-xxl-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">Loyer Minimum</h6>
                                <h5 class="text-danger mb-1"> ${{ loyerMinimum  }},00</h5>
                                <small class="text-success">↑ 15% increase</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 col-xxl-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">Loyer Maximum</h6>
                                <h5 class="text-primary mb-1">${{ loyerMaximum }},00</h5>
                                <small class="text-success">↑ 3% increase</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

import { onMounted, ref } from 'vue'
import axios from 'axios'
import {
  Chart,
  PieController,
  ArcElement,
  Tooltip,
  Legend
} from 'chart.js'

Chart.register(PieController, ArcElement, Tooltip, Legend)

const chartCanvas = ref(null)
const dataChart = ref([])
const chargerUtilisateurs = async () => {
  await axios.get(`http://localhost/cliprojvue/backend/API/utilisateurs/lister.php`)
  .then(res => {
    // console.table(res.data)
    dataChart.value = res.data.map(record => {
        const jours = parseInt(record.nbr_jour)
        const taux = parseFloat(record.taux_jour)
        const loyer = jours * taux

        // console.log(`jours: ${jours}, taux: ${taux}, loyer: ${loyer}`)

        return {
            ...record,
            loyer
        }
    })
    // console.table( dataChart.value)
  })
}

const getTotalLoyer= ()=>{
    return dataChart.value.reduce((total, record) => total + parseFloat(record.loyer), 0)
}

const getMaxLoyer= () =>{
    return Math.max(...dataChart.value.map((record) => parseFloat(record.loyer)))
}

const getMinLoyer= () =>{
    return Math.min(...dataChart.value.map((record) => parseFloat(record.loyer)))
}

const getMoyLoyer = (arr) => {
    console.log(arr)
    return arr/2
}

const totalLoyer = ref(0)
const loyerMinimum = ref(0)
const loyerMaximum = ref(0) 
const loyerMoyenne = ref(0)

onMounted(async ()=> {
    await chargerUtilisateurs()
    totalLoyer.value = getTotalLoyer()
    loyerMinimum.value = getMinLoyer()
    loyerMaximum.value = getMaxLoyer()
    loyerMoyenne.value = getMoyLoyer(totalLoyer.value) 
    const myCamember = new Chart(chartCanvas.value, {
        type: 'pie',
        data: {
            labels: ['Total Loyer', 'Loyer Minimum', 'Loyer Maximum', 'Loyer Moyenne'],
            datasets: [{
                label: 'Diagramme de notre Bilan',
                data: [totalLoyer.value, loyerMinimum.value, loyerMaximum.value, loyerMoyenne.value],
                backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    })
})

</script>