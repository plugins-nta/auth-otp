<?php

namespace Nta\AuthOtp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nta\AuthOtp\Supports\MakeHasOtpAuthCommand;
use Nta\AuthOtp\Supports\MakeMigrateCommand;
use Nta\AuthOtp\Supports\MakeNotificationCommand;

class AuthOtpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nta:otp {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel OTP Authentication (One Time Passwords)';

    /**
     * string $moduleName;
     */
    protected $moduleName;

    /**
     * @var string
     */
    protected $pathStub = __DIR__ . '/../stubs/';

    /**
     * @var MakeMigrateCommand
     */
    protected $makeMigrate;

    /**
     * @var MakeNotificationCommand
     */
    protected $makeNotification;

    /**
     * @var MakeHasOtpAuthCommand
     */
    protected $makeHasOtpTrait;



    /**
     * AuthOtpCommand constructor.
     * @param MakeMigrateCommand $makeMigrate
     * @param MakeNotificationCommand $makeNotification
     * @param MakeHasOtpAuthCommand $makeHasOtpTrait
     */
    public function __construct(
        MakeMigrateCommand $makeMigrate,
        MakeNotificationCommand $makeNotification,
        MakeHasOtpAuthCommand $makeHasOtpTrait
    )
    {
        parent::__construct();
        $this->makeMigrate = $makeMigrate;
        $this->makeNotification = $makeNotification;
        $this->makeHasOtpTrait = $makeHasOtpTrait;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->moduleName = $this->argument('name');
        if ( !preg_match('/^[a-z0-9\-]+$/i', $this->moduleName) ) {
            $this->error('Only alphabetic characters are allowed');
            return false;
        }

        $this->line('Start generate module');
        $this->line('--------------------');

        $isGenerateMigrate = $this->makeMigrate->handle($this->moduleName);
        $infoMigrate = $isGenerateMigrate
            ? 'Generate migrations successfully'
            : 'Existing migrations cannot be created, use existing migrations';
        $this->line($infoMigrate);
        $this->line('--------------------');

        $isGenerateNotification = $this->makeNotification->handle($this->moduleName);
        $infoNotification = $isGenerateNotification
            ? 'Generate ' . Str::studly($this->moduleName) . ' module successfully'
            : 'Existing notification module cannot be created, use existing notification module';
        $this->line($infoNotification);
        $this->line('--------------------');

        $isGenerateTrait = $this->makeHasOtpTrait->handle($this->moduleName);
        $infoMigrate = $isGenerateTrait
            ? 'Generate HasOtpAuth trait successfully'
            : 'Existing HasOtpAuth trait cannot be created, use existing HasOtpAuth trait';
        $this->line($infoMigrate);
        $this->line('--------------------');
        return true;
    }
}
