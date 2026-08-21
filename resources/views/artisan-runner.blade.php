@php
function renderArtisanOutput(string $output, string $command, string $params): string
{
    $lines = explode("\n", $output);
    $html = '<span class="t-line"><span class="t-prompt">$</span><span class="t-cmd">php artisan ' . e($command) . '</span> ' . e($params) . "</span>\n";
    $html .= '<span class="t-line">------------------------------</span>';

    foreach ($lines as $line) {
        $escaped = e($line);
        $class = 't-line';

        if (preg_match('/error|exception|failed|could not|cannot/i', $line)) {
            $class = 't-line t-error';
        } elseif (preg_match('/warning|warn/i', $line)) {
            $class = 't-line t-warn';
        } elseif (preg_match('/success|done|info|migrated|installed|generated|cleared|set successfully|Application cache cleared|Configuration cached/i', $line)) {
            $class = 't-line t-success';
        } elseif (preg_match('/^\s*\d+\s+\-\s+/', $line) || preg_match('/migration|Migration/i', $line)) {
            $class = 't-line t-success';
        } elseif (trim($line) === '') {
            $class = 't-line';
        } else {
            $class = 't-line t-info';
        }

        $html .= '<span class="' . $class . '">' . $escaped . "</span>\n";
    }

    return $html;
}
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artisan Runner | Laravel Command Manager</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --bg: #f1f5f9;
            --card: #ffffff;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-muted: #64748b;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --terminal-bg: #0f172a;
            --terminal-text: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text);
            line-height: 1.5;
        }

        .app {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: var(--card);
            border-right: 1px solid var(--border);
            padding: 1.5rem;
            overflow-y: auto;
            height: 100vh;
            position: sticky;
            top: 0;
        }

        .brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .brand-icon {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: 8px;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 0.9rem;
        }

        .subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .category { margin-bottom: 1.5rem; }

        .category-title {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.75rem;
        }

        .command-list { list-style: none; }

        .command-item { margin-bottom: 0.25rem; }

        .command-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.875rem;
            color: var(--text);
            transition: all 0.15s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .command-link:hover { background: #f1f5f9; }

        .command-link.active {
            background: #dbeafe;
            color: var(--primary);
            font-weight: 500;
        }

        .command-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #cbd5e1;
        }

        .command-link.active .command-dot {
            background: var(--primary);
            box-shadow: 0 0 0 2px #bfdbfe;
        }

        .main {
            padding: 2rem;
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .breadcrumb {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .breadcrumb span {
            color: var(--primary);
            font-weight: 500;
        }

        .card {
            background: var(--card);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text);
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            background: var(--card);
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .help-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover { background: var(--primary-hover); }

        .terminal {
            background: var(--terminal-bg);
            color: var(--terminal-text);
            border-radius: 12px;
            overflow: hidden;
        }

        .terminal-header {
            background: rgba(255, 255, 255, 0.05);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .terminal-dot { width: 12px; height: 12px; border-radius: 50%; }
        .terminal-dot.red { background: #ef4444; }
        .terminal-dot.yellow { background: #f59e0b; }
        .terminal-dot.green { background: #10b981; }

        .terminal-title {
            margin-left: 0.5rem;
            font-size: 0.8rem;
            color: #94a3b8;
            font-family: 'SF Mono', ui-monospace, monospace;
        }

        .terminal-body {
            padding: 1.25rem;
            font-family: ui-monospace, 'SF Mono', 'Fira Code', monospace;
            font-size: 0.85rem;
            line-height: 1.7;
            max-height: 450px;
            overflow-y: auto;
        }

        .terminal-body::-webkit-scrollbar { width: 8px; }
        .terminal-body::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 4px; }
        .terminal-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        .terminal-body::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }

        .t-line { display: block; white-space: pre-wrap; word-break: break-word; }
        .t-prompt { color: #10b981; }
        .t-cmd { color: #60a5fa; }
        .t-info { color: #94a3b8; }
        .t-warn { color: #fbbf24; }
        .t-error { color: #f87171; }
        .t-success { color: #34d399; }

        .empty {
            color: #475569;
            font-style: italic;
            text-align: center;
            padding: 4rem 2rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #450a0a;
            border: 1px solid #fecaca;
        }

        .alert-icon { font-size: 1.25rem; line-height: 1; flex-shrink: 0; }

        .footer {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--text-muted);
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.75rem;
            font-size: 0.8rem;
            color: #64748b;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .status-chip.success { background: #dcfce7; color: #166534; }
        .status-chip.error { background: #fee2e2; color: #991b1b; }

        @media (max-width: 768px) {
            .app { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">A</div>
                Artisan Runner
            </div>
            <p class="subtitle">Laravel Command Manager</p>

            <div class="category">
                <div class="category-title">Database</div>
                <ul class="command-list">
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'migrate:status']) }}" class="command-link {{ ($selectedCommand ?? '') === 'migrate:status' ? 'active' : '' }}"><span>Migration Status</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'migrate']) }}" class="command-link {{ ($selectedCommand ?? '') === 'migrate' ? 'active' : '' }}"><span>Run Migrations</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'db:seed']) }}" class="command-link {{ ($selectedCommand ?? '') === 'db:seed' ? 'active' : '' }}"><span>Seed Database</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'migrate:rollback']) }}" class="command-link {{ ($selectedCommand ?? '') === 'migrate:rollback' ? 'active' : '' }}"><span>Rollback</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'migrate:fresh']) }}" class="command-link {{ ($selectedCommand ?? '') === 'migrate:fresh' ? 'active' : '' }}"><span>Fresh Migrate</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'migrate:reset']) }}" class="command-link {{ ($selectedCommand ?? '') === 'migrate:reset' ? 'active' : '' }}"><span>Reset Migrations</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'db:wipe']) }}" class="command-link {{ ($selectedCommand ?? '') === 'db:wipe' ? 'active' : '' }}"><span>Wipe Database</span><span class="command-dot"></span></a>
                    </li>
                </ul>
            </div>

            <div class="category">
                <div class="category-title">Cache</div>
                <ul class="command-list">
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'cache:clear']) }}" class="command-link {{ ($selectedCommand ?? '') === 'cache:clear' ? 'active' : '' }}"><span>Clear Cache</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'cache:forget']) }}" class="command-link {{ ($selectedCommand ?? '') === 'cache:forget' ? 'active' : '' }}"><span>Cache Forget</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'config:cache']) }}" class="command-link {{ ($selectedCommand ?? '') === 'config:cache' ? 'active' : '' }}"><span>Cache Config</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'config:clear']) }}" class="command-link {{ ($selectedCommand ?? '') === 'config:clear' ? 'active' : '' }}"><span>Clear Config</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'route:cache']) }}" class="command-link {{ ($selectedCommand ?? '') === 'route:cache' ? 'active' : '' }}"><span>Cache Routes</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'route:clear']) }}" class="command-link {{ ($selectedCommand ?? '') === 'route:clear' ? 'active' : '' }}"><span>Clear Route Cache</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'view:clear']) }}" class="command-link {{ ($selectedCommand ?? '') === 'view:clear' ? 'active' : '' }}"><span>Clear View Cache</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'view:cache']) }}" class="command-link {{ ($selectedCommand ?? '') === 'view:cache' ? 'active' : '' }}"><span>Cache Views</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'optimize:clear']) }}" class="command-link {{ ($selectedCommand ?? '') === 'optimize:clear' ? 'active' : '' }}"><span>Clear All Cache</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'optimize']) }}" class="command-link {{ ($selectedCommand ?? '') === 'optimize' ? 'active' : '' }}"><span>Optimize App</span><span class="command-dot"></span></a>
                    </li>
                </ul>
            </div>

            <div class="category">
                <div class="category-title">Utilities</div>
                <ul class="command-list">
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'storage:link']) }}" class="command-link {{ ($selectedCommand ?? '') === 'storage:link' ? 'active' : '' }}"><span>Storage Link</span><span class="command-dot"></span></a>
                    </li>
                    <li class="command-item">
                        <a href="{{ route('command.form', ['command' => 'key:generate']) }}" class="command-link {{ ($selectedCommand ?? '') === 'key:generate' ? 'active' : '' }}"><span>Key Generate</span><span class="command-dot"></span></a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="main">
