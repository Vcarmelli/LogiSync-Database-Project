$(document).ready(function() {
    loadCharts();
    loadCounts();
    loadCountPerMonth();
    loadRanges();
});

let ordersPerSupplierChart;
let overallChart;
let ordersPerMonthChart;
let priceDistributionChart;

function loadCharts() {
    $.ajax({
        url: '../includes/retrieve.php?view=charts',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const suppliers = response.orders.map(entry => entry.SupplierName); 
            const orderCounts = response.orders.map(entry => entry.OrderCount); 

            if (ordersPerSupplierChart) {
                ordersPerSupplierChart.destroy();
            }
            const ctxProducts = $('#ordersPerSupplierChart')[0].getContext('2d');
            ordersPerSupplierChart = new Chart(ctxProducts, {
                type: 'bar',
                data: {
                    labels: suppliers,
                    datasets: [{
                        label: 'Orders',
                        data: orderCounts,
                        backgroundColor: 'rgb(114, 61, 70, 0.8)',
                        minBarLength: 1,
                    }],
                    
                },
                maintainAspectRatio: false, 
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                      legend: {
                        position: 'top',
                      }
                    }
                    
                },
            });
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error fetching charts');
        }
        
    })
}

function loadCounts() {
    $.ajax({
        url: '../includes/retrieve.php?view=counts',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            $('.sup-count').html(response.suppliers);
            $('.pro-count').html(response.products);
            $('.ord-count').html(response.orders);

            if (overallChart) {
                overallChart.destroy();
            }

            const ctxAll = $('#overallChart')[0].getContext('2d');
            overallChart = new Chart(ctxAll, {
                type: 'doughnut',
                data: {
                    labels: ['Suppliers', 'Products', 'Orders'],
                    datasets: [{
                        label: 'Overall Count',
                        data: [response.suppliers, response.products, response.orders],
                        backgroundColor: [
                            'rgb(201, 203, 163)',
                            'rgb(255, 225, 168)',
                            'rgb(226, 109, 92)'
                        ],
                        hoverOffset: 10
                    }]
                }
            });
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error fetching counts');
        }
    })
}

function loadCountPerMonth() {
    $.ajax({
        url: '../includes/retrieve.php?view=average',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const { labels, counts } = processCountPerMonth(response);
            
            if (ordersPerMonthChart) {
                ordersPerMonthChart.destroy();
            }
            const ctx =  $('#ordersPerMonthChart')[0].getContext('2d');
            ordersPerMonthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Order Count',
                        data: counts,
                        backgroundColor: 'rgb(114, 61, 70, 0.8)',
                        pointRadius: 7, 
                        pointHoverRadius: 10
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Order Count'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    }
                }
            });

        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error fetching averages');
        }
    })
}


function loadRanges() {
    $.ajax({
        url: '../includes/retrieve.php?view=range',
        method: 'GET',
        dataType: 'json',
        success: function(response) {   
            const labels = response.map(item => item.PriceRange);
            const counts = response.map(item => item.ProductCount);
            
            if (priceDistributionChart) {
                priceDistributionChart.destroy();
            }
            const ctx =  $('#priceDistributionChart')[0].getContext('2d');
            priceDistributionChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Products',
                        data: counts,
                        backgroundColor: [
                            'rgb(226, 109, 92)',
                            'rgb(201, 203, 163)',
                            'rgb(255, 225, 168)'
                        ],
                    }],
                },
                options: {
                    scales: {
                        r: {
                            beginAtZero: true
                        }
                    }
                }

            });
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error fetching ranges');
        }
    })
}


function processCountPerMonth(data) {
    const purchaseOrders = data.purchaseOrders;

    // Count orders per month
    const orderCounts = {};
    purchaseOrders.forEach(order => {
        const orderDate = new Date(order.OrderDate);
        const monthName = orderDate.toLocaleString('en-US', { month: 'long' }); // Get the full month name
        const monthNumber = orderDate.getMonth(); // Get the month number (0-11)
        const key = `${monthNumber}-${monthName}`; // Create a key using the month number and name
        if (!orderCounts[key]) {
            orderCounts[key] = 0;
        }
        orderCounts[key]++;
    });

    // Extract labels (months) and data (order counts) and sort by month number
    const sortedKeys = Object.keys(orderCounts).sort((a, b) => {
        const monthA = parseInt(a.split('-')[0]);
        const monthB = parseInt(b.split('-')[0]);
        return monthA - monthB;
    });
    const labels = sortedKeys.map(key => key.split('-')[1]); // Extract month names from sorted keys
    const counts = sortedKeys.map(key => orderCounts[key]);

    return { labels, counts };
}
