<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .primary-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
        }
        .tabs-container {
            width: 200px;
        }
        .tabs {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .tab {
            cursor: pointer;
            padding: 10px;
            background-color: #ddd;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .tab.active {
            background-color: #bbb;
        }
        .division {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            color: #fff;
            display: none;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }
        .contact-information {
            background-color: #ff4d4d;
            height: 120px;
        }
        .previous-sales {
            background-color: #4d94ff;
            height: 180px;
        }
        .market-container {
            background-color: #85e085;
            padding: 15px;
            border-radius: 5px;
        }
        .marketing-graph {
            background-color: #4d804d;
            height: 100px;
        }
        .marketing-list {
            background-color: #ffff66;
            height: 140px;
        }
    </style>
</head>
<body>
    <div class="primary-container">
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab active" data-target="contact-information">Contact Information</li>
                <li class="tab" data-target="previous-sales">Previous Sales</li>
            </ul>
        </div>
        <div class="content-container">
            <div class="division contact-information" style="display: block;">Contact Information<br>(Graph/Table Placeholder)</div>
            <div class="division previous-sales">Previous Sales<br>(Graph/Table Placeholder)</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab');
            const divisions = document.querySelectorAll('.division');

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');
                    tabs.forEach(tab => tab.classList.remove('active'));
                    divisions.forEach(division => division.style.display = 'none');
                    document.querySelector('.' + target).style.display = 'block';
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
