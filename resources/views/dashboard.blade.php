<!DOCTYPE html>
<html>
<head>
    <title>CryptoInvestment Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            font-family: Arial, sans-serif;
            margin:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #ddd;
            padding:10px;
        }

        th{
            background:#f4f4f4;
        }
    </style>
</head>
<body>

<h1>CryptoInvestment Dashboard</h1>

<input
    type="text"
    id="search"
    placeholder="Search cryptocurrency..."
>

<br><br>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Symbol</th>
            <th>Price USD</th>
            <th>24h Change</th>
            <th>Volume</th>
        </tr>
    </thead>

    <tbody id="cryptoTable"></tbody>
</table>

<br>

<canvas id="cryptoChart"></canvas>

<script>

let chart;

async function loadCryptos()
{
    const response =
        await fetch('/cryptocurrencies');

    const result =
        await response.json();

    const data =
        result.data;

    renderTable(data);
    renderChart(data);
}

function renderTable(data)
{
    const table =
        document.getElementById('cryptoTable');

    table.innerHTML = '';

    data.forEach(crypto => {

        table.innerHTML += `
            <tr>
                <td>${crypto.name}</td>
                <td>${crypto.symbol}</td>
                <td>$${crypto.quote.USD.price.toFixed(2)}</td>
                <td>${crypto.quote.USD.percent_change_24h.toFixed(2)}%</td>
                <td>${crypto.quote.USD.volume_24h.toFixed(0)}</td>
            </tr>
        `;
    });
}

function renderChart(data)
{
    const ctx =
        document.getElementById('cryptoChart');

    const labels =
        data.slice(0,10).map(c => c.symbol);

    const prices =
        data.slice(0,10).map(
            c => c.quote.USD.price
        );

    if(chart){
        chart.destroy();
    }

    chart = new Chart(ctx,{
        type:'bar',
        data:{
            labels,
            datasets:[{
                label:'Price USD',
                data:prices
            }]
        }
    });
}

loadCryptos();

setInterval(
    loadCryptos,
    60000
);

</script>

</body>
</html>