<div class="header">
    <div>
        <h1>Command Execution</h1>

        <p class="breadcrumb">
            Artisan Runner /
            <span>
                {{ $commands[$selectedCommand] ?? ucfirst($selectedCommand) }}
            </span>
        </p>
    </div>

    <div>
        <a
            href="{{ route('command.history') }}"
            class="btn"
            style="text-decoration:none;"
        >
            📋 Command History
        </a>
    </div>
</div>

            @if (session('error'))
                <div class="alert alert-error">
                    <span class="alert-icon">&#x274C;</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @isset($message)
                <div class="alert alert-{{ $status ?? 'success' }}">
                    <span class="alert-icon">{{ ($status ?? 'success') === 'success' ? '&#x2705;' : '&#x274C;' }}</span>
                    <span>{{ $message }}</span>
                </div>
            @endisset

            <div class="card">
                <div class="card-title">Command Configuration</div>
                <form action="{{ route('command.run') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="command">Command</label>
                            <select name="command" id="command" required onchange="updateHelpText()">
                                @foreach ($commands as $cmd => $label)
                                    <option value="{{ $cmd }}" {{ (old('command', $selectedCommand ?? 'migrate')) === $cmd ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="params">Parameters</label>
                            <input type="text" name="params" id="params" value="{{ old('params', $params ?? '') }}" placeholder="e.g., --force, --path=database/migrations, --step=3">
                            @if (!empty($help))
                                <div class="help-text">{{ $help }}</div>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn">
                        <span>&#9654;</span>
                        Execute Command
                    </button>
                </form>
            </div>

            @if (isset($output) && $output !== null)
                <div class="terminal">
                    <div class="terminal-header">
                        <span class="terminal-dot red"></span>
                        <span class="terminal-dot yellow"></span>
                        <span class="terminal-dot green"></span>
                        <span class="terminal-title">php artisan {{ $selectedCommand }} — output</span>
                    </div>
                    <div class="terminal-body">
                        {!! renderArtisanOutput($output ?? '', $selectedCommand ?? 'migrate', $params ?? '') !!}
                        <div class="meta">
                            @isset($duration)
                                <span>&#9201; {{ $duration }}ms</span>
                            @endisset
                            <span class="status-chip {{ ($status ?? 'success') === 'success' ? 'success' : 'error' }}">
                                {{ ($status ?? 'success') === 'success' ? 'SUCCESS' : 'FAILED' }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="terminal">
                    <div class="terminal-header">
                        <span class="terminal-dot red"></span>
                        <span class="terminal-dot yellow"></span>
                        <span class="terminal-dot green"></span>
                        <span class="terminal-title">artisan — terminal</span>
                    </div>
                    <div class="terminal-body empty">Select a command and click <strong>Execute</strong> to see output here.</div>
                </div>
            @endif

            <div class="footer">
                <span>Laravel Artisan Command Runner</span>
                <span>PHP {{ phpversion() }} / Laravel {{ app()->version() }}</span>
            </div>
        </main>
    </div>

    <script>
        const helpMap = {
            'migrate:fresh': 'Drops all tables and re-runs migrations, use --seed to run seeders.',
            'migrate:rollback': 'Rollback last batch. Use --step=N to limit steps.',
            'db:seed': 'Seed database. Use --class=SeederClass to target specific seeder.',
            'db:wipe': 'Drop all tables/views/types. Add --force to skip confirmation.',
            'cache:forget': 'Remove specific item from cache. Enter the cache key name.',
            'key:generate': 'Generate APP_KEY. Add --force to overwrite existing key.',
            'queue:work': 'Process jobs. e.g., --queue=emails --sleep=3 --tries=3',
        };

        function updateHelpText() {
            const command = document.getElementById('command').value;
            const helpEl = document.querySelector('.help-text');
            if (helpEl) {
                helpEl.textContent = helpMap[command] || 'Enter optional parameters separated by spaces.';
            }
        }

        document.getElementById('command').addEventListener('change', updateHelpText);
        updateHelpText();
    </script>
</body>
</html>
