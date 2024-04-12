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
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .primary-container {
            display: flex;
            flex-grow: 1;
        }
        .banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            width: 97%;
        }
        .tabs-container {
            display: flex;
            flex-direction: column;
            width: 15%;
            background-color: #ddd;
            padding: 10px;
        }
        .tabs {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
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
        .content-container {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            padding: 0 20px;
            overflow-y: auto;
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
        .marketing-graph {
            background-color: #4d804d;
            height: 100px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            z-index: 1;
        }
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
            color: black;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <div class="banner">
        <div class="dropdown">
            <button class="dropbtn">Select Module</button>
            <div class="dropdown-content">
                <a href="#">ERP</a>
                <a href="#">CRM</a>
                <a href="#">SCM</a>
            </div>
        </div>
        <div id="datetime"></div>
    </div>
    <div class="primary-container">
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab active" data-target="contact-information">Contact Information</li>
                <li class="tab" data-target="previous-sales">Previous Sales</li>
                <li class="tab" data-target="marketing-graph">Marketing Graph</li>
            </ul>
        </div>
        <div class="content-container">
            <div class="division contact-information" style="display: block;">Contact Information<br>(Graph/Table Placeholder)</div>
            <div class="division previous-sales">Previous Sales<br>(Graph/Table Placeholder)</div>
            <div class="division marketing-graph">Marketing Graph<br>(Graph/Table Placeholder)</div>
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

            function updateTime() {
                const now = new Date();
                const datetimeElement = document.getElementById('datetime');
                datetimeElement.innerText = now.toLocaleString();
            }

            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
</body>
</html>
