<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Material Design CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Theme Utilities -->
    <script src="assets/js/theme-utils.js" defer></script>
    <style>
        :root {
            --primary-dark: #0f0f23;
            --secondary-dark: #1a1a2e;
            --accent-purple: #6c5ce7;
            --accent-light: #a29bfe;
            --text-primary: #ffffff;
            --text-secondary: #b2b2b2;
            --glass-bg: rgba(108, 92, 231, 0.1);
            --glass-border: rgba(108, 92, 231, 0.2);
            --card-bg: rgba(26, 26, 46, 0.8);
            --nav-bg: rgba(15, 15, 35, 0.95);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 50%, #16213e 100%);
            min-height: 100vh;
            color: var(--text-primary);
        }

        /* Navigation Styles */
        nav {
            background: var(--nav-bg) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        nav .brand-logo {
            color: var(--accent-light) !important;
            font-weight: 600;
            text-shadow: 0 0 10px rgba(108, 92, 231, 0.3);
        }

        nav ul a {
            color: var(--text-primary) !important;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 5px;
        }

        nav ul a:hover {
            background: var(--glass-bg) !important;
            color: var(--accent-light) !important;
        }

        /* Card Styles */
        .card {
            background: var(--card-bg) !important;
            backdrop-filter: blur(20px);
            border-radius: 15px !important;
            border: 1px solid var(--glass-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
            color: var(--text-primary);
        }

        .card-title {
            color: var(--accent-light) !important;
            font-weight: 600;
        }

        .card-content p {
            color: var(--text-secondary);
        }

        .card-action a {
            color: var(--accent-light) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .card-action a:hover {
            color: var(--text-primary) !important;
            text-shadow: 0 0 10px rgba(108, 92, 231, 0.5);
        }

        /* Button Styles */
        .btn {
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)) !important;
            border-radius: 25px !important;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
            border: none;
            transition: all 0.3s ease;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4) !important;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid var(--glass-border);
        }

        /* Input Field Styles */
        .input-field input {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px 8px 0 0;
            padding: 15px 10px 5px 10px !important;
            color: var(--text-primary) !important;
            border-bottom: 1px solid var(--glass-border) !important;
        }

        .input-field input:focus {
            border-bottom: 2px solid var(--accent-light) !important;
            box-shadow: 0 1px 0 0 var(--accent-light) !important;
            background: rgba(255, 255, 255, 0.08);
        }

        .input-field label {
            color: var(--text-secondary) !important;
        }

        .input-field input:focus + label {
            color: var(--accent-light) !important;
        }

        /* Select Styles */
        .select-wrapper input.select-dropdown {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            color: var(--text-primary) !important;
            border-bottom: 1px solid var(--glass-border) !important;
        }

        .dropdown-content {
            background: var(--card-bg) !important;
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
        }

        .dropdown-content li > a {
            color: var(--text-primary) !important;
        }

        .dropdown-content li:hover {
            background: var(--glass-bg) !important;
        }

        /* Table Styles */
        table {
            background: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
        }

        table th {
            background: var(--accent-purple) !important;
            color: white !important;
        }

        table td {
            color: var(--text-primary) !important;
            border-bottom: 1px solid var(--glass-border) !important;
        }

        table tr:hover {
            background: var(--glass-bg) !important;
        }

        /* Container Styles */
        .container {
            margin-top: 20px;
        }

        /* Dropdown Menu Styles */
        .dropdown-content {
            background: var(--card-bg) !important;
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .dropdown-content li > a {
            color: var(--text-primary) !important;
            transition: all 0.3s ease;
        }

        .dropdown-content li:hover {
            background: var(--glass-bg) !important;
        }

        /* Modal Styles */
        .modal {
            background: var(--card-bg) !important;
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
        }

        .modal h4 {
            color: var(--accent-light) !important;
        }

        .modal p {
            color: var(--text-secondary) !important;
        }

        /* Indian Rupee Symbol */
        .rupee-symbol {
            font-family: Arial, sans-serif;
            color: var(--accent-light);
        }

        /* Advanced animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Page load animations */
        .container {
            animation: fadeInUp 0.8s ease-out;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(108, 92, 231, 0.2) !important;
        }

        /* Enhanced button hover effects */
        .btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4) !important;
        }

        .btn:active {
            transform: translateY(0) scale(0.98);
        }

        /* Loading states */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid var(--accent-light);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            padding: 15px 20px;
            color: var(--text-primary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            border-left: 4px solid #4CAF50;
        }

        .notification.error {
            border-left: 4px solid #f44336;
        }

        .notification.warning {
            border-left: 4px solid #ff9800;
        }

        /* Tooltip styles */
        .tooltip {
            position: relative;
            cursor: help;
        }

        .tooltip::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--card-bg);
            color: var(--text-primary);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            border: 1px solid var(--glass-border);
        }

        .tooltip::after {
            content: '';
            position: absolute;
            bottom: 115%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: var(--card-bg);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .tooltip:hover::before,
        .tooltip:hover::after {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive adjustments */
        @media only screen and (max-width: 992px) {
            nav .brand-logo {
                font-size: 1.8rem;
            }

            .notification {
                right: 10px;
                left: 10px;
                transform: translateY(-100px);
            }

            .notification.show {
                transform: translateY(0);
            }
        }

        @media only screen and (max-width: 600px) {
            .card {
                margin: 10px 0;
            }

            .btn {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
