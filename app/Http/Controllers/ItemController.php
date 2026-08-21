<?php

namespace App\Http\Controllers;

use App\Models\ArtisanCommandHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ItemController extends Controller
{
    /**
     * Available Artisan commands.
     */
    protected array $commands = [
        'migrate:status'    => 'Migration Status',
        'migrate'           => 'Run Migrations',
        'db:seed'           => 'Seed Database',
        'migrate:rollback'  => 'Rollback',
        'migrate:fresh'     => 'Fresh Migrate',
        'migrate:reset'     => 'Reset Migrations',
        'db:wipe'           => 'Wipe Database',
        'cache:clear'       => 'Clear Cache',
        'cache:forget'      => 'Cache Forget',
        'config:cache'      => 'Cache Config',
        'config:clear'      => 'Clear Config Cache',
        'route:cache'       => 'Cache Routes',
        'route:clear'       => 'Clear Route Cache',
        'view:clear'        => 'Clear View Cache',
        'view:cache'        => 'Cache Views',
        'optimize:clear'    => 'Clear All Cache',
        'optimize'          => 'Optimize App',
        'storage:link'      => 'Create Storage Link',
        'key:generate'      => 'Generate App Key',
    ];

    /**
     * Command help information.
     */
    protected array $commandHelp = [
        'migrate:fresh' => 'Drops all tables and re-runs all migrations. Use --seed to run seeders after.',
        'migrate:rollback' => 'Rollback last batch. Use --step=N to rollback N steps.',
        'db:seed' => 'Seed database. Use --class=SeederClass to run specific seeder.',
        'db:wipe' => 'Drop all tables, views, and types. Requires --force.',
        'cache:forget' => 'Remove item from cache. Enter cache key name in parameters.',
        'key:generate' => 'Generate APP_KEY. Use --force to overwrite existing key.',
    ];

    /**
     * Display Artisan command runner.
     */
    public function index(Request $request)
    {
        $command = $request->query('command', '');
        $params = $request->query('params', '');

        if ($command === '' || !isset($this->commands[$command])) {
            $command = 'migrate';
        }

        return view('artisan-runner', [
            'commands' => $this->commands,
            'output' => null,
            'selectedCommand' => $command,
            'params' => $params,
            'status' => 'success',
            'message' => null,
            'help' => $this->commandHelp[$command] ?? null,
        ]);
    }

    /**
     * Execute an Artisan command.
     */
    public function run(Request $request)
    {
        $request->validate([
            'command' => 'required|string',
            'params' => 'nullable|string|max:2000',
        ]);

        $command = (string) $request->input('command');

        if (!isset($this->commands[$command])) {
            return back()->with('error', 'Invalid Artisan command.');
        }

        $params = (string) ($request->input('params', '') ?? '');

        $startTime = microtime(true);

        $output = '';
        $status = 'success';
        $message = '';
        $exitCode = 0;

        try {
            /*
             * Execute the Artisan command.
             */
            $exitCode = Artisan::call(
                $command,
                $this->buildArguments($command, $params)
            );

            $output = Artisan::output();

            /*
             * Artisan commands can return a non-zero exit code
             * without throwing an exception.
             */
            if ($exitCode === 0) {
                $status = 'success';
                $message = 'Command executed successfully.';
            } else {
                $status = 'error';
                $message = 'Command failed with exit code ' . $exitCode . '.';
            }
        } catch (\Throwable $e) {
            $exitCode = $e->getCode();

            $output = trim(
                $e->getMessage()
                . "\n\n"
                . $e->getTraceAsString()
            );

            $status = 'error';
            $message = 'Command failed: ' . $e->getMessage();
        }

        $duration = round(
            (microtime(true) - $startTime) * 1000,
            2
        );

        /*
         * Save command execution history.
         */
        ArtisanCommandHistory::create([
            'command' => $command,
            'parameters' => $params !== '' ? $params : null,
            'status' => $status === 'success' ? 'success' : 'failed',
            'output' => $output,
            'duration' => $duration,
            'exit_code' => $exitCode,
        ]);

        return view('artisan-runner', [
            'commands' => $this->commands,
            'output' => $output,
            'selectedCommand' => $command,
            'params' => $params,
            'status' => $status,
            'message' => $message,
            'duration' => $duration,
            'help' => $this->commandHelp[$command] ?? null,
        ]);
    }

    /**
     * Display command execution history.
     *
     * Includes:
     * - Search
     * - Command filtering
     * - Status filtering
     * - Pagination
     */
    public function history(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', '');
        $command = (string) $request->query('command', '');

        $query = ArtisanCommandHistory::query()
            ->latest();

        /*
         * Search command and parameters.
         */
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('command', 'like', '%' . $search . '%')
                    ->orWhere('parameters', 'like', '%' . $search . '%');
            });
        }

        /*
         * Filter by status.
         */
        if (in_array($status, ['success', 'failed'], true)) {
            $query->where('status', $status);
        }

        /*
         * Filter by specific command.
         */
        if ($command !== '' && isset($this->commands[$command])) {
            $query->where('command', $command);
        }

        $histories = $query
            ->paginate(10)
            ->withQueryString();

        /*
         * Statistics.
         */
        $totalExecutions = ArtisanCommandHistory::count();

        $successfulExecutions = ArtisanCommandHistory::successful()->count();

        $failedExecutions = ArtisanCommandHistory::failed()->count();

        $averageDuration = ArtisanCommandHistory::avg('duration');

        return view('artisan-history', [
            'histories' => $histories,
            'commands' => $this->commands,
            'search' => $search,
            'status' => $status,
            'command' => $command,
            'totalExecutions' => $totalExecutions,
            'successfulExecutions' => $successfulExecutions,
            'failedExecutions' => $failedExecutions,
            'averageDuration' => $averageDuration,
        ]);
    }

    /**
     * Delete a single command execution history record.
     */
    public function deleteHistory(ArtisanCommandHistory $history)
    {
        $history->delete();

        return redirect()
            ->route('command.history')
            ->with('success', 'Command history deleted successfully.');
    }

    /**
     * Clear all command execution history.
     */
    public function clearHistory()
    {
        ArtisanCommandHistory::query()->delete();

        return redirect()
            ->route('command.history')
            ->with('success', 'All command execution history has been cleared.');
    }

    /**
     * Convert parameters into Artisan arguments.
     */
    private function buildArguments(string $command, string $params): array
    {
        $args = [];

        if (trim($params) === '') {
            if (in_array(
                $command,
                [
                    'migrate:fresh',
                    'db:wipe',
                    'migrate:reset',
                ],
                true
            )) {
                $args['--force'] = true;
            }

            return $args;
        }

        $parts = preg_split('/\s+/', trim($params)) ?: [];

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }

            if (str_starts_with($part, '--')) {
                if (str_contains($part, '=')) {
                    [$key, $value] = explode('=', $part, 2);

                    $args[trim($key)] = trim($value);
                } else {
                    $args[$part] = true;
                }
            } elseif (str_starts_with($part, '-')) {
                $args[$part] = true;
            } else {
                $args[] = $part;
            }
        }

        /*
         * Automatically add --force to destructive commands.
         */
        if (!array_key_exists('--force', $args)) {
            if (in_array(
                $command,
                [
                    'migrate:fresh',
                    'db:wipe',
                    'migrate:reset',
                ],
                true
            )) {
                $args['--force'] = true;
            }
        }

        return $args;
    }
}