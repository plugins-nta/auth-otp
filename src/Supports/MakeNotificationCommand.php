<?php

namespace Nta\AuthOtp\Supports;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeNotificationCommand extends BaseMakeCommand
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
        $pathFolder = base_path('app/Notifications/');
        $pathFile = $pathFolder . Str::studly($moduleName) . '.php';
        if (!File::isDirectory($pathFolder)) {
            File::makeDirectory($pathFolder, 0777, true);
        }
        if (file_exists($pathFile)) {
            return false;
        }
        File::put($pathFile, $this->buildContentStub($moduleName));
        return true;
    }

    /**
     * Get file stub
     * @return string
     */
    public function getStub()
    {
        return $this->pathStub . 'notification.stub';
    }
}
