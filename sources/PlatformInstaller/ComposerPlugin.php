<?php
/**
 * Class PlatformInstallerPlugin
 */
namespace Moro\Platform\Installer;
use \Composer\Composer;
use \Composer\IO\IOInterface;
use \Composer\Plugin\PluginInterface;
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

        for ($path = $project = __DIR__; strlen($path) > 3; $path = dirname($path))
        {
            if (file_exists($path.DIRECTORY_SEPARATOR.'composer.json'))
            {
                $project = $path;
            }
        }

        /** @noinspection PhpIncludeInspection */
        require_once(implode(DIRECTORY_SEPARATOR, [$project, 'vendor', 'leafo', 'lessphp', 'lessc.inc.php']));
    }
}
