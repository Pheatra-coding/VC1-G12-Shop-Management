<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Management</title>
    <style>
        /* Base styles for all devices */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px; /* Add padding to prevent content from touching edges */
            box-sizing: border-box; /* Ensure padding is included in the element's total width/height */
        }

        .container {
            text-align: center; /* Center-align content */
            width: 100%; /* Ensure container takes full width */
            max-width: 1200px; /* Limit maximum width for larger screens */
        }

        img {
            width: 100%; /* Make image responsive by default */
            max-width: 600px; /* Limit image size on larger screens */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Media Queries for Responsiveness */

        /* Tablets and smaller desktops */
        @media (max-width: 1024px) {
            img {
                max-width: 500px; /* Slightly smaller image for tablets */
            }
        }

        /* Mobile devices (landscape and portrait) */
        @media (max-width: 768px) {
            img {
                max-width: 400px; /* Smaller image for mobile devices */
            }
        }

        /* Very small devices (e.g., phones in portrait mode) */
        @media (max-width: 480px) {
            img {
                max-width: 300px; /* Even smaller image for very small screens */
            }

            body {
                padding: 10px; /* Reduce padding for very small screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Add an image (replace '404-image.png' with your image path) -->
        <img src="https://img.freepik.com/free-vector/oops-404-error-with-broken-robot-concept-illustration_114360-5529.jpg?ga=GA1.1.1302695939.1736923948&semt=ais_hybrid" alt="404 Not Found">
    </div>
</body>
</html>