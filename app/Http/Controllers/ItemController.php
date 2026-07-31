<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class ItemController extends Controller
{
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

    protected array $commandHelp = [
        'migrate:fresh'     => 'Drops all tables and re-runs all migrations. Use --seed to run seeders after.',
        'migrate:rollback'  => 'Rollback last batch. Use --step=N to rollback N steps.',
        'db:seed'           => 'Seed database. Use --class=SeederClass to run specific seeder.',
        'db:wipe'           => 'Drop all tables, views, and types. Requires --force.',
        'cache:forget'      => 'Remove item from cache. Enter cache key name in parameters.',
        'key:generate'      => 'Generate APP_KEY. Use --force to overwrite existing key.',
        'queue:work'        => 'Process queued jobs. e.g., --queue=emails --sleep=3',
    ];

    public function index(Request $request)
    {
        $command = $request->query('command', '');
        $params  = $request->query('params', '');

        if ($command === '' || !isset($this->commands[$command])) {
            $command = 'migrate';
        }

        return view('artisan-runner', [
            'commands'        => $this->commands,
            'output'          => null,
            'selectedCommand' => $command,
            'params'          => $params,
            'status'          => 'success',
            'message'         => null,
            'help'            => $this->commandHelp[$command] ?? null,
        ]);
    }

    public function run(Request $request)
    {
        $request->validate([
            'command' => 'nullable|string',
            'params'  => 'nullable|string',
        ]);

        $command = (string) ($request->input('command', 'migrate'));

        if (!isset($this->commands[$command])) {
            return back()->with('error', 'Invalid command: ' . $command);
        }

        $params = (string) ($request->input('params', '') ?? '');

        $startTime = microtime(true);
        try {
            Artisan::call($command, $this->buildArguments($command, $params));
            $output = Artisan::output();
            $status = 'success';
            $message = 'Command executed successfully.';
        } catch (\Throwable $e) {
            $output = trim($e->getMessage() . "\n\n" . $e->getTraceAsString());
            $status = 'error';
            $message = 'Command failed: ' . $e->getMessage();
        }
        $duration = round((microtime(true) - $startTime) * 1000, 2);

        return view('artisan-runner', [
            'commands'        => $this->commands,
            'output'          => $output ?? '',
            'selectedCommand' => $command,
            'params'          => $params,
            'status'          => $status,
            'message'         => $message,
            'duration'        => $duration,
            'help'            => $this->commandHelp[$command] ?? null,
        ]);
    }

    private function buildArguments(string $command, string $params): array
    {
        $args = [];

        if (trim($params) === '') {
            if (in_array($command, ['migrate:fresh', 'db:wipe', 'migrate:reset'], true)) {
                $args['--force'] = true;
            }
            return $args;
        }

        $parts = preg_split('/\s+/', trim($params)) ?: [];

        foreach ($parts as $part) {
            if ($part === '') continue;

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

        if (!array_key_exists('--force', $args)) {
            if (in_array($command, ['migrate:fresh', 'db:wipe', 'migrate:reset'], true)) {
                $args['--force'] = true;
            }
        }

        return $args;
    }
}
