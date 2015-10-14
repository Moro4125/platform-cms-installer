<?php
/**
 * Class PlatformInstallerPlugin
 */
namespace Moro\Platform\Installer;
use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use \ComponentInstaller\Installer as ComponentInstaller;

/**
 * Class PlatformInstallerPlugin
 * @package Moro\Platform\Installer
 */
class ComposerPlugin implements PluginInterface
{
    /**
     * Called when the plugin is activated.
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new ComponentInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);

        foreach (['..', 'vendor'] as $path)
        {
            if (file_exists(__DIR__.'/../../'.$path.'/leafo/lessphp/lessc.inc.php'))
            {
                require_once($path);
                break;
            }
        }
    }
}
