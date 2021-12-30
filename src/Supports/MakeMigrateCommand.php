<?php

namespace Nta\AuthOtp\Supports;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeMigrateCommand extends BaseMakeCommand
{
    /**
     * @var string
     */
    protected $pathStub = __DIR__ . '/../stubs/';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle($moduleName)
    {
        $pathFolder = base_path('database/migrations/');
        if (empty(glob($pathFolder . '/*_create_notifications_table.php'))) {
            if (!File::isDirectory($pathFolder)) {
                File::makeDirectory($pathFolder, 0777, true);
            }
            $migrateTime  = now(config('app.timezone'))->format('Y_m_d_His');
            File::put($pathFolder . $migrateTime . '_create_notifications_table' . '.php', $this->buildContentStub($moduleName));
            return true;
        }
        return false;
    }

    /**
     * Get file stub
     * @return string
     */
    public function getStub()
    {
        return $this->pathStub . 'migrate.stub';
    }
}
