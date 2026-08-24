<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <title>Command History | Artisan Runner</title>

    <link
        rel="preconnect"
        href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=inter:400,500,600,700"
        rel="stylesheet">

    <style>
        :root {
            --bg: #f1f5f9;
            --card: #ffffff;
            --border: #e2e8f0;
            --text: #1e293b;
            --muted: #64748b;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        .container {
            max-width: 1250px;
            margin: auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: .3rem;
        }

        .header p {
            color: var(--muted);
        }

        .actions {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            border: none;
            border-radius: 9px;
            padding: .65rem 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            font-size: .9rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-products {
            background: #059669;
            color: white;
        }

        .btn-products:hover {
            background: #047857;
        }

        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-danger:hover {
            background: #fecaca;
        }

        .btn-secondary {
            background: white;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
        }

        .stat-label {
            font-size: .8rem;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 600;
            letter-spacing: .04em;
        }

        .stat-value {
            font-size: 1.7rem;
            font-weight: 700;
            margin-top: .3rem;
        }

        .success-text {
            color: #059669;
        }

        .danger-text {
            color: #dc2626;
        }

        .primary-text {
            color: var(--primary);
        }

        .filter-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto auto;
            gap: .75rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: .4rem;
        }

        .form-group label {
            font-size: .8rem;
            font-weight: 600;
            color: var(--muted);
        }

        input,
        select {
            width: 100%;
            padding: .65rem .75rem;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: white;
            color: var(--text);
            font-size: .9rem;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }

        .table-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .table-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-size: 1rem;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            color: var(--muted);
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 700;
            text-align: left;
            padding: .85rem 1rem;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            font-size: .875rem;
            vertical-align: top;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .output-row:hover td {
            background: #0f172a !important;
        }

        .output-row {
            display: none;
            background: #0f172a !important;
        }

        .output-row td {
            padding: 0;
            background: #0f172a !important;
        }

        .output-box {
            padding: 1rem;
            background: #0f172a !important;
            color: #e2e8f0 !important;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: .78rem;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
            max-height: 350px;
            overflow-y: auto;
        }

        .output-box:hover {
            background: #0f172a !important;
            color: #e2e8f0 !important;
        }

        .command-name {
            font-family: ui-monospace, monospace;
            font-weight: 600;
            color: var(--primary);
        }

        .parameters {
            max-width: 220px;
            word-break: break-word;
            color: var(--muted);
            font-family: ui-monospace, monospace;
            font-size: .78rem;
        }

        .status {
            display: inline-flex;
            align-items: center;
            padding: .25rem .65rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
        }

        .status-success {
            background: #dcfce7;
            color: #166534;
        }

        .status-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .duration {
            white-space: nowrap;
            color: var(--muted);
        }

        .date {
            white-space: nowrap;
            color: var(--muted);
            font-size: .8rem;
        }

        .row-actions {
            display: flex;
            gap: .4rem;
        }

        .view-btn {
            border: 1px solid var(--border);
            background: white;
            color: var(--primary);
            padding: .4rem .65rem;
            border-radius: 7px;
            cursor: pointer;
            font-size: .75rem;
            font-weight: 600;
        }

        .delete-btn {
            border: none;
            background: #fee2e2;
            color: #991b1b;
            padding: .4rem .65rem;
            border-radius: 7px;
            cursor: pointer;
            font-size: .75rem;
            font-weight: 600;
        }

        .empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }

        .alert {
            padding: 1rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .pagination {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 1000px) {

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media (max-width: 650px) {

            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .actions {
                width: 100%;
            }

            .actions .btn {
                flex: 1;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        {{-- HEADER --}}
        <div class="header">

            <div>

                <h1>
                    Artisan Command History
                </h1>

                <p>
                    Track and review previous Artisan command executions.
                </p>

            </div>


            {{-- HEADER ACTIONS --}}
            <div class="actions">

                {{-- PRODUCTS BUTTON --}}
                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-products">

                    📦 Products

                </a>


                {{-- COMMAND RUNNER --}}
                <a
                    href="{{ route('command.form') }}"
                    class="btn btn-primary">

                    ← Command Runner

                </a>


                {{-- CLEAR HISTORY --}}
                @if ($totalExecutions > 0)

                <form
                    action="{{ route('command.history.clear') }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete all command history?');">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger">

                        Clear History

                    </button>

                </form>

                @endif

            </div>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif


        {{-- STATISTICS --}}
        <div class="stats">

            <div class="stat-card">

                <div class="stat-label">
                    Total Executions
                </div>

                <div class="stat-value primary-text">
                    {{ number_format($totalExecutions) }}
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-label">
                    Successful
                </div>

                <div class="stat-value success-text">
                    {{ number_format($successfulExecutions) }}
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-label">
                    Failed
                </div>

                <div class="stat-value danger-text">
                    {{ number_format($failedExecutions) }}
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-label">
                    Average Duration
                </div>

                <div class="stat-value">

                    {{ $averageDuration
                    ? number_format($averageDuration, 2) . ' ms'
                    : '0 ms' }}

                </div>

            </div>

        </div>


        {{-- FILTER --}}
        <div class="filter-card">

            <form
                action="{{ route('command.history') }}"
                method="GET"
                class="filter-form">

                <div class="form-group">

                    <label for="search">
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search command or parameters...">

                </div>


                <div class="form-group">

                    <label for="command">
                        Command
                    </label>

                    <select
                        id="command"
                        name="command">

                        <option value="">
                            All Commands
                        </option>

                        @foreach ($commands as $cmd => $label)

                        <option
                            value="{{ $cmd }}"
                            {{ $command === $cmd ? 'selected' : '' }}>

                            {{ $label }}

                        </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status">

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="success"
                            {{ $status === 'success' ? 'selected' : '' }}>

                            Successful

                        </option>

                        <option
                            value="failed"
                            {{ $status === 'failed' ? 'selected' : '' }}>

                            Failed

                        </option>

                    </select>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary">

                    Search

                </button>


                <a
                    href="{{ route('command.history') }}"
                    class="btn btn-secondary">

                    Reset

                </a>

            </form>

        </div>


        {{-- HISTORY TABLE --}}
        <div class="table-card">

            <div class="table-header">

                <h2>
                    Execution Records
                </h2>

                <span>
                    {{ $histories->total() }} result(s)
                </span>

            </div>


            @if ($histories->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Command
                            </th>

                            <th>
                                Parameters
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Duration
                            </th>

                            <th>
                                Exit Code
                            </th>

                            <th>
                                Executed At
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($histories as $history)

                        <tr>

                            <td>

                                <div class="command-name">

                                    php artisan
                                    {{ $history->command }}

                                </div>

                            </td>


                            <td>

                                @if ($history->parameters)

                                <div class="parameters">
                                    {{ $history->parameters }}
                                </div>

                                @else

                                <span style="color:#94a3b8;">
                                    No parameters
                                </span>

                                @endif

                            </td>


                            <td>

                                <span
                                    class="status {{ $history->status === 'success'
                                            ? 'status-success'
                                            : 'status-failed' }}">

                                    {{ strtoupper($history->status) }}

                                </span>

                            </td>


                            <td>

                                <span class="duration">
                                    {{ $history->formatted_duration }}
                                </span>

                            </td>


                            <td>
                                {{ $history->exit_code ?? '-' }}
                            </td>


                            <td>

                                <div class="date">
                                    {{ $history->created_at->format('d M Y') }}
                                </div>

                                <div class="date">
                                    {{ $history->created_at->format('h:i:s A') }}
                                </div>

                            </td>


                            <td>

                                <div class="row-actions">

                                    <button
                                        type="button"
                                        class="view-btn"
                                        onclick="toggleOutput('output-{{ $history->id }}')">

                                        View Output

                                    </button>


                                    <form
                                        action="{{ route('command.history.delete', $history) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this history record?');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="delete-btn">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                        {{-- OUTPUT --}}
                        <tr
                            id="output-{{ $history->id }}"
                            class="output-row">

                            <td colspan="7">

                                <div class="output-box">

                                    {{ $history->output ?: 'No command output available.' }}

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            <div class="pagination">

                {{ $histories->links() }}

            </div>

            @else

            <div class="empty">

                <h3>
                    No command history found
                </h3>

                <p>
                    Execute an Artisan command to create your first history record.
                </p>

            </div>

            @endif

        </div>

    </div>


    <script>
        function toggleOutput(id) {

            const row = document.getElementById(id);

            if (!row) {
                return;
            }

            if (row.style.display === 'table-row') {

                row.style.display = 'none';

            } else {

                row.style.display = 'table-row';

            }

        }
    </script>

</body>

</html>