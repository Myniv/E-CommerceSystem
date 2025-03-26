<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <!-- Pie Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="persentageChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bar Chart: Credits taken vs. credits required -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="creditChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Chart: GPA per Semester -->
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="gpaChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Data dari controller

    const percentageProductsByCategory = <?= $percentageProductsByCategory ?>;
    const highestCategoriesOfProducts = <?= $highestCategoriesOfProducts ?>;
    const productsPerMonth = <?= $productsPerMonth ?>;
    



    //JS Pie Chart
    const gradeChart = new Chart(
        document.getElementById('persentageChart'),
        {
            type: 'pie',
            //Change the data here
            data: percentageProductsByCategory,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Product Distribution by Category'
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        }
    );

    //JS Bar Chart
    const creditChart = new Chart(
        document.getElementById('creditChart'),
        {
            type: 'bar',
            //Change the data here
            data: highestCategoriesOfProducts,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Products'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Category'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Products Based On Categories'
                    }
                }
            }
        }
    );

    //JS Line Chart
    const gpaChart = new Chart(
        document.getElementById('gpaChart'),
        {
            type: 'line',
            //Change the data here
            data: productsPerMonth,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 0,
                        max: 50,
                        title: {
                            display: true,
                            text: 'Products'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Products per Month'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `Products: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        }
    );

</script>
<?= $this->endSection() ?>