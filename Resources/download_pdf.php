<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI Bar Graph to PDF</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fpdf/1.81/fpdf.php"></script>
</head>
<body>

<canvas id="kpiChart" width="400" height="200"></canvas>
<button id="exportPdfBtn">Export to PDF</button>

<script>
    // Create a bar chart using Chart.js
    const ctx = document.getElementById('kpiChart').getContext('2d');
    const kpiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Employee Performance',
                data: [80, 90, 75, 85],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Capture the chart as a base64 image and send to PHP to generate PDF
    document.getElementById('exportPdfBtn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default button behavior

        // Capture the chart image as a base64 string
        const chartImage = kpiChart.toBase64Image();

        // Send the image data to PHP using Fetch API
        fetch('export_pdf.php', { // Make sure to update the PHP script location
            method: 'POST',
            body: JSON.stringify({ chartImage: chartImage }),
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.blob()) // Expecting a PDF response
        .then(pdfBlob => {
            const pdfUrl = URL.createObjectURL(pdfBlob);
            const link = document.createElement('a');
            link.href = pdfUrl;
            link.download = 'KPI_Performance.pdf';
            link.click();
        })
        .catch(error => {
            console.error('Error exporting to PDF:', error);
        });
    });
</script>

</body>
</html>


<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check for incoming POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data sent by the frontend (chart image as base64)
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['chartImage'])) {
        // Get the chart image in base64
        $chartImage = $data['chartImage'];

        // Decode the base64 image
        $imageData = str_replace('data:image/png;base64,', '', $chartImage);
        $imageData = str_replace(' ', '+', $imageData);  // Ensure proper spacing
        $imageContent = base64_decode($imageData);

        if ($imageContent === false) {
            die('Error: Invalid image data.');
        }

        // Save the image to a temporary file
        $imageFile = 'chart_image.png';
        file_put_contents($imageFile, $imageContent);

        // Include the FPDF library
        require('fpdf.php');

        // Create a PDF document
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Employee Performance KPI - Annual Report', 0, 1, 'C');

        // Insert the chart image into the PDF
        if (file_exists($imageFile)) {
            $pdf->Image($imageFile, 10, 30, 190, 100); // Adjust position and size as needed
        } else {
            die('Error: Chart image file not found.');
        }

        // Output the PDF to the browser as a download
        $pdf->Output('D', 'KPI_Performance.pdf');

        // Clean up: Delete the temporary image file
        unlink($imageFile);
    } else {
        die('Error: No chart image received.');
    }
} else {
    die('Invalid request method.');
}
?>
