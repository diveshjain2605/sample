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
    <!-- UI Fixes CSS -->
    <link href="ui_fixes.css" rel="stylesheet">
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

        /* Enhanced Button Styles - FIXED ALIGNMENT AND HOVER */
        .btn, .btn-large, .btn-small, .btn-floating {
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)) !important;
            border-radius: 25px !important;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3) !important;
            border: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-weight: 500 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            text-decoration: none !important;
            cursor: pointer !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .btn:hover, .btn-large:hover, .btn-small:hover, .btn-floating:hover {
            transform: translateY(-3px) scale(1.02) !important;
            box-shadow: 0 12px 35px rgba(108, 92, 231, 0.5) !important;
            background: linear-gradient(135deg, var(--accent-light), var(--accent-purple)) !important;
        }

        .btn:active, .btn-large:active, .btn-small:active, .btn-floating:active {
            transform: translateY(-1px) scale(0.98) !important;
            transition: all 0.1s ease !important;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 2px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            border-color: var(--accent-light) !important;
            color: var(--accent-light) !important;
        }

        /* Button ripple effect */
        .btn::before, .btn-large::before, .btn-small::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:active::before, .btn-large:active::before, .btn-small:active::before {
            width: 300px;
            height: 300px;
        }

        /* Enhanced Input Field Styles - FIXED TEXT VISIBILITY */
        .input-field input,
        .input-field textarea {
            background: rgba(255, 255, 255, 0.08) !important;
            border-radius: 8px 8px 0 0;
            padding: 15px 10px 5px 10px !important;
            color: var(--text-primary) !important;
            border-bottom: 2px solid var(--glass-border) !important;
            font-size: 16px !important;
            font-weight: 400 !important;
            text-shadow: none !important;
            -webkit-text-fill-color: var(--text-primary) !important;
            opacity: 1 !important;
        }

        .input-field input:focus,
        .input-field textarea:focus {
            border-bottom: 2px solid var(--accent-light) !important;
            box-shadow: 0 1px 0 0 var(--accent-light) !important;
            background: rgba(255, 255, 255, 0.12) !important;
            color: var(--text-primary) !important;
            -webkit-text-fill-color: var(--text-primary) !important;
        }

        .input-field input:valid,
        .input-field textarea:valid {
            color: var(--text-primary) !important;
            -webkit-text-fill-color: var(--text-primary) !important;
        }

        .input-field input[readonly] {
            background: rgba(255, 255, 255, 0.03) !important;
            color: var(--text-secondary) !important;
            -webkit-text-fill-color: var(--text-secondary) !important;
        }

        .input-field label {
            color: var(--text-secondary) !important;
            font-size: 14px !important;
        }

        .input-field input:focus + label,
        .input-field textarea:focus + label,
        .input-field label.active {
            color: var(--accent-light) !important;
            font-size: 12px !important;
        }

        /* Fix for placeholder text */
        .input-field input::placeholder,
        .input-field textarea::placeholder {
            color: var(--text-secondary) !important;
            opacity: 0.7 !important;
        }

        /* Fix for autofill */
        .input-field input:-webkit-autofill,
        .input-field input:-webkit-autofill:hover,
        .input-field input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--text-primary) !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.08) inset !important;
            transition: background-color 5000s ease-in-out 0s !important;
        }

        /* Enhanced Select Styles - FIXED DROPDOWN VISIBILITY */
        .select-wrapper input.select-dropdown {
            background: rgba(255, 255, 255, 0.08) !important;
            border-radius: 8px;
            color: var(--text-primary) !important;
            border-bottom: 2px solid var(--glass-border) !important;
            font-size: 16px !important;
            padding: 15px 10px 5px 10px !important;
            -webkit-text-fill-color: var(--text-primary) !important;
        }

        .select-wrapper input.select-dropdown:focus {
            border-bottom: 2px solid var(--accent-light) !important;
            background: rgba(255, 255, 255, 0.12) !important;
        }

        .dropdown-content {
            background: var(--card-bg) !important;
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
            z-index: 9999 !important;
        }

        .dropdown-content li {
            min-height: 48px !important;
        }

        .dropdown-content li > a,
        .dropdown-content li > span {
            color: var(--text-primary) !important;
            font-size: 16px !important;
            padding: 14px 16px !important;
            display: block !important;
            line-height: 1.5 !important;
        }

        .dropdown-content li:hover,
        .dropdown-content li.selected {
            background: var(--glass-bg) !important;
        }

        .dropdown-content li.selected > span {
            color: var(--accent-light) !important;
            font-weight: 500 !important;
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

        /* Enhanced Layout and Alignment Fixes */
        .row {
            margin-bottom: 10px;
        }

        .row .col {
            padding: 0 0.75rem;
        }

        /* Fix for form alignment */
        .input-field {
            margin-top: 1rem;
            margin-bottom: 1rem;
            position: relative;
        }

        .input-field .prefix {
            position: absolute;
            width: 3rem;
            font-size: 2rem;
            transition: color 0.2s;
            top: 0.5rem;
            color: var(--text-secondary) !important;
        }

        .input-field .prefix.active {
            color: var(--accent-light) !important;
        }

        .input-field input[type=text],
        .input-field input[type=password],
        .input-field input[type=email],
        .input-field input[type=url],
        .input-field input[type=time],
        .input-field input[type=date],
        .input-field input[type=datetime],
        .input-field input[type=datetime-local],
        .input-field input[type=tel],
        .input-field input[type=number],
        .input-field input[type=search],
        .input-field textarea.materialize-textarea {
            margin-left: 3rem;
            width: calc(100% - 3rem);
        }

        /* Card alignment fixes */
        .card {
            margin: 0.5rem 0 1rem 0;
        }

        .card .card-content {
            padding: 24px;
        }

        .card .card-action {
            padding: 16px 24px;
            border-top: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Button group alignment */
        .btn-group {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .center-align .btn-group {
            justify-content: center;
        }

        .right-align .btn-group {
            justify-content: flex-end;
        }

        /* Table alignment fixes */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            vertical-align: middle;
        }

        table th {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        /* Enhanced responsive design */
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

            .input-field .prefix {
                position: relative;
                width: auto;
                display: block;
                text-align: center;
                margin-bottom: 10px;
            }

            .input-field input[type=text],
            .input-field input[type=password],
            .input-field input[type=email],
            .input-field input[type=url],
            .input-field input[type=time],
            .input-field input[type=date],
            .input-field input[type=datetime],
            .input-field input[type=datetime-local],
            .input-field input[type=tel],
            .input-field input[type=number],
            .input-field input[type=search],
            .input-field textarea.materialize-textarea {
                margin-left: 0;
                width: 100%;
            }
        }

        @media only screen and (max-width: 600px) {
            .card {
                margin: 10px 0;
            }

            .btn, .btn-large {
                width: 100%;
                margin: 8px 0;
                justify-content: center;
            }

            .card .card-action {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                width: 100%;
            }

            table {
                font-size: 14px;
            }

            table th,
            table td {
                padding: 8px 10px;
            }
        }

        /* Invoice System Card Action Buttons */
        .card-action a {
            box-sizing: border-box !important;
        }

        .card-action a:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(108, 92, 231, 0.25) !important;
        }

        .card-action a[style*="background-color: var(--accent-light)"]:hover {
            background-color: var(--accent-purple) !important;
            transform: translateY(-2px) !important;
        }

        .card-action a[style*="background-color: transparent"]:hover {
            background-color: var(--accent-light) !important;
            color: white !important;
            transform: translateY(-2px) !important;
        }

        /* Ensure equal button heights and alignment */
        .card-action[style*="align-items: stretch"] a {
            height: auto !important;
            min-height: 44px !important;
            box-sizing: border-box !important;
        }

        /* Search Button Group Styling */
        .col[style*="display: flex"] button,
        .col[style*="display: flex"] a {
            height: 36px !important;
            line-height: 36px !important;
            padding: 0 16px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            letter-spacing: 0.5px !important;
            border-radius: 18px !important;
            text-align: center !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
        }

        .col[style*="display: flex"] .material-icons {
            font-size: 16px !important;
        }

        /* Responsive design for card actions */
        @media (max-width: 600px) {
            .card-action[style*="display: flex"] {
                flex-direction: column !important;
                gap: 12px !important;
            }

            .card-action a {
                flex: none !important;
                width: 100% !important;
            }

            /* Search buttons responsive */
            .col[style*="display: flex"] {
                flex-direction: column !important;
                gap: 8px !important;
            }

            .col[style*="display: flex"] button,
            .col[style*="display: flex"] a {
                flex: none !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
