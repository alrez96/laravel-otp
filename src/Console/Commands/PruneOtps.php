<?php

namespace Alrez96\LaravelOtp\Console\Commands;

use Alrez96\LaravelOtp\OtpToken;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'otp:prune')]
class PruneOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune otp tokens from database that is expired or used.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldOtps = OtpToken::whereDate('expired_at', '<', Carbon::now())
            ->orWhereNotNull('used_at')->delete();

        $this->info("Found {$oldOtps} expired or used otp tokens.");
        $this->info($oldOtps ? 'All expired or used otp tokens deleted' : 'No otp tokens were deleted');

        return 0;
    }
}
