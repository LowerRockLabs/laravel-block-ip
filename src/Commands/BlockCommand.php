<?php

namespace MichaelNabil230\BlockIp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use MichaelNabil230\BlockIp\Models\BlockIp;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'block-ip:block')]
class BlockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'block-ip:block {ips= : Insert new IPs in the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block all ips';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info($this->insert().' IPs blocked successfully.');
    }

    /**
     * Insert IPs into the database.
     */
    private function insert(): int
    {
        $newIps = Arr::wrap(explode(',', $this->argument('ips')));
        $oldIps = BlockIp::pluck('ip_address')->toArray();

        BlockIp::insert(array_diff($newIps, $oldIps));

        return count(array_diff($newIps, $oldIps));
    }
}
