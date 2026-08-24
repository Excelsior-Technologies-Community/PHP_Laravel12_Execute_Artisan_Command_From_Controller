<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Products | Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #eef2ff;

            --success: #10b981;
            --success-light: #ecfdf5;

            --danger: #ef4444;
            --danger-light: #fef2f2;

            --warning: #f59e0b;
            --warning-light: #fffbeb;

            --info: #0ea5e9;
            --info-light: #f0f9ff;

            --purple: #7c3aed;
            --purple-light: #f5f3ff;

            --blue: #2563eb;
            --blue-light: #eff6ff;

            --bg: #f5f7fb;
            --card: #ffffff;

            --text: #111827;
            --text-secondary: #475569;
            --muted: #64748b;

            --border: #e5e7eb;
            --border-light: #eef0f4;

            --shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
            --shadow: 0 8px 30px rgba(15, 23, 42, .06);

            --radius: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;

            background:
                radial-gradient(circle at top left,
                    rgba(79, 70, 229, .06),
                    transparent 30%),
                radial-gradient(circle at top right,
                    rgba(124, 58, 237, .04),
                    transparent 25%),
                var(--bg);

            color: var(--text);
            line-height: 1.5;
        }

        button,
        input,
        select {
            font-family: inherit;
        }

        a {
            text-decoration: none;
        }

        /* =========================================================
           MAIN CONTAINER
        ========================================================= */

        .page-container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 32px;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            margin-bottom: 28px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: linear-gradient(135deg,
                    var(--primary),
                    #7c3aed);

            color: white;
            font-size: 27px;

            box-shadow:
                0 10px 25px rgba(79, 70, 229, .25);
        }

        .header-content h1 {
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .header-content p {
            color: var(--muted);
            font-size: 14px;
            margin-top: 3px;
        }

        /* =========================================================
           HEADER ACTIONS
        ========================================================= */

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /*
        Modern Header Action Button
        */

        .header-action {
            position: relative;

            display: inline-flex;
            align-items: center;
            gap: 10px;

            min-height: 48px;
            padding: 8px 15px 8px 9px;

            border-radius: 13px;

            font-size: 13px;
            font-weight: 700;

            border: 1px solid transparent;

            cursor: pointer;

            overflow: hidden;

            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease,
                background .25s ease;
        }

        .header-action:hover {
            transform: translateY(-3px);
        }

        .header-action:active {
            transform: translateY(-1px);
        }

        /*
        Icon Box
        */

        .header-action-icon {
            width: 32px;
            height: 32px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            transition:
                transform .25s ease,
                background .25s ease;
        }

        .header-action:hover .header-action-icon {
            transform: scale(1.08);
        }

        /*
        SVG
        */

        .header-action svg {
            width: 17px;
            height: 17px;
            stroke-width: 2;
        }

        /*
        Text
        */

        .header-action-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 1.15;
        }

        .header-action-title {
            font-size: 13px;
            font-weight: 800;
        }

        .header-action-subtitle {
            margin-top: 3px;
            font-size: 10px;
            font-weight: 600;
            opacity: .65;
        }

        /*
        Arrow
        */

        .header-action-arrow {
            margin-left: 2px;
            opacity: .55;

            transition:
                transform .25s ease,
                opacity .25s ease;
        }

        .header-action:hover .header-action-arrow {
            transform: translateX(3px);
            opacity: 1;
        }

        /* =========================================================
           ARTISAN BUTTON
        ========================================================= */

        .btn-artisan {
            color: #6d28d9;

            background:
                linear-gradient(135deg,
                    #ffffff 0%,
                    #faf7ff 100%);

            border-color: #ddd6fe;

            box-shadow:
                0 4px 12px rgba(109, 40, 217, .08),
                inset 0 1px 0 rgba(255, 255, 255, .8);
        }

        .btn-artisan .header-action-icon {
            background: linear-gradient(135deg,
                    #ede9fe,
                    #ddd6fe);

            color: #6d28d9;
        }

        .btn-artisan:hover {
            color: #5b21b6;

            background:
                linear-gradient(135deg,
                    #faf7ff,
                    #f3e8ff);

            border-color: #c4b5fd;

            box-shadow:
                0 12px 25px rgba(109, 40, 217, .14),
                0 3px 8px rgba(109, 40, 217, .08);
        }

        /* =========================================================
           COMMAND HISTORY BUTTON
        ========================================================= */

        .btn-history {
            color: #1d4ed8;

            background:
                linear-gradient(135deg,
                    #ffffff 0%,
                    #f7fbff 100%);

            border-color: #bfdbfe;

            box-shadow:
                0 4px 12px rgba(37, 99, 235, .08),
                inset 0 1px 0 rgba(255, 255, 255, .8);
        }

        .btn-history .header-action-icon {
            background: linear-gradient(135deg,
                    #dbeafe,
                    #bfdbfe);

            color: #2563eb;
        }

        .btn-history:hover {
            color: #1e40af;

            background:
                linear-gradient(135deg,
                    #f7fbff,
                    #eff6ff);

            border-color: #93c5fd;

            box-shadow:
                0 12px 25px rgba(37, 99, 235, .14),
                0 3px 8px rgba(37, 99, 235, .08);
        }

        /* =========================================================
           COMMON BUTTONS
        ========================================================= */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            border: none;
            border-radius: 10px;

            padding: 11px 16px;

            font-size: 13px;
            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;

            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--primary);
            color: white;

            box-shadow:
                0 5px 15px rgba(79, 70, 229, .18);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: white;
            color: var(--text-secondary);

            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .btn-success {
            background: var(--success-light);
            color: #047857;

            border: 1px solid #a7f3d0;
        }

        .btn-success:hover {
            background: #d1fae5;
        }

        .btn-danger {
            background: var(--danger-light);
            color: #b91c1c;

            border: 1px solid #fecaca;
        }

        .btn-danger:hover {
            background: #fee2e2;
        }

        /* =========================================================
           ALERT
        ========================================================= */

        .alert {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 14px 16px;

            border-radius: 12px;

            margin-bottom: 22px;

            font-size: 14px;
            font-weight: 600;
        }

        .alert-success {
            background: var(--success-light);
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: var(--danger-light);
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* =========================================================
           STATISTICS
        ========================================================= */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
            margin-bottom: 22px;
        }

        .stat-card {
            position: relative;

            background: white;
            border: 1px solid var(--border);

            border-radius: var(--radius);

            padding: 19px;

            box-shadow: var(--shadow-sm);

            overflow: hidden;

            transition: .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .stat-card::after {
            content: '';

            position: absolute;

            right: -25px;
            bottom: -35px;

            width: 90px;
            height: 90px;

            border-radius: 50%;

            background: var(--primary-light);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 12px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 17px;
        }

        .icon-primary {
            background: var(--primary-light);
            color: var(--primary);
        }

        .icon-success {
            background: var(--success-light);
            color: #059669;
        }

        .icon-warning {
            background: var(--warning-light);
            color: #d97706;
        }

        .icon-danger {
            background: var(--danger-light);
            color: #dc2626;
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .06em;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 800;

            margin-top: 3px;

            position: relative;
            z-index: 2;
        }

        .text-primary {
            color: var(--primary);
        }

        .text-success {
            color: #059669;
        }

        .text-danger {
            color: #dc2626;
        }

        .text-warning {
            color: #d97706;
        }

        /* =========================================================
           FILTER CARD
        ========================================================= */

        .filter-card {
            background: white;

            border: 1px solid var(--border);

            border-radius: var(--radius);

            padding: 22px;

            margin-bottom: 22px;

            box-shadow: var(--shadow-sm);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 20px;
        }

        .filter-title {
            display: flex;
            align-items: center;

            gap: 10px;

            font-size: 16px;
            font-weight: 800;
        }

        .filter-title-icon {
            width: 34px;
            height: 34px;

            border-radius: 9px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--primary-light);
            color: var(--primary);
        }

        .filter-subtitle {
            color: var(--muted);
            font-size: 12px;
        }

        .filter-grid {
            display: grid;

            grid-template-columns:
                2fr 1fr 1fr 1fr 1fr;

            gap: 14px;
        }

        .form-group {
            display: flex;
            flex-direction: column;

            gap: 7px;
        }

        .form-group label {
            font-size: 11px;

            font-weight: 700;

            color: var(--text-secondary);
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 12px;
            top: 50%;

            transform: translateY(-50%);

            color: #94a3b8;

            font-size: 13px;

            pointer-events: none;
        }

        input,
        select {
            width: 100%;
            height: 42px;

            padding: 0 12px;

            border: 1px solid var(--border);

            border-radius: 10px;

            background: #fff;

            color: var(--text);

            font-size: 13px;

            outline: none;

            transition: .2s ease;
        }

        .input-wrapper input {
            padding-left: 36px;
        }

        input:focus,
        select:focus {
            border-color: var(--primary);

            box-shadow:
                0 0 0 3px rgba(79, 70, 229, .09);
        }

        input::placeholder {
            color: #a1aab8;
        }

        .filter-actions {
            display: flex;
            align-items: center;

            gap: 9px;

            margin-top: 18px;

            padding-top: 18px;

            border-top: 1px solid var(--border-light);
        }

        /* =========================================================
           TABLE CARD
        ========================================================= */

        .table-card {
            background: white;

            border: 1px solid var(--border);

            border-radius: var(--radius);

            overflow: hidden;

            box-shadow: var(--shadow-sm);
        }

        .table-header {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 15px;

            padding: 18px 20px;

            border-bottom: 1px solid var(--border-light);
        }

        .table-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-title h2 {
            font-size: 16px;
            font-weight: 800;
        }

        .product-count {
            display: inline-flex;

            padding: 4px 9px;

            border-radius: 999px;

            background: var(--primary-light);
            color: var(--primary);

            font-size: 11px;
            font-weight: 800;
        }

        .result-info {
            color: var(--muted);

            font-size: 12px;

            margin-top: 3px;
        }

        .table-header-actions {
            display: flex;

            align-items: center;

            gap: 10px;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 1100px;
        }

        th {
            background: #f8fafc;

            color: #64748b;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: .07em;

            font-weight: 800;

            text-align: left;

            padding: 12px 16px;

            border-bottom: 1px solid var(--border);

            white-space: nowrap;
        }

        td {
            padding: 15px 16px;

            border-bottom: 1px solid #f1f5f9;

            font-size: 13px;

            vertical-align: middle;
        }

        tbody tr {
            transition: .15s ease;
        }

        tbody tr:hover {
            background: #fafbff;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* =========================================================
           CHECKBOX
        ========================================================= */

        input[type="checkbox"] {
            width: 16px;
            height: 16px;

            accent-color: var(--primary);

            cursor: pointer;
        }

        /* =========================================================
           PRODUCT
        ========================================================= */

        .product-id {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-width: 34px;
            height: 28px;

            padding: 0 8px;

            border-radius: 7px;

            background: var(--primary-light);
            color: var(--primary);

            font-size: 11px;
            font-weight: 800;
        }

        .product-info {
            display: flex;

            align-items: center;

            gap: 11px;
        }

        .product-avatar {
            width: 38px;
            height: 38px;

            flex-shrink: 0;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(135deg,
                    #eef2ff,
                    #e0e7ff);

            color: var(--primary);

            font-size: 15px;
            font-weight: 800;
        }

        .product-name {
            font-size: 13px;

            font-weight: 700;

            color: var(--text);
        }

        .product-meta {
            color: #94a3b8;

            font-size: 11px;

            margin-top: 2px;
        }

        /* =========================================================
           CATEGORY
        ========================================================= */

        .category-badge {
            display: inline-flex;

            align-items: center;

            padding: 5px 9px;

            border-radius: 7px;

            background: #f0f9ff;

            color: #0369a1;

            font-size: 11px;

            font-weight: 700;
        }

        .empty-category {
            color: #cbd5e1;
        }

        /* =========================================================
           PRICE
        ========================================================= */

        .price {
            font-weight: 800;

            color: #111827;

            white-space: nowrap;
        }

        /* =========================================================
           STOCK
        ========================================================= */

        .stock-badge {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 5px 9px;

            border-radius: 999px;

            font-size: 10px;

            font-weight: 800;

            white-space: nowrap;
        }

        .stock-dot {
            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: currentColor;
        }

        .stock-good {
            background: #ecfdf5;
            color: #047857;
        }

        .stock-low {
            background: #fffbeb;
            color: #b45309;
        }

        .stock-out {
            background: #fef2f2;
            color: #b91c1c;
        }

        /* =========================================================
           DESCRIPTION
        ========================================================= */

        .description {
            max-width: 260px;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.5;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;
        }

        /* =========================================================
           DATE
        ========================================================= */

        .created-date {
            white-space: nowrap;

            color: var(--text-secondary);

            font-size: 12px;

            font-weight: 600;
        }

        /* =========================================================
           ROW ACTION
        ========================================================= */

        .row-actions {
            display: flex;
            align-items: center;
        }

        .delete-btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 5px;

            border: 1px solid #fecaca;

            background: #fff;

            color: #dc2626;

            padding: 7px 10px;

            border-radius: 8px;

            cursor: pointer;

            font-size: 11px;

            font-weight: 700;

            transition: .2s ease;
        }

        .delete-btn:hover {
            background: #fef2f2;

            border-color: #fca5a5;

            transform: translateY(-1px);
        }

        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination-container {
            display: flex;

            justify-content: center;

            align-items: center;

            padding: 18px 20px;

            border-top: 1px solid var(--border-light);
        }

        .pagination-wrapper {
            display: flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

            flex-wrap: wrap;
        }

        .pagination-link {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-width: 36px;
            height: 36px;

            padding: 0 8px;

            border: 1px solid var(--border);

            border-radius: 9px;

            background: white;

            color: var(--text-secondary);

            font-size: 12px;

            font-weight: 700;

            transition: .2s ease;
        }

        .pagination-link:hover {
            border-color: var(--primary);

            background: var(--primary-light);

            color: var(--primary);

            transform: translateY(-1px);
        }

        .pagination-link.active {
            background: var(--primary);

            border-color: var(--primary);

            color: white;

            box-shadow:
                0 4px 10px rgba(79, 70, 229, .2);
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-state {
            text-align: center;

            padding: 70px 20px;

            color: var(--muted);
        }

        .empty-icon {
            width: 70px;
            height: 70px;

            margin: 0 auto 18px;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f8fafc;

            font-size: 30px;
        }

        .empty-state h3 {
            font-size: 17px;

            color: var(--text);

            margin-bottom: 5px;
        }

        .empty-state p {
            font-size: 13px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1250px) {

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .filter-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 850px) {

            .page-container {
                padding: 20px;
            }

            .page-header {
                align-items: flex-start;

                flex-direction: column;
            }

            .header-actions {
                width: 100%;
            }

            .header-action {
                flex: 1;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-header {
                align-items: flex-start;

                flex-direction: column;
            }

            .table-header-actions {
                width: 100%;
            }
        }

        @media (max-width: 550px) {

            .page-container {
                padding: 14px;
            }

            .header-left {
                align-items: flex-start;
            }

            .header-icon {
                width: 48px;
                height: 48px;

                font-size: 21px;
            }

            .header-content h1 {
                font-size: 22px;
            }

            .header-actions {
                flex-direction: column;
            }

            .header-action {
                width: 100%;
                flex: none;

                justify-content: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .filter-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-actions .btn {
                width: 100%;
            }

            .table-header-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .table-header-actions .btn {
                width: 100%;
            }

            .pagination-link {
                min-width: 32px;
                height: 32px;

                font-size: 11px;
            }
        }
    </style>
</head>

<body>

    <div class="page-container">

        {{-- =========================================================
        HEADER
    ========================================================== --}}

        <div class="page-header">

            <div class="header-left">

                <div class="header-icon">
                    📦
                </div>

                <div class="header-content">

                    <h1>
                        Products
                    </h1>

                    <p>
                        Manage your inventory with powerful filters and bulk actions.
                    </p>

                </div>

            </div>


            {{-- =====================================================
            MODERN HEADER ACTIONS
        ====================================================== --}}

            <div class="header-actions">

                {{-- Artisan Runner --}}

                <a href="{{ route('command.form') }}"
                    class="header-action btn-artisan">

                    <span class="header-action-icon">

                        <svg viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <path d="M4 17l6-6-6-6" />

                            <path d="M12 19h8" />

                        </svg>

                    </span>

                    <span class="header-action-content">

                        <span class="header-action-title">
                            Artisan Runner
                        </span>

                        <span class="header-action-subtitle">
                            Run commands
                        </span>

                    </span>

                    <span class="header-action-arrow">
                        →
                    </span>

                </a>


                {{-- Command History --}}

                <a href="{{ route('command.history') }}"
                    class="header-action btn-history">

                    <span class="header-action-icon">

                        <svg viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <path d="M3 12a9 9 0 1 0 3-6.7" />

                            <path d="M3 4v5h5" />

                            <path d="M12 7v5l3 2" />

                        </svg>

                    </span>

                    <span class="header-action-content">

                        <span class="header-action-title">
                            Command History
                        </span>

                        <span class="header-action-subtitle">
                            View previous commands
                        </span>

                    </span>

                    <span class="header-action-arrow">
                        →
                    </span>

                </a>

            </div>

        </div>


        {{-- =========================================================
        ALERTS
    ========================================================== --}}

        @if(session('success'))

        <div class="alert alert-success">

            <span>✓</span>

            {{ session('success') }}

        </div>

        @endif


        @if(session('error'))

        <div class="alert alert-error">

            <span>!</span>

            {{ session('error') }}

        </div>

        @endif


        {{-- =========================================================
        STATISTICS
    ========================================================== --}}

        <div class="stats-grid">

            {{-- Total Products --}}

            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-label">
                        Total Products
                    </div>

                    <div class="stat-icon icon-primary">
                        📦
                    </div>

                </div>

                <div class="stat-value text-primary">
                    {{ number_format($totalProducts) }}
                </div>

            </div>


            {{-- Total Stock --}}

            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-label">
                        Total Stock
                    </div>

                    <div class="stat-icon icon-success">
                        📊
                    </div>

                </div>

                <div class="stat-value">
                    {{ number_format($totalStock) }}
                </div>

            </div>


            {{-- Inventory Value --}}

            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-label">
                        Inventory Value
                    </div>

                    <div class="stat-icon icon-warning">
                        ₹
                    </div>

                </div>

                <div class="stat-value">
                    ₹{{ number_format($totalValue, 2) }}
                </div>

            </div>


            {{-- Average Price --}}

            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-label">
                        Average Price
                    </div>

                    <div class="stat-icon icon-primary">
                        📈
                    </div>

                </div>

                <div class="stat-value">
                    ₹{{ number_format($averagePrice ?? 0, 2) }}
                </div>

            </div>


            {{-- In Stock --}}

            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-label">
                        In Stock
                    </div>

                    <div class="stat-icon icon-success">
                        ✓
                    </div>

                </div>

                <div class="stat-value text-success">
                    {{ number_format($inStockProducts) }}
                </div>

            </div>


            {{-- Out of Stock --}}

            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-label">
                        Out of Stock
                    </div>

                    <div class="stat-icon icon-danger">
                        !
                    </div>

                </div>

                <div class="stat-value text-danger">
                    {{ number_format($outOfStockProducts) }}
                </div>

            </div>

        </div>


        {{-- =========================================================
        ADVANCED FILTERS
    ========================================================== --}}

        <div class="filter-card">

            <div class="filter-header">

                <div>

                    <div class="filter-title">

                        <span class="filter-title-icon">
                            🔍
                        </span>

                        Advanced Filters

                    </div>

                    <div class="filter-subtitle">
                        Filter and sort your products
                    </div>

                </div>

            </div>


            <form action="{{ route('products.index') }}"
                method="GET">

                <div class="filter-grid">

                    {{-- Search --}}

                    <div class="form-group">

                        <label for="search">
                            SEARCH
                        </label>

                        <div class="input-wrapper">

                            <span class="input-icon">
                                🔍
                            </span>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search product or category...">

                        </div>

                    </div>


                    {{-- Category --}}

                    <div class="form-group">

                        <label for="category">
                            CATEGORY
                        </label>

                        <select id="category"
                            name="category">

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $cat)

                            <option
                                value="{{ $cat }}"
                                {{ $category == $cat ? 'selected' : '' }}>

                                {{ $cat }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Minimum Price --}}

                    <div class="form-group">

                        <label for="min_price">
                            MIN PRICE
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            id="min_price"
                            name="min_price"
                            value="{{ $minPrice }}"
                            placeholder="₹ Minimum">

                    </div>


                    {{-- Maximum Price --}}

                    <div class="form-group">

                        <label for="max_price">
                            MAX PRICE
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            id="max_price"
                            name="max_price"
                            value="{{ $maxPrice }}"
                            placeholder="₹ Maximum">

                    </div>


                    {{-- Stock Status --}}

                    <div class="form-group">

                        <label for="stock_status">
                            STOCK STATUS
                        </label>

                        <select id="stock_status"
                            name="stock_status">

                            <option value="">
                                All Stock
                            </option>

                            <option
                                value="in_stock"
                                {{ $stockStatus == 'in_stock' ? 'selected' : '' }}>

                                ✓ In Stock

                            </option>

                            <option
                                value="low_stock"
                                {{ $stockStatus == 'low_stock' ? 'selected' : '' }}>

                                ⚠ Low Stock

                            </option>

                            <option
                                value="out_of_stock"
                                {{ $stockStatus == 'out_of_stock' ? 'selected' : '' }}>

                                ✕ Out of Stock

                            </option>

                        </select>

                    </div>


                    {{-- Minimum Stock --}}

                    <div class="form-group">

                        <label for="min_stock">
                            MIN STOCK
                        </label>

                        <input
                            type="number"
                            min="0"
                            id="min_stock"
                            name="min_stock"
                            value="{{ $minStock }}"
                            placeholder="Minimum stock">

                    </div>


                    {{-- Maximum Stock --}}

                    <div class="form-group">

                        <label for="max_stock">
                            MAX STOCK
                        </label>

                        <input
                            type="number"
                            min="0"
                            id="max_stock"
                            name="max_stock"
                            value="{{ $maxStock }}"
                            placeholder="Maximum stock">

                    </div>


                    {{-- ID Sort --}}

                    <div class="form-group">

                        <label for="sort">
                            PRODUCT ID
                        </label>

                        <select id="sort"
                            name="sort">

                            <option
                                value="asc"
                                {{ $sort == 'asc' ? 'selected' : '' }}>

                                ↑ ID Ascending

                            </option>

                            <option
                                value="desc"
                                {{ $sort == 'desc' ? 'selected' : '' }}>

                                ↓ ID Descending

                            </option>

                        </select>

                    </div>


                    {{-- Per Page --}}

                    <div class="form-group">

                        <label for="per_page">
                            PER PAGE
                        </label>

                        <select id="per_page"
                            name="per_page">

                            @foreach([5, 10, 20, 50, 100] as $size)

                            <option
                                value="{{ $size }}"
                                {{ $perPage == $size ? 'selected' : '' }}>

                                {{ $size }} Products

                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- Filter Buttons --}}

                <div class="filter-actions">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        🔍 Apply Filters

                    </button>


                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-secondary">

                        ↻ Reset

                    </a>


                    <button
                        type="submit"
                        formaction="{{ route('products.export.csv') }}"
                        class="btn btn-success">

                        📤 Export CSV

                    </button>

                </div>

            </form>

        </div>


        {{-- =========================================================
        PRODUCTS TABLE
    ========================================================== --}}

        <div class="table-card">


            {{-- Table Header --}}

            <div class="table-header">

                <div>

                    <div class="table-title">

                        <h2>
                            Product List
                        </h2>

                        <span class="product-count">
                            {{ number_format($products->total()) }}
                        </span>

                    </div>

                    <div class="result-info">

                        Showing
                        {{ $products->firstItem() ?? 0 }}
                        -
                        {{ $products->lastItem() ?? 0 }}
                        of
                        {{ $products->total() }}
                        products

                    </div>

                </div>


                {{-- Bulk Delete --}}

                <div class="table-header-actions">

                    <form
                        action="{{ route('products.bulk-action') }}"
                        method="POST"
                        id="bulkForm"
                        onsubmit="return confirmBulkDelete();">

                        @csrf

                        <input
                            type="hidden"
                            name="action"
                            value="delete">

                        <button
                            type="submit"
                            class="btn btn-danger">

                            🗑 Delete Selected

                        </button>

                    </form>

                </div>

            </div>


            @if($products->count() > 0)


            {{-- =================================================
                TABLE
            ================================================== --}}

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th width="45">
                                <input
                                    type="checkbox"
                                    id="selectAll">
                            </th>

                            <th>
                                ID
                            </th>

                            <th>
                                Product
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Stock
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                Created
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($products as $product)

                        <tr>

                            {{-- Checkbox --}}

                            <td>

                                <input
                                    type="checkbox"
                                    class="product-checkbox"
                                    name="product_ids[]"
                                    value="{{ $product->id }}"
                                    form="bulkForm">

                            </td>


                            {{-- ID --}}

                            <td>

                                <span class="product-id">

                                    #{{ $product->id }}

                                </span>

                            </td>


                            {{-- Product --}}

                            <td>

                                <div class="product-info">

                                    <div class="product-avatar">

                                        {{ strtoupper(substr($product->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="product-name">

                                            {{ $product->name }}

                                        </div>

                                        <div class="product-meta">

                                            Product #{{ $product->id }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Category --}}

                            <td>

                                @if($product->category)

                                <span class="category-badge">

                                    {{ $product->category }}

                                </span>

                                @else

                                <span class="empty-category">
                                    —
                                </span>

                                @endif

                            </td>


                            {{-- Price --}}

                            <td>

                                <span class="price">

                                    ₹{{ number_format($product->price, 2) }}

                                </span>

                            </td>


                            {{-- Stock --}}

                            <td>

                                @if($product->stock === 0)

                                <span class="stock-badge stock-out">

                                    <span class="stock-dot"></span>

                                    Out of Stock

                                </span>

                                @elseif($product->stock <= 10)

                                    <span class="stock-badge stock-low">

                                    <span class="stock-dot"></span>

                                    {{ $product->stock }} Low

                                    </span>

                                    @else

                                    <span class="stock-badge stock-good">

                                        <span class="stock-dot"></span>

                                        {{ $product->stock }} Available

                                    </span>

                                    @endif

                            </td>


                            {{-- Description --}}

                            <td>

                                <div class="description">

                                    {{ $product->description ?: 'No description available.' }}

                                </div>

                            </td>


                            {{-- Created --}}

                            <td>

                                <span class="created-date">

                                    {{ optional($product->created_at)->format('d M Y') }}

                                </span>

                            </td>


                            {{-- Action --}}

                            <td>

                                <div class="row-actions">

                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="delete-btn">

                                            🗑 Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                NUMBER ONLY PAGINATION
            ================================================== --}}

            <div class="pagination-container">

                <div class="pagination-wrapper">

                    @foreach(
                    $products->getUrlRange(
                    1,
                    $products->lastPage()
                    )
                    as $page => $url
                    )

                    @if($page == $products->currentPage())

                    <span class="pagination-link active">
                        {{ $page }}
                    </span>

                    @else

                    <a
                        href="{{ $url }}"
                        class="pagination-link">

                        {{ $page }}

                    </a>

                    @endif

                    @endforeach

                </div>

            </div>


            @else


            {{-- =================================================
                EMPTY STATE
            ================================================== --}}

            <div class="empty-state">

                <div class="empty-icon">
                    📦
                </div>

                <h3>
                    No products found
                </h3>

                <p>
                    Try changing your search or filter criteria.
                </p>

            </div>


            @endif

        </div>

    </div>


    {{-- =============================================================
    JAVASCRIPT
============================================================== --}}

    <script>
        /*
    |--------------------------------------------------------------------------
    | Select All Products
    |--------------------------------------------------------------------------
    */

        const selectAll = document.getElementById('selectAll');

        if (selectAll) {

            selectAll.addEventListener('change', function() {

                const checkboxes =
                    document.querySelectorAll('.product-checkbox');

                checkboxes.forEach(function(checkbox) {

                    checkbox.checked = selectAll.checked;

                });

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Keep Select All State Updated
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.product-checkbox')
            .forEach(function(checkbox) {

                checkbox.addEventListener('change', function() {

                    const checkboxes =
                        document.querySelectorAll('.product-checkbox');

                    const checked =
                        document.querySelectorAll(
                            '.product-checkbox:checked'
                        );

                    if (selectAll) {

                        selectAll.checked =
                            checkboxes.length === checked.length;

                    }

                });

            });


        /*
        |--------------------------------------------------------------------------
        | Bulk Delete Confirmation
        |--------------------------------------------------------------------------
        */

        function confirmBulkDelete() {

            const selected =
                document.querySelectorAll(
                    '.product-checkbox:checked'
                );

            if (selected.length === 0) {

                alert('Please select at least one product.');

                return false;
            }

            return confirm(
                'Are you sure you want to delete ' +
                selected.length +
                ' selected product(s)?'
            );

        }
    </script>

</body>

</html>