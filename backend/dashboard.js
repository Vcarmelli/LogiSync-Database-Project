// $(document).ready(function() {
//     $.ajax({
//         url: '../includes/retrieve.php',
//         method: 'GET',
//         dataType: 'json',
//         success: function(data) {
//             const suppliers = data.suppliers;
//             const productCounts = data.products.map(entry => entry.ProductCount);
//             const orderCounts = data.orders;

//             console.log(suppliers);
//             console.log(productCounts);
//             console.log(orderCounts);

//             const ctxProducts = $('#productsChart')[0].getContext('2d');
//             const productsChart = new Chart(ctxProducts, {
//                 type: 'bar',
//                 data: {
//                     labels: suppliers,
//                     datasets: [{
//                         label: 'Number of Products',
//                         data: productCounts,
//                         backgroundColor: 'rgba(75, 192, 192, 0.2)',
//                         borderColor: 'rgba(75, 192, 192, 1)',
//                         borderWidth: 1
//                     }]
//                 },
//                 options: {
//                     scales: {
//                         y: { beginAtZero: true }
//                     }
//                 }
//             });
//         },
//         error: function(error) {
//             console.error("Error:", error);
//             alert('Error fetching charts');
//         }


//     });
// })


function loadCharts() {
    $.ajax({
        url: '../includes/retrieve.php?view=charts',
        method: 'GET',
        dataType: 'json',
        success: function(response) {

            const suppliers = response.suppliers;
            const productCounts = response.products;
            const orderCounts = response.orders;

            // const ctxProducts = $('#productsChart')[0].getContext('2d');
            // const prodsChart = new Chart(ctxProducts, {
            //     type: 'bar',
            //     data: {
            //         labels: suppliers,
            //         datasets: [{
            //             label: 'Product Counts',
            //             data: productCounts,
            //             borderWidth: 1
            //         }]
            //     },
            //     options: {
            //         scales: {
            //             y: {
            //                 beginAtZero: true
            //             }
            //         }
            //     }
            // });
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

            const ctxAll = $('#overallChart')[0].getContext('2d');
            const prodsChart = new Chart(ctxAll, {
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

function loadAverage() {
    $.ajax({
        url: '../includes/retrieve.php?view=average',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("response:", response);
            const { orderDeliveryData, averageDeliveryTimes } = processData(response);
            console.log("orderDeliveryData:", orderDeliveryData);
            console.log("averageDeliveryTimes:", averageDeliveryTimes);

            // const ctx1 = $('#orderDeliveryChart')[0].getContext('2d');
            // new Chart(ctx1, {
            //     type: 'scatter',
            //     data: {
            //         datasets: [{
            //             label: 'Order vs Delivery Dates',
            //             data: orderDeliveryData,
            //             backgroundColor: 'rgb(255, 225, 168, 0.6)'
            //         }]
            //     },
            //     options: {
            //         scales: {
            //             x: {
            //                 type: 'time',
            //                 title: {
            //                     display: true,
            //                     text: 'Order Date'
            //                 },
            //                 adapters: {
            //                     date: {
            //                         type: 'date-fns'
            //                     }
            //                 }
            //             },
            //             y: {
            //                 type: 'time',
            //                 title: {
            //                     display: true,
            //                     text: 'Delivery Date'
            //                 },
            //                 adapters: {
            //                     date: {
            //                         type: 'date-fns'
            //                     }
            //                 }
            //             }
            //         },
            //         plugins: {
            //             tooltip: {
            //                 callbacks: {
            //                     label: function(context) {
            //                         const xLabel = new Date(context.raw.x).toLocaleDateString();
            //                         const yLabel = new Date(context.raw.y).toLocaleDateString();
            //                         return `Order Date: ${xLabel}\nDelivery Date: ${yLabel}`;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // });

            // Create Bar Chart for Average Delivery Time
            const ctx2 = $('#aveDelTimeChart')[0].getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: averageDeliveryTimes.map(item => item.supplier),
                    datasets: [{
                        label: 'Average Delivery Time (days)',
                        data: averageDeliveryTimes.map(item => item.avgDeliveryTime),
                        backgroundColor: 'rgb(114, 61, 70)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Days'
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

function loadCountPerMonth() {
    $.ajax({
        url: '../includes/retrieve.php?view=average',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            
            const { labels, counts } = processCountPerMonth(response);
            console.log("labels:", labels);
            console.log("counts:", counts);
            // Create Bar Chart
            const ctx =  $('#ordersPerMonthChart')[0].getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Order Count',
                        data: counts,
                        backgroundColor: 'rgb(114, 61, 70, 0.8)'
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


function processData(data) {
    const purchaseOrders = data.purchaseOrders;
    const suppliers = data.suppliers;

    // Process order delivery data
    const orderDeliveryData = purchaseOrders.map(order => ({
        x: new Date(order.OrderDate).getTime(),
        y: new Date(order.DeliveryDate).getTime()
    }));

    // Calculate average delivery time for each supplier
    const deliveryTimes = {};
    purchaseOrders.forEach(order => {
        const supplier = order.SupplierID;
        const orderDate = new Date(order.OrderDate).getTime();
        const deliveryDate = new Date(order.DeliveryDate).getTime();
        const deliveryTime = (deliveryDate - orderDate) / (1000 * 60 * 60 * 24); // in days

        if (!deliveryTimes[supplier]) {
            deliveryTimes[supplier] = { total: 0, count: 0 };
        }
        deliveryTimes[supplier].total += deliveryTime;
        deliveryTimes[supplier].count += 1;
    });

    const averageDeliveryTimes = Object.keys(deliveryTimes).map(supplierID => {
        const supplier = suppliers.find(s => s.SupplierID == supplierID);
        return {
            supplier: supplier ? supplier.SupplierName : `Supplier ${supplierID}`,
            avgDeliveryTime: deliveryTimes[supplierID].total / deliveryTimes[supplierID].count
        };
    });

    return { orderDeliveryData, averageDeliveryTimes };
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
