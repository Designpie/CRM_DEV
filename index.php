<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .dashboard {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 10px;
            padding: 20px;
            width: 200px;
        }
        .card h2 {
            color: #444;
            margin-top: 0;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Inventory Dashboard</h1>
    
    <div class="dashboard">
        <?php
        // Simulated data (replace with actual database queries)
        $warehouse_count = 5;
        $stock_in = 1000;
        $stock_out = 750;
        $scanned_stock = 2500;

        $dashboard_items = [
            "Warehouses" => $warehouse_count,
            "Stock In" => $stock_in,
            "Stock Out" => $stock_out,
            "Scanned Stock" => $scanned_stock
        ];

        foreach ($dashboard_items as $title => $value) {
            echo "<div class='card'>";
            echo "<h2>$title</h2>";
            echo "<p>$value</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
