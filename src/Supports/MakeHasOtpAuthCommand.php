<?php

namespace Nta\AuthOtp\Supports;

use Illuminate\Support\Facades\File;

class MakeHasOtpAuthCommand extends BaseMakeCommand
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
        $pathFolder = base_path('app/Traits/');
        $pathFile = $pathFolder . 'HasOtpAuth.php';
        if (!File::isDirectory($pathFolder)) {
            File::makeDirectory($pathFolder, 0777, true);
        }
        if (file_exists($pathFile)) {
            return false;
        }
        File::put($pathFolder . 'HasOtpAuth.php', $this->buildContentStub($moduleName));
        return true;
    }

    /**
     * Get file stub
     * @return string
     */
    public function getStub()
    {
        return $this->pathStub . 'otp-trait.stub';
    }
}